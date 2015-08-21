<?php

class Helpers_Db_Table extends Zend_Db_Table {

    protected $_sqlType, $_sqlText, $_expectResult, $_queryResult;
    protected $_createCache, $cache; //createCache true:false, if yes, cache results in $cache
    protected $_createSource, $source; //createSource true:false, if yes, source results in $cache
    protected $_paging, $indexRows;
    public $result;
    /*
     * @todo To be written
     */

    public function sqlQuery($sqlQuery, $bindArray=array(), $expectResult=false) {

        Helpers_Watchlist::add($sqlQuery, 'Query @ ' . microtime() . ': ');

        if ($this->checkSQLType($sqlQuery) == 'select' or $expectResult)
            $this->_extractZendResult($sqlQuery, $this->getAdapter()->query($sqlQuery, $bindArray)->fetchAll(), $expectResult);
        else
            $this->_extractZendResult($sqlQuery, $this->getAdapter()->query($sqlQuery, $bindArray), $expectResult);
    }

    protected function _extractZendResult($sqlQuery, $resultRows=array(), $expectResult=false) {
        $this->result = new Helpers_Db_Result();

        /*
         * String checks, because insert and update will send arrays. 
         */
        if (is_string($sqlQuery))
            $this->result->_sqlText = $sqlQuery;
        else
            $this->result->_sqlText = '';

        $this->_prepareForResult();
        //fetch the rows


        if ($this->result->_sqlType == 'select' or $expectResult) {
            $this->result->rows = $resultRows;

            //fetch the column names from the first row
            if (count($this->result->rows) > 0) {
                foreach ($this->result->rows[0] as $fieldName => $value)
                    $this->result->fields[] = $fieldName;
            }
        }

        $this->_queryTouchUps();
        return $this->result;
    }

    public function fetchAllAndExtract($where=null, $order=null, $count=null, $offset=null) {
        $resultRows = $this->fetchAll($where, $order, $count, $offset)->toArray();
        $this->_extractZendResult('select', $resultRows, true);
    }

    public function fetchAndExtract($zendSqlObject) {
        $resultRows = $this->_fetch($zendSqlObject)->toArray();
        $this->_extractZendResult($resultRows);
    }

