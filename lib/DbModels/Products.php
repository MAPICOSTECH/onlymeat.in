<?php

namespace DbModels;

class Products {

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

    public function getProductDetails($productID) {
        $sql = "SELECT * FROM products  where product_code=? LIMIT 0, 1";
        $params=[$productID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

}
