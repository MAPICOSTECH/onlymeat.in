<?php

namespace DbModels;

class OnlineOrders {

    public function __construct() {
        global $_DB;
        $this->_db = $_DB;
    }

}
