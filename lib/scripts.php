<?php

require('app_config.php');

require('lib/Helpers/loader.php');
require('lib/DbModels/loader.php');
require('lib/OnlyMeatHelpers/loader.php');


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