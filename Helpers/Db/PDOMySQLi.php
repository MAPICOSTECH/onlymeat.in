<?php

namespace Helpers\Db;

class PDOMySQLi extends Database {

    function __construct($host = false, $user = false, $pass = false, $db = false) {
        $this->host = $host ? $host : '';
        $this->user = $user ? $user : '';
        $this->pass = $pass ? $pass : '';
        $this->db = $db ? $db : '';
        $this->_connType = 'mysqli';
    }

    public function connect() {
        try {
            $this->_conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db . ";", $this->user, $this->pass);
        } catch (\Exception $ex) {
            if ($this->_conn->connect_error) {
                $this->error = 'Connect Error (' . $this->_conn->connect_errno . ') ' . $this->_conn->connect_error;
            } else {
                throw new \Exception('Database error: ' . $ex->getMessage());
            }
        }
    }

    public function disconnect() {
        if ($this->_conn->close())
            return false;
    }

    public function sqlQuery($sqlQuery, $paramsArray = null, $indexRows = true) {
        $this->result = new \Helpers\Db\Result();
        \Helpers\Watchlist::add($sqlQuery . '<br />Params: ' . print_r($paramsArray, true), 'Query @ ' . microtime() . ': ');

        $this->_sqlText = $sqlQuery;
        $this->indexRows = true;

        $statement = $this->_conn->prepare($sqlQuery);


        if ($statement->execute($paramsArray)) {
            $this->_extractResult($statement, $indexRows);
            $status = true;
        } else {
            $errorInfo = $statement->errorInfo();
            $this->error = $errorInfo[2];
            $status = false;
            \Helpers\Watchlist::add('<span style="color:#FF0000;">' . $this->error . '</span>', 'SQL Query error: ');
        }

        return $status;
    }

    protected function _extractResult($statement, $indexRows = true) {
        $this->_prepareForResult();

        //know the type of statement.
        if ($this->_expectResult) {
            $columnCount = $statement->columnCount();
            for ($counter = 0; $counter <= $columnCount; $counter ++) {
                $meta = $statement->getColumnMeta($counter);
                $this->result->fields[] = $meta['name'];
            }

            //get the data
            $this->result->rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $statement->closeCursor();
        } else if ($this->_sqlType == 'insert' or $this->_sqlType == 'delete' or $this->_sqlType == 'update' or $this->_sqlType == 'truncate' or $this->_sqlType == 'use') {
            $this->result->affectedRows = $statement->rowCount();
            if ($this->_sqlType == 'insert') //get insert id for serial columns
                $this->result->lastInsertId = $this->_conn->lastInsertId();
        }
        $this->_queryTouchUps();
    }

}
