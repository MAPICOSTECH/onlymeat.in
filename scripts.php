<?php

require('db_config.php');

require('Helpers/loader.php');
require('DbModels/loader.php');


//connect to db
global $_DB;
try {
    $_DB = new \Helpers\Db\PDOMySQLi(APP_DB_HOST, APP_DB_USERNAME, APP_DB_PASSWORD, APP_DB_GEOMETRY);
    $_DB->connect();
} catch (\Exception $ex) {
    die('Error: ' . $ex->getMessage());
}

date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL & ~E_NOTICE);