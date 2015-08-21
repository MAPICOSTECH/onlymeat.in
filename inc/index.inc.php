<?php

include('lib/scripts.php');

$productsDb=new \DbModels\Products();

$productsList =$productsDb->getAllProductDetails();
