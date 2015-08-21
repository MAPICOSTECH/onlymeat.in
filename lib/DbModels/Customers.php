<?php

namespace DbModels;

class Customers {

    public function __construct() {
        global $_DB;
        $this->_db = $_DB;
    }

    public function getCustomerDetails($mobile_number) {
        $sql = 'SELECT * FROM customer WHERE mobile_number = ? limit 1 ';
        $this->_db->sqlQuery($sql, [$mobile_number]);
        return $this->_db->result;
    }

    public function addNewCustomer($customerDetails) {
        $custdetSql = "INSERT INTO customer(first_name,last_name,mobile_number,email,address_1,address_2,area,landmark,city,post_code,sts_flg,cre_ts) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $custdetParams = [
            $customerDetails['first_name'], $customerDetails['last_name'], $customerDetails['mobile_number'], $customerDetails['email'],
            $customerDetails['address_1'], $customerDetails['address_2'], $customerDetails['area'], $customerDetails['landmark'],
            $customerDetails['city'], $customerDetails['post_code'], $customerDetails['sts_flg'], $customerDetails['cre_ts']
        ];

        $this->_db->sqlQuery($custdetSql, $custdetParams);
        $custCode = $this->_db->result->lastInsertId;

        $custaddr = "INSERT INTO customer_address(cust_code,add1,add2,area,landmark,city,zipcode,cre_ts) "
                . " VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $custaddrParams = [
            $custCode, $customerDetails['add1'], $customerDetails['add2'],
            $customerDetails['area'], $customerDetails['landmark'], $customerDetails['city'],
            $customerDetails['zipcode'], $customerDetails['cre_ts'],
        ];

        $this->_db->sqlQuery($custaddr, $custaddrParams);
        return $custCode;
    }

    public function updateCustomerDetails($customerDetails) {
        $custaddr = "UPDATE customer_address SET add1=?, add2=?, area=?, landmark=?, "
                . " city=?, zipcode=?, cre_ts=?,  WHERE cust_code=? ";
        $custaddrParams = [
            $custCode, $customerDetails['add1'], $customerDetails['add2'],
            $customerDetails['area'], $customerDetails['landmark'], $customerDetails['city'],
            $customerDetails['zipcode'], $customerDetails['cre_ts'], $customerDetails['cust_code']
        ];

        $this->_db->sqlQuery($custaddr, $custaddrParams);
    }

}
