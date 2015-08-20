<?php

namespace DbModels;

class ProductDetails {

    public function __construct() {
        global $_DB;
        $this->_db = $_DB;
    }

    public function getAllProductDetails() {
        $sql = "select * from products where status = ?";
        $params = ['1'];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

}
