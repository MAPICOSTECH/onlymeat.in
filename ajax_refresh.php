<?php

include('scripts.php');

$customersDb = new \DbModels\Customers();

$customerDetails = $customersDb->getCustomerDetails(\Helpers\Request::post('mobile_number'));

$output = [
    'msg' => '<h1  style="font-size:25px; color:#0C3; font-weight:bold;">Welcome ' . $customerDetails[0]["first_name"] . '</h1>',
    "cust_code" => $customerDetails[0]["cust_code"],
    "first_name" => $customerDetails[0]["first_name"],
    "address_1" => $customerDetails[0]["address_1"],
    "email" => $customerDetails[0]["email"],
    "mobile_number" => $customerDetails[0]["mobile_number"],
    "address_2" => $customerDetails[0]["address_2"],
    "landmark" => $customerDetails[0]["landmark"],
    "city" => $customerDetails[0]["city"],
    "post_code" => $customerDetails[0]["post_code"]
];
echo json_encode($output);
