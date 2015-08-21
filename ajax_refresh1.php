<?php

include('lib/scripts.php');

//get posted data
$userType = \Helpers\Request::post('userType');
$paym = \Helpers\Request::post('paym');
$deliveryType = \Helpers\Request::post('deliveryType');
$add1 = \Helpers\Request::post('add1');
$add2 = \Helpers\Request::post('add2');
$area = \Helpers\Request::post('area');
$landmark = \Helpers\Request::post('landmark');
$zipcode = \Helpers\Request::post('zipcode');
$city = \Helpers\Request::post('city');
$sts_flg = "0";
$cre_ts = date('Y-m-d H:i:s');
$delivery_address = \Helpers\Request::post('add1') . "," . \Helpers\Request::post('add2') . "," .
        \Helpers\Request::post('landmark') . "," . \Helpers\Request::post('area') . "," .
        \Helpers\Request::post('city') . "," . \Helpers\Request::post('zipcode');


//get the configurations
$config = new DbModels\ConfigurationMaster;
$customersDb = new DbModels\Customers();


//get config settings
$list = $config->getConfigSettings();

//if new user, 
if ($userType == "New User") {

    $first_name = \Helpers\Request::post('first_name');
    $last_name = \Helpers\Request::post('last_name');
    $name = $first_name;
    $email = \Helpers\Request::post('email');
    $mobile_number = \Helpers\Request::post('mobile_number1');
} else {
    $mobile_number = \Helpers\Request::post('mobile_number');
    $custId = \Helpers\Request::post("ccode");
    $name = \Helpers\Request::post('first_name');
    $email = \Helpers\Request::post('email');
}

$customerDetails = array(
    'first_name' => \Helpers\Request::post('first_name'),
    'last_name' => \Helpers\Request::post('last_name'),
    'mobile_number' => \Helpers\Request::post('mobile_number1'),
    'email' => \Helpers\Request::post('email'),
    'address_1' => \Helpers\Request::post('add1'),
    'address_2' => \Helpers\Request::post('add2'),
    'area' => \Helpers\Request::post('area'),
    'landmark' => \Helpers\Request::post('landmark'),
    'city' => \Helpers\Request::post('city'),
    'post_code' => \Helpers\Request::post('zipcode'),
    'sts_flg' => $sts_flg,
    'cre_ts' => $cre_ts,
    'cust_code' => $custId,
    'add1' => \Helpers\Request::post('add1'),
    'add2' => \Helpers\Request::post('add2'),
    'area' => \Helpers\Request::post('area'),
    'landmark' => \Helpers\Request::post('landmark'),
    'city' => \Helpers\Request::post('city'),
    'zipcode' => \Helpers\Request::post('zipcode'),
    'cre_ts' => $cre_ts,
);
//save user details
if ($userType == "New User") {
    $customersDb->addNewCustomer($customerDetails);
} else {
    $customersDb->updateCustomerDetails($customerDetails);
}


//save order details
$ordersDb = new DbModels\OnlineOrders();


$orderTotal = \Helpers\Request::post('orderTotal');
$vatPercent = $config[0]['VAT'];
$delivery_charge = \Helpers\Request::post('delivery_charge');
$delivery_time = \Helpers\Request::post('delivery_time');
$deliveryType = \Helpers\Request::post('deliveryType');

//if delivery time is now, add 2 hours. 
if (deliveryType == "2") {
    $delivery_date = \Helpers\Request::post('delivery_date');
    $delivery_time = \Helpers\Request::post('delivery_time');
} else {
    $delivery_date = date("Y-m-d");
    $delivery_time = date('H:i:s', (time() + (2 * 60 * 60))); //add 2 hours for delivery now
};

//calculate total
$order_number = \Helpers\Request::post('order_number');
$vat_amount = ($vatPercent / 100) * $orderTotal;
$grand_total = $orderTotal + $delivery_charge + $vat_amount;
$tot = $orderTotal + $delivery_charge;
$status = "Pending";
$p_type = \Helpers\Request::post('paym');

