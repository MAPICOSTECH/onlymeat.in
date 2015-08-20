<?php

namespace DbModels;

class ConfigurationMaster {

    public function __construct() {
        global $_DB;
        $this->_db = $_DB;
    }

    public function getCustomerDetails($mobile_number) {
        $sql = 'SELECT * FROM config_master limit 1 ';
        $this->_db->sqlQuery($sql);
        return $this->_db->result->rows;
    }

}
