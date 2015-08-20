<?php

include('scripts.php');

$productsDb=new \DbModels\ProductDetails();

$productsList =$productsDb->getAllProductDetails();
