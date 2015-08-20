<?php

namespace Helpers\Db;

class Database {

    protected $_conn, $_connType;
    protected $_sqlType, $_sqlText, $_expectResult, $_queryResult;
    public $createCache, $cache; //createCache- true:false, if yes, cache results in $cache
    public $createSource, $source; //createSource-  true:false, if yes, source results in $cache

    public function connect() {
        
    }

    public function disconnect() {
        
    }

    public function query($sql) {
        
    }

    protected function _extractResult($param1, $param2) {
        
    }

    protected function _prepareForResult() {
        $this->rowCount = 0;
        $this->colCount = 0;
        $this->rows = array();
        $this->fields = array();
        $this->_sqlType = '';
        $this->error = '';
        $this->_expectResult = false;
        //what is the sql type
        //echo $this->_sqlText;
        $sqlType = strtolower(substr($this->_sqlText, 0, 10));

        if (strstr($sqlType, "show datab")) {
            $this->_sqlType = 'show';
            $this->_expectResult = true;
        } else if (strstr($sqlType, "select")) {
            $this->_sqlType = 'select';
            $this->_expectResult = true;
        } else if (strstr($sqlType, "exec")) {
            $this->_sqlType = 'exec';
            $this->_expectResult = true;
        } else if (strstr($sqlType, "insert int")) {
            $this->_sqlType = 'insert';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "update")) {
            $this->_sqlType = 'update';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "delete")) {
            $this->_sqlType = 'delete';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "create tab")) {
            $this->_sqlType = 'createTable';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "create dat")) {
            $this->_sqlType = 'createDatabase';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "create ind")) {
            $this->_sqlType = 'createIndex';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "create vie")) {
            $this->_sqlType = 'createView';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "create use")) {
            $this->_sqlType = 'createUser';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "drop table")) {
            $this->_sqlType = 'dropTable';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "drop datab")) {
            $this->_sqlType = 'dropDatabase';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "drop index")) {
            $this->_sqlType = 'dropIndex';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "truncate")) {
            $this->_sqlType = 'truncate';
            $this->_expectResult = false;
        } else if (strstr($sqlType, "alter")) {
            $this->_sqlType = 'alter';
            $this->_expectResult = false;
        }
    }

    protected function _queryTouchUps() {
        $this->result->prepare();

        if ($this->_paging)
            $this->_doPaging(); //paging to extract set of records
        if ($this->_createCache)
            $this->_cacheResult(); //cache the results if asked for.
    }

    protected function _cacheResult() {
        if (!class_exists($this->_connType . 'Query'))
            eval('class ' . $this->_connType . 'Query {}');
        eval('$q=new ' . $this->_connType . 'Query;');

        $q->_sqlText = $this->_sqlText;
        $q->_sqlType = $this->_sqlType;
        $q->rows = $this->rows;
        $q->rowCount = $this->rowCount;
        $q->fields = $this->fields;
        $q->colCount = $this->colCount;
        $this->cache[] = $q; //cache in the $cache
        unset($q);
        $this->_cleanUp();
    }

    protected function _createQuerySource() {
        $this->source = '';
        $this->source = new Datasource;
        $this->source->indexRows = $this->indexRows;
        $this->source->rows = $this->rows;
        $this->source->rowCount = $this->rowCount;
        $this->source->fields = $this->fields;
        $this->source->colCount = $this->colCount;
        $this->_cleanUp();
    }

    protected function _cleanUp() {
        unset($this->_sqlType, $this->_sqlText);
        unset($this->rows, $this->rowCount, $this->fields, $this->colCount);
    }

    protected function _doPaging() {
        //extract subset
        $this->paging = false; //for one time processing
//		pre($this);
        $i = $this->pagingStart;
        for ($j = 0; $j < $this->pagingCount; $j++) {
            if ($this->rows[$i]) {
                $newSet[] = $this->rows[$i];
                $i++;
            } else
                break;
        }
        $this->rows = $newSet;
    }

    public function paging($count, $page = 1) {
        $this->paging = true;
        $this->pagingCount = $count;
        $this->pagingStart = ($count * $page) - $count;
    }

    public function clear() {
        $this->clearSource();
        $this->clearCache();
        unset($this->rows, $this->rowCount, $this->fields, $this->colCount);
    }

    public function clearSource() {
        unset($this->source);
    }

    public function clearCache() {
        unset($this->cache);
    }

}