//send to db
$orderHeaderDetails = [
    'order_value' => $orderTotal,
    'cust_code' => $custId,
    'order_status' => $status,
    'payment_type' => $p_type,
    'delivery_date' => $delivery_date,
    'delivery_address' => $delivery_address,
    'order_datetime' => $cre_ts,
    'sub_total' => $orderTotal,
    'vat_percent' => $vatPercent,
    'vat_amount' => $vat_amount,
    'delivery_charge' => $delivery_charge,
    'delivery_time' => $delivery_time,
    'grand_total' => $grand_total,
    'cre_ts' => $cre_ts,
];
$newOrderID = $ordersDb->saveNewOrderHeaders($orderHeaderDetails);

//add the products ordered for this newOrderID

$products = substr(\Helpers\Request::post('products'), 1);
$qtys = substr(\Helpers\Request::post('qtys'), 1);
$prices = substr(\Helpers\Request::post('prices'), 1);
$totalPrices = substr(\Helpers\Request::post('totalPrices'), 1);
$products = explode(",", $products);
$qtys = explode(",", $qtys);
$prices = explode(",", $prices);
$totalPrices = explode(",", $totalPrices);
$i = 0;

foreach ($products as $pid) {
    $orderDetails['order_number'] = $orderId;
    $orderDetails['cust_code'] = $custId;
    $orderDetails['product_code'] = $pid;
    $orderDetails['quantity'] = $qtys[$i];
    $orderDetails['price'] = $prices[$i];
    $orderDetails['sub_total'] = $totalPrices[$i];
    //$stmt2->bindParam(':sts_flg']=$sts_flg;
    $orderDetails['cre_ts'] = $cre_ts;

    $ordersDb->saveProductOrder($orderDetails);

    $productsDb = new \DbModels\Products();
    $thisProductdetails = $productsDb->getProductDetails($pid);

    $orderedProductsList .= '
            <tr>
            <td>' . $thisProductdetails[0]['product_name'] . '</td>
                    <td> ' . $qtys[$i] . ' kg</td>
                    <td><strong>&#8377; ' . $totalPrices[$i] . '</strong></td>
              </tr>';
    $i++;
}

$subtot = $orderTotal - $delivery_charge;

//generate mail message
$mailerText = \OnlyMeatHelpers\Mailer::getOrderMailTemplateForCustomer();
$mailerText = str_replace('[[ORDER_ID]]', $orderId, $mailerText);
$mailerText = str_replace('[[CUSTOMER_NAME]]', $name, $mailerText);
$mailerText = str_replace('[[ORDER_PLACED_DATE]]', $newdelivery_date, $mailerText);
$mailerText = str_replace('[[ORDERED_PRODUCTS_LIST]]', $orderedProductsList, $mailerText);
$mailerText = str_replace('[[ORDER_SUB_TOTAL]]', $subtot, $mailerText);
$mailerText = str_replace('[[ORDER_DELIVERY_CHARGE]]', $delivery_charge, $mailerText);
$mailerText = str_replace('[[ORDER_TOTAL]]', $orderTotal, $mailerText);
$mailerText = str_replace('[[MOBILE_ADDRESS]]', \Helpers\Request::post('mobile_number1'), $mailerText);
$mailerText = str_replace('[[ORDER_DELIVERY_ADDRESS]]', $delivery_address, $mailerText);
$mailerText = str_replace('[[ORDER_DELIVERY_DATE_TIME]]', \Helpers\Request::post('delivery_date') .
        ' - ' . $delivery_time, $mailerText);

$subject = 'Your order detail';
\OnlyMeatHelpers\Mailer::sendMail('sales@onlymeat.in', $email, $subject, $mailerText);


$returnMessage = "Thank you, " . $name . " \n Your order (#" . $orderId . ") has been successfully placed.";
echo json_encode(['msg' => $returnMessage]);
