<?php

include('../lib/scripts.php');
$ordersDb = new \DbModels\OnlineOrders();

$ordersTillNowDs = $ordersDb->getOrdersHistory($startDate, $endDate);

$startDate = date('Y-m-d');
$endDate = date('Y-m-d');


$dg = new \Helpers\Datagrid;
$dg->setDatasource($ordersTillNowDs);

$dg->render();
