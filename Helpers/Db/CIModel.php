<?php

class Helpers_Db_CIModel extends CI_Model {

    protected $_sqlType, $_sqlText, $_expectResult, $_queryResult;
    protected $_createCache, $cache; //createCache true:false, if yes, cache results in $cache
    protected $_paging, $indexRows;
    public $result;

    public function __construct() {
        parent::__construct();
    }

    public function sqlQuery($sqlQuery, $bindArray = array(), $expectResult = false) {

        Helpers_Watchlist::add($sqlQuery, 'Query @ ' . microtime() . ': ');

        $queryResult = $this->db->query($sqlQuery, $bindArray);
        $this->_extractCIResult($sqlQuery, $queryResult, $expectResult);
    }

    protected function _extractCIResult($sqlQuery, $queryResult, $expectResult = false) {

        $this->result = new Helpers_Db_Result();

        /*
         * String checks, because insert and update will send arrays.
         */
        if (is_string($sqlQuery))
            $this->result->setSqlText($sqlQuery);
        else
            $this->result->setSqlText('');

        $this->result->reset();
        $sqlType = $this->result->getSQLType();

        //fetch the rows
        if ($sqlType == 'select' or $this->result->expectResult) {
            foreach ($queryResult->result_array() as $rowArray) {
                $this->result->addRow($rowArray);
            }
        }

        $this->_queryTouchUps();
        return $this->result;
    }

    protected function _queryTouchUps() {
        $this->result->prepare();

        if ($this->_paging)
            $this->_doPaging(); //paging to extract set of records
        if ($this->_createCache)
            $this->_cacheResult(); //cache the results if asked for.
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

    protected function _cleanUp() {
        $this->result->reset();
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

    public function paging($count, $page = 1) {
        $this->result->paging = true;
        $this->result->pagingCount = $count;
        $this->result->pagingStart = ($count * $page) - $count;
    }

    public function clear() {
        $this->clearCache();
        unset($this->result);
    }

    public function setCreateCache($value) {
        $this->_createCache = $value;
    }

    public function clearCache() {
        unset($this->cache);
    }

    public function getDataSource() {
        return $this->result->getResultAsDatasource();
    }

}