<?php
include('../db_config.php');
include('../Helpers/loader.php');
error_reporting(E_ALL & ~E_NOTICE);

 $_DB = new \Helpers\Db\PDOMySQLi($host, $user, $pass, $dbname);
    $_DB->connect();
	$date=date('Y-m-d');
	$sql="select oh.order_number, oh.order_value, oh.order_datetime, oh.grand_total,
	c.first_name, c.mobile_number, ca.add1, ca.add2, ca.area, ca.landmark,
	od.product_code, od.quantity
	from order_headers oh, order_details od, customer c, customer_address ca
	where oh.cust_code=c.cust_code and ca.cust_code=c.cust_code and od.order_number=oh.order_number 
	
	order by oh.order_number desc
	";
	$_DB->sqlQuery($sql);
	
	
	$dg=new \Helpers\Datagrid;
	$dg->setDatasource($_DB->result);
	
	$dg->render();
	