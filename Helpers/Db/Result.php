<?php
namespace Helpers\Db;

class Result {

    public function __construct($id = false) {
        if ($id)
            $this->id = $id;
        $this->reset();
    }

    public function reset() {
        $this->rowCount = 0;
        $this->colCount = 0;
        $this->rows = array();
        $this->fields = array();

        $this->sqlType = '';
        $this->expectResult = false;

        $this->error = '';
        $this->indexRows = true;
    }

    public function setSqlText($sqlText) {
        $this->_sqlText = $sqlText;
    }

    public function checkSQLType() {
        $sqlType = strtolower(substr($this->_sqlText, 0, 10));

        if (strstr($sqlType, "show datab")) {
            $this->sqlType = 'show';
        } else if (strstr($sqlType, "select")) {
            $this->sqlType = 'select';
        } else if (strstr($sqlType, "exec")) {
            $this->sqlType = 'exec';
        } else if (strstr($sqlType, "insert int")) {
            $this->sqlType = 'insert';
        } else if (strstr($sqlType, "update")) {
            $this->sqlType = 'update';
        } else if (strstr($sqlType, "delete")) {
            $this->sqlType = 'delete';
        } else if (strstr($sqlType, "create tab")) {
            $this->sqlType = 'createTable';
        } else if (strstr($sqlType, "create dat")) {
            $this->sqlType = 'createDatabase';
        } else if (strstr($sqlType, "create ind")) {
            $this->sqlType = 'createIndex';
        } else if (strstr($sqlType, "create vie")) {
            $this->sqlType = 'createView';
        } else if (strstr($sqlType, "create use")) {
            $this->sqlType = 'createUser';
        } else if (strstr($sqlType, "drop table")) {
            $this->sqlType = 'dropTable';
        } else if (strstr($sqlType, "drop datab")) {
            $this->sqlType = 'dropDatabase';
        } else if (strstr($sqlType, "drop index")) {
            $this->sqlType = 'dropIndex';
        } else if (strstr($sqlType, "truncate")) {
            $this->sqlType = 'truncate';
        } else if (strstr($sqlType, "alter")) {
            $this->sqlType = 'alter';
        }

        if (in_array($this->sqlType, array('show', 'select', 'exec'))) {
            $this->expectResult = true;
        }
        else
            $this->expectResult = false;
    }

    public function getSqlType() {
        $this->sqlType = $this->checkSQLType();
        return $this->sqlType;
    }

    public function addRow($associativeArray) {
        $this->rows[] = $associativeArray;
    }

    public function prepare() {
        $this->checkSQLType();
        $this->rowCount = count($this->rows);

        /* if there are any rows */
        if ($this->rowCount > 0) {

            /* know the field names from the first row */
            $this->fields = array_keys($this->rows[0]);

            $this->colCount = count($this->fields);
        }
    }

    public function getResultAsDatasource() {
        $this->prepare();
        return $this;
    }

    public function getRowCount() {
        return $this->rowCount;
    }

}