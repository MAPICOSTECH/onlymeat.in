<?php

namespace DbModels;

class OnlineOrders {

    public function __construct() {
        global $_DB;
        $this->_db = $_DB;
    }

    public function saveNewOrderHeaders($orderHeaderDetails) {
        $orderheaderSql = "INSERT INTO order_headers(cust_code,order_value,order_status,payment_type,delivery_date,delivery_address,order_datetime,sub_total,vat_percent,vat_amount,delivery_charge,delivery_time,grand_total,cre_ts) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$orderHeaderDetails['cust_code'], $orderHeaderDetails['order_value'], $orderHeaderDetails['order_status'], $orderHeaderDetails['payment_type'], $orderHeaderDetails['delivery_date'], $orderHeaderDetails['delivery_address'], $orderHeaderDetails['order_datetime'], $orderHeaderDetails['sub_total'], $orderHeaderDetails['vat_percent'], $orderHeaderDetails['vat_amount'], $orderHeaderDetails['delivery_charge'], $orderHeaderDetails['delivery_time'], $orderHeaderDetails['grand_total'], $orderHeaderDetails['cre_ts']];
        $this->_db->sqlQuery($orderheaderSql, $params);
        return $this->_db->result->lastInsertId;
    }

    public function saveProductOrder($orderDetails) {
        $orderdetail = "INSERT INTO order_details(cust_code,order_number,product_code,quantity,price,sub_total,cre_ts) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$orderDetails['cust_code'], $orderDetails['order_number'], $orderDetails['product_code'],
            $orderDetails['quantity'], $orderDetails['price'], $orderDetails['sub_total'], $orderDetails['cre_ts']];
        $this->_db->sqlQuery($orderheaderSql, $params);
    }

    public function getOrdersHistory($startDate, $endDate) {

        $sql = "select oh.order_number, oh.order_value, oh.order_datetime, oh.grand_total,
	c.first_name, c.mobile_number, ca.add1, ca.add2, ca.area, ca.landmark,
	od.product_code, od.quantity
	from order_headers oh, order_details od, customer c, customer_address ca
	where oh.cust_code=c.cust_code and ca.cust_code=c.cust_code and od.order_number=oh.order_number 
	
	order by oh.order_number desc
	";
        $this->_db->sqlQuery($sql, []);
    }

}
