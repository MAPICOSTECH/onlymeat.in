<?php

namespace Helpers\Db;

class MySQLi extends Database {

    function __construct($host = false, $user = false, $pass = false, $db = false) {
        $this->host = $host ? $host : '';
        $this->user = $user ? $user : '';
        $this->pass = $pass ? $pass : '';
        $this->db = $db ? $db : '';
        $this->_connType = 'mysqli';
    }

    public function connect() {
        $this->_conn = new \mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->_conn->connect_error) {
            $this->error = 'Connect Error (' . $this->_conn->connect_errno . ') ' . $this->_conn->connect_error;
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

        $statement = $this->_conn->stmt_init();

        $statement->prepare($this->_sqlText);
        if ($paramsArray != null) {
            $paramsRefArray = array();
            foreach ($paramsArray as $key => $value)
                $paramsRefArray[] = &$paramsArray[$key];

            \call_user_func_array(array($statement, "bind_param"), $paramsRefArray);
        }
        $statement->execute();
        if ($statement->error != '') {
            $this->error = $statement->error;
            $status = false;
            \Helpers\Watchlist::add('<span style="color:#FF0000;">' . $this->error . '</span>', 'SQL Query error: ');
        } else {
            $this->_extractResult($statement, $indexRows);
            $status = true;
        }

        return $status;
    }

    protected function _extractResult($statement, $indexRows = true) {
        $this->_prepareForResult();

        //know the type of statement.
        if ($this->_expectResult) {
            //know the fields
            $metaResults = $statement->result_metadata();
            $this->result->fields[] = $metaResults->fetch_fields();

            //get the data
            while ($row = $statement->fetch()) {
                $rowValues = array();
                foreach ($row as $key => $value) {
                    if ($indexRows) {
                        $rowValues[$key] = $value;
                    } else {
                        $rowValues[] = $value;
                    }
                }
                $this->result->rows[] = $rowValues;
            }

            mysqli_free_result($this->_queryResult);
        } else if ($this->_sqlType == 'insert' or $this->_sqlType == 'delete' or $this->_sqlType == 'update' or $this->_sqlType == 'truncate' or $this->_sqlType == 'use') {
            $this->affectedRows = $this->_conn->affected_rows;
            if ($this->_sqlType == 'insert') //get insert id for serial columns
                $this->insertID = $this->_conn->insert_id;
        }
        $this->_queryTouchUps();
    }

}