    protected function _prepareForResult() {
        $this->result->rowCount = 0;
        $this->result->colCount = 0;
        $this->result->rows = array();
        $this->result->fields = array();
        $this->result->_sqlType = '';
        $this->result->error = '';
        $this->result->_expectResult = false;
        $this->result->indexRows = true;
        //what is the sql type
        $sqlType = strtolower(substr($this->result->_sqlText, 0, 10));

        if (strstr($sqlType, "show datab")) {
            $this->result->_sqlType = 'show';
            $this->result->_expectResult = true;
        } else if (stristr($sqlType, "select")) {
            $this->result->_sqlType = 'select';
            $this->result->_expectResult = true;
        } else if (strstr($sqlType, "exec")) {
            $this->result->_sqlType = 'exec';
            $this->result->_expectResult = true;
        } else if (strstr($sqlType, "insert int")) {
            $this->result->_sqlType = 'insert';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "update")) {
            $this->result->_sqlType = 'update';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "delete")) {
            $this->result->_sqlType = 'delete';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "create tab")) {
            $this->result->_sqlType = 'createTable';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "create dat")) {
            $this->result->_sqlType = 'createDatabase';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "create ind")) {
            $this->result->_sqlType = 'createIndex';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "create vie")) {
            $this->result->_sqlType = 'createView';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "create use")) {
            $this->result->_sqlType = 'createUser';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "drop table")) {
            $this->result->_sqlType = 'dropTable';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "drop datab")) {
            $this->result->_sqlType = 'dropDatabase';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "drop index")) {
            $this->result->_sqlType = 'dropIndex';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "truncate")) {
            $this->result->_sqlType = 'truncate';
            $this->result->_expectResult = false;
        } else if (strstr($sqlType, "alter")) {
            $this->result->_sqlType = 'alter';
            $this->result->_expectResult = false;
        }
    }

    protected function checkSQLType($sqlQuery) {
        $sqlType = strtolower(substr($sqlQuery, 0, 10));
        if (strstr($sqlType, "show datab")) {
            return 'show';
        } else if (strstr($sqlType, "select")) {
            return 'select';
        } else if (strstr($sqlType, "exec")) {
            return 'exec';
        } else if (strstr($sqlType, "insert int")) {
            return 'insert';
        } else if (strstr($sqlType, "update")) {
            return 'update';
        } else if (strstr($sqlType, "delete")) {
            return 'delete';
        } else if (strstr($sqlType, "create tab")) {
            return 'createTable';
        } else if (strstr($sqlType, "create dat")) {
            return 'createDatabase';
        } else if (strstr($sqlType, "create ind")) {
            return 'createIndex';
        } else if (strstr($sqlType, "create vie")) {
            return 'createView';
        } else if (strstr($sqlType, "create use")) {
            return 'createUser';
        } else if (strstr($sqlType, "drop table")) {
            return 'dropTable';
        } else if (strstr($sqlType, "drop datab")) {
            return 'dropDatabase';
        } else if (strstr($sqlType, "drop index")) {
            return 'dropIndex';
        } else if (strstr($sqlType, "truncate")) {
            return 'truncate';
        } else if (strstr($sqlType, "alter")) {
            return 'alter';
        }
    }

    protected function _queryTouchUps() {
        $this->result->rowCount = count($this->result->rows);
        $this->result->colCount = count($this->result->fields);
        if ($this->_paging)
            $this->_doPaging(); //paging to extract set of records
        if ($this->_createCache)
            $this->_cacheResult(); //cache the results if asked for.
        if ($this->_createSource)
            $this->_createQuerySource(); //create datasource if asked for.
    }

    protected function _cacheResult() {
        /*
         * If asking for cache, create a new object and assign the result
         */
        if (!class_exists('Helpers_' . $this->result->_connType . '_Query'))
            eval('class Helpers_' . $this->result->_connType . '_Query {}');
        eval('$q=new Helpers_' . $this->result->_connType . '_Query;');

        $q->_sqlText = $this->result->_sqlText;
        $q->_sqlType = $this->result->_sqlType;
        $q->rows = $this->result->rows;
        $q->rowCount = $this->result->rowCount;
        $q->fields = $this->result->fields;
        $q->colCount = $this->result->colCount;
        $this->cache[] = $q; //cache in the $cache
        unset($q);
        $this->_cleanUp();
    }

    protected function _createQuerySource() {

        $this->result->source = '';
        $this->result->source = new Helpers_Db_Datasource;
        $this->result->source->indexRows = $this->result->indexRows;
        $this->result->source->rows = $this->result->rows;
        $this->result->source->rowCount = $this->result->rowCount;
        $this->result->source->fields = $this->result->fields;
        $this->result->source->colCount = $this->result->colCount;

        $this->_cleanUp();
    }

    protected function _cleanUp() {
        unset($this->result->indexRows, $this->result->rows, $this->result->rowCount, $this->result->fields, $this->result->colCount);
    }

    protected function _doPaging() {
        //extract subset
        $this->result->paging = false; //for one time processing

        $i = $this->result->pagingStart;
        for ($j = 0; $j < $this->result->pagingCount; $j++) {
            if ($this->result->rows[$i]) {
                $newSet[] = $this->result->rows[$i];
                $i++;
            }
            else
                break;
        }
        $this->result->rows = $newSet;
    }

    public function paging($count, $page=1) {
        $this->result->paging = true;
        $this->result->pagingCount = $count;
        $this->result->pagingStart = ($count * $page) - $count;
    }

    public function clear() {
        $this->clearSource();
        $this->clearCache();
        unset($this->result);
    }

    public function clearSource() {
        unset($this->result->source);
    }

    public function setCreateCache($value) {
        $this->_createCache = $value;
    }

    public function clearCache() {
        unset($this->cache);
    }

    public function getRowCount() {
        return $this->result->rowCount;
    }

    public function getDataSource() {
        if (is_object($this->result->source))
            return clone($this->result->source);
    }

    public function setCreateDataSource($value) {
        $this->_createSource = $value;
    }

}

class Helpers_Db_Result {
    
}