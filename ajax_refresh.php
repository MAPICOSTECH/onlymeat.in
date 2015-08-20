<?php

/*

* Author : Developer Dev

* Subject :  PHP/MySQL and jQuery

*/



// PDO connect *********
date_default_timezone_set("Asia/Calcutta");
function connect() {

    return new PDO('mysql:host=localhost;dbname=mapicosi_onlymeatdev', 'mapicosi_onlypro', 'LNS0C{59m2w(', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}



$pdo = connect();

$mobile_number = $_POST['mobile_number'];

$sql = "SELECT * FROM customer WHERE mobile_number = $mobile_number limit 1 ";

$query = $pdo->prepare($sql);

$query->execute();

$list = $query->fetchAll();

//print_r($list);

foreach ($list as $rs) 

{

	$msg = '<h1  style="font-size:25px; color:#0C3; font-weight:bold;">Welcome '.$rs["first_name"].'</h1>';

	$output = array("msg"=>$msg,"cust_code"=>$rs["cust_code"],"first_name"=>$rs["first_name"], "address_1"=>$rs["address_1"],"email"=>$rs["email"],"mobile_number"=>$rs["mobile_number"],"address_2"=>$rs["address_2"],"landmark"=>$rs["landmark"],"city"=>$rs["city"],"post_code"=>$rs["post_code"]);

	

}

echo json_encode($output);

?>