<?php

include('scripts.php');

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
$delivery_address = \Helpers\Request::post('add1') . "," . \Helpers\Request::post('add2') . "," . \Helpers\Request::post('landmark') . "," . \Helpers\Request::post('area') . "," . \Helpers\Request::post('city') . "," . \Helpers\Request::post('zipcode');


//get the configurations
$config = new DbModels\ConfigurationMaster;
$customersDb = new DbModels\Customers();



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
        'first_name' => \Helpers\Requestpost('first_name'),
        'last_name' => \Helpers\Requestpost('last_name'),
        'mobile_number' => \Helpers\Requestpost('mobile_number1'),
        'email' => \Helpers\Requestpost('email'),
        'address_1' => \Helpers\Requestpost('add1'),
        'address_2' => \Helpers\Requestpost('add2'),
        'area' => \Helpers\Requestpost('area'),
        'landmark' => \Helpers\Requestpost('landmark'),
        'city' => \Helpers\Requestpost('city'),
        'post_code' => \Helpers\Requestpost('zipcode'),
        'sts_flg' => $sts_flg,
        'cre_ts' => $cre_ts,
        'cust_code' => $custId,
        'add1' => \Helpers\Requestpost('add1'),
        'add2' => \Helpers\Requestpost('add2'),
        'area' => \Helpers\Requestpost('area'),
        'landmark' => \Helpers\Requestpost('landmark'),
        'city' => \Helpers\Requestpost('city'),
        'zipcode' => \Helpers\Requestpost('zipcode'),
        'cre_ts' => $cre_ts,
    );
if ($userType == "New User") {
    $customersDb->addNewCustomer($customerDetails);
} else {
    $customersDb->updateCustomerDetails($customerDetails);
}






# connect to the database
try {

    $orderheader = "INSERT INTO order_headers(cust_code,order_value,order_status,payment_type,delivery_date,delivery_address,order_datetime,sub_total,vat_percent,vat_amount,delivery_charge,delivery_time,grand_total,cre_ts) VALUES (:cust_code,:order_value,:order_status,:payment_type,:delivery_date,:delivery_address,:order_datetime,:sub_total,:vat_percent,:vat_amount,:delivery_charge,:delivery_time,:grand_total,:cre_ts)";
    $orderdetail = "INSERT INTO order_details(cust_code,order_number,product_code,quantity,price,sub_total,cre_ts) VALUES (:cust_code,:order_number,:product_code,:quantity,:price,:sub_total,:cre_ts)";
    /*     * * prepare the SQL statement ** */
    $stmt3 = $DBH->prepare($orderheader);
    $stmt4 = $DBH->prepare($orderdetail);
    # orderheader
    /*     * * bind the parameters ** */
    //foreach($prices as $price)
    //{
    $orderTotal = \Helpers\Request::post('orderTotal'];
    $vatPercent = $list[0]['VAT'];
    //$delivery_charge =$list[0]['delivery_chrg'];
    $delivery_charge = \Helpers\Request::post('delivery_charge'];
    $delivery_time = \Helpers\Request::post('delivery_time'];
    $deliveryType = \Helpers\Request::post('deliveryType'];
    print_r($deliveryType);
    if (deliveryType == "2") {
        $delivery_time = \Helpers\Request::post('delivery_time'];
        $delivery_date = \Helpers\Request::post('delivery_date'];
    } else {
        $delivery_date = date("Y-m-d");
        $delivery_time = date('H:i:s', (time() + (2 * 60 * 60)));
    };
    //$newdelivery_date= date("Y-m-d");					
    //$delivery_time1= date('H:i:s', (time()+(2*60*60)));
    $order_number = \Helpers\Request::post('order_number'];
    $vat_amount = ($list[0]['VAT'] / 100) * $orderTotal;
    $grand_total = $orderTotal + $delivery_charge + $vat_amount;
    $tot = $orderTotal + $delivery_charge;
    $status = "Pending";
    $p_type = \Helpers\Request::post('paym'];
    $stmt3->bindParam(':order_value', $orderTotal, PDO::PARAM_STR);
    $stmt3->bindParam(':cust_code', $custId, PDO::PARAM_STR);
    $stmt3->bindParam(':order_status', $status, PDO::PARAM_STR);
    $stmt3->bindParam(':payment_type', $p_type, PDO::PARAM_STR);
    $stmt3->bindParam(':delivery_date', $delivery_date, PDO::PARAM_STR);
    $stmt3->bindParam(':delivery_address', $delivery_address, PDO::PARAM_STR);
    $stmt3->bindParam(':order_datetime', $cre_ts, PDO::PARAM_STR);
    $stmt3->bindParam(':sub_total', $orderTotal, PDO::PARAM_STR);
    $stmt3->bindParam(':vat_percent', $vatPercent, PDO::PARAM_STR);
    $stmt3->bindParam(':vat_amount', $vat_amount, PDO::PARAM_STR);
    $stmt3->bindParam(':delivery_charge', $delivery_charge, PDO::PARAM_STR);
    $stmt3->bindParam(':delivery_time', $delivery_time, PDO::PARAM_STR);
    $stmt3->bindParam(':grand_total', $grand_total, PDO::PARAM_STR);
    //$stmt2->bindParam(':sts_flg', $sts_flg, PDO::PARAM_STR);
    $stmt3->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);
    /*     * * execute the prepared statement ** */
    $stmt3->execute();
    $orderId = $DBH->lastInsertId();
    //}
    # orderdetail
    /*     * * bind the parameters ** */
    $products = substr(\Helpers\Request::post('products'], 1);
    $qtys = substr(\Helpers\Request::post('qtys'], 1);
    $prices = substr(\Helpers\Request::post('prices'], 1);
    $totalPrices = substr(\Helpers\Request::post('totalPrices'], 1);
    $products = explode(",", $products);
    $qtys = explode(",", $qtys);
    $prices = explode(",", $prices);
    $totalPrices = explode(",", $totalPrices);
    $i = 0;
    foreach ($products as $pid) {
        $stmt4->bindParam(':order_number', $orderId, PDO::PARAM_STR);
        $stmt4->bindParam(':cust_code', $custId, PDO::PARAM_STR);
        $stmt4->bindParam(':product_code', $pid, PDO::PARAM_STR);
        $stmt4->bindParam(':quantity', $qtys[$i], PDO::PARAM_STR);
        $stmt4->bindParam(':price', $prices[$i], PDO::PARAM_STR);
        $stmt4->bindParam(':sub_total', $totalPrices[$i], PDO::PARAM_STR);
        //$stmt2->bindParam(':sts_flg', $sts_flg, PDO::PARAM_STR);
        $stmt4->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);
        /*         * * execute the prepared statement ** */
        $stmt4->execute();
        $sql = "SELECT * FROM products  where product_code='$pid' LIMIT 0, 1";
        $query = $DBH->prepare($sql);
        $query->execute();
        $list1 = $query->fetchAll();
        $messagepre .= '
					<tr>
        				<td>' . $list1[0]['product_name'] . '</td>
						<td> ' . $qtys[$i] . ' kg</td>
						<td><strong>&#8377; ' . $totalPrices[$i] . '</strong></td>
					  </tr>
					
					';
        $i++;
    }
    //}	
    $msg = "Thank you, " . $name . " \n Your order (#" . $orderId . ") has been successfully placed.";
    //$DBH->commit();

    $output = array("msg" => $msg);
    $to = $email;
    $subject = 'Your order detail';
    // Always set content-type when sending HTML email
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    // More headers
    $headers .= 'From: <sales@onlymeat.in>' . "\r\n";
    $headers = "From: <sales@onlymeat.in>" . "\r\n";
    $headers .= "Reply-To:  <sales@onlymeat.in>" . "\r\n";
    $headers .= 'Cc: kris@mapicos.com' . "\r\n";
    //$headers .= "CC: sales@onlymeat.in\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Order Confirmation - Your Order with Onlymeat.in [#404-0232994-4273140] has been successfully placed!</title>
			<link href="http://www.ayushmantechnology.com/onlymeat/css/order.css" rel="stylesheet" type="text/css" />

			</head><body style="
				margin-top: 0px;
				margin-bottom: 0px;
				font-family: "zonaprouploaded_file";
			">';
    $message .= '<div id="main" style="height: 1400px;
				width: 720px;
				margin-right: auto;
				margin-left: auto;
				border: 1px solid #E3000F;
				padding-bottom: 0px;
				color: #333;
			"><div id="top-header"></div>
			<div id="header-main" style="height: 100px;
				width: 720px;
				border-bottom-width: 5px;
				border-bottom-style: solid;
				border-bottom-color: #ffed00;
				background-color: #e3000f;">
				
				<div id="logo" style="height: 100px;
				width: 125px;
				background-image: url(http://www.ayushmantechnology.com/onlymeat/images/logo.png);
				background-repeat: no-repeat;
				background-position: center center;
				margin-left: 34px;
				float: left;"></div><div id="top-header-right" style="background-image: url(http://www.ayushmantechnology.com/onlymeat/images/header-icons.png);
				background-repeat: no-repeat;
				background-position: center center;
				float: right;
				height: 100px;
				width: 270px;
				margin-right: 64px;"></div>
			  </div>
			';
    $message .= '<div id="order-number" style="height: 70px;
				width: 720px;"><div id="order-num" style="float: right;
				height: 50px;
				width: 350px;
				margin-top: 10px;
				margin-right: 30px;
				margin-bottom: 10px;
				line-height: 0px;
				text-align: right;"><h2 style="font-weight: bold;
				color: #333;
				font-size: 20px;
				margin-top: 10px;
				margin-bottom: 10px;">Order Confirmation</h2><h3 style="font-size: 18px;
				color: #666666;
				font-weight: 400;
				margin-bottom: 10px;
				margin-top: 25px;">Order <font color="#e3000f">#' . $orderId . '</font></h3>
				</div></div>';
    $message .= '<div id="welcome-text" style="    height: auto;
				width: 660px;
				float: left;
				padding-right: 30px;
				padding-left: 30px;
				padding-top: 20px;
				padding-bottom: 20px;"><h5 style="font-size: 16px;
				font-weight: bold;
				color: #E3000F;
				text-transform: capitalize;
				margin-bottom: 5px;
				margin-top: 0px;">Hello ' . $name . ',</h5>
				<p style="font-size: 14px;
				color: #666;
				margin-top: 0px;
				margin-bottom: 15px;
				text-align: justify;
				line-height: 20px;">Thank you for your order. This e-mail confirms that we ve received your order.<br/><br/>
				If you would like to know the status of your order or make any changes to it, <br/>
				please Call us on <font color="#e3000f"><strong>+91-94 93 92 25 25</strong></font>.
				</p>
			  </div>';
    $message .= '  <div id="order-detailes" style="height: auto;
				width: 660px;
				float: left;
				background-color: #E6E7E8;
				border-top-width: 1px;
				border-bottom-width: 1px;
				border-top-style: solid;
				border-bottom-style: solid;
				border-top-color: #e3000f;
				border-bottom-color: #e3000f;
				padding-top: 19px;
				padding-right: 30px;
				padding-bottom: 19px;
				padding-left: 30px;">
				<h5 style="font-size: 16px;
				font-weight: bold;
				color: #E3000F;
				text-transform: capitalize;
				margin-bottom: 5px;
				margin-top: 0px;">Order Details</h5>
				
				<h6  style="color: #221e1e;
				font-size: 14px;
				margin-bottom: 15px;
				line-height: 20px;
				margin-top: 10px;
				font-weight: normal;">Order ID <font color="#e3000f">#' . $orderId . '</font>  |  Placed on:' . $newdelivery_date . '</h6><table width="660" border="1" class="hovertable" style="font-size: 14px;
				color: #333333;
				border-width: 0px;
				border-color: #E3000F;
				border-collapse: collapse;">
				  <tr>
					
					<td width="114"><strong>Item Name</strong></td>
					<td width="94"><strong>Quantity</strong></td>
					<td width="96"><strong>Price</strong></td>
				  </tr>
				  ' . $messagepre . '
				</table></div>';
    $subtot = $orderTotal - $delivery_charge;
    $message .= '
			 <div id="order-total" style="height: auto;
				width: 660px;
				float: left;
				padding-top: 19px;
				padding-right: 30px;
				padding-bottom: 19px;
				padding-left: 30px;
				border-bottom-width: 1px;
				border-bottom-style: solid;
				border-bottom-color: #E3000F;"></div><div id="download-app" style="float: left;
				height: 120px;
				width: 400px;
				background-image: url(http://www.ayushmantechnology.com/onlymeat/images/app.png);
				background-repeat: no-repeat;
				background-position: center center;"></div><div id="total-price" style="float: left;
				height: 120px;
				width: 260px;">
				  <table width="100%" class="hovertable1" style="font-size: 14px;
				color: #333333;
				border-width: 0px;">
					  <tr>
						<td width="66%">Item Subtotal</td>
						<td width="9%">:</td>
						<td width="25%"><strong>&#8377; ' . $subtot . '</strong></td>
					</tr>
					  <tr>
						<td>Delivery Charges</td>
						<td>:</td>
						<td><strong>&#8377; ' . $delivery_charge . '</strong></td>
					</tr>
					  <tr>
						<td><strong>Order Total</strong></td>
						<td>:</td>
						<td><strong>&#8377; ' . $orderTotal . '</strong></td>
					</tr>    	  
				  </table>
				</div>';
    $message .= '<div id="order-delivery" style="height: auto;
				width: 660px;
				float: left;
				padding-top: 19px;
				padding-right: 30px;
				padding-bottom: 19px;
				padding-left: 30px;
				border-bottom-width: 1px;
				border-bottom-style: solid;
				border-bottom-color: #E3000F;">
				<div id="delivery-heading" style="width: 660px;
				float: left;
				line-height: 40px;
				text-align: left;
				height: 40px;
				border-bottom-width: 1px;
				border-bottom-style: dashed;
				border-bottom-color: #ED3237;"><h5 style="font-size: 16px;
				font-weight: bold;
				color: #E3000F;
				text-transform: capitalize;
				margin-bottom: 5px;
				margin-top: 0px;">Delivery Address</h5></div>
				<div id="delivery-adress" style="float: left;
				height: auto;
				width: 419px;
				border-right-width: 1px;
				border-right-style: dashed;
				border-right-color: #ED3237;">    	   	  
				  <table width="100%" class="hovertable1" style="font-size: 14px;
				color: #333333;
				border-width: 0px;">
					  <tr>
						<td width="31%"><strong>' . $name . '</strong></td>
						<td width="6%"><strong>:</strong></td>
						<td width="63%"><strong>' . \Helpers\Request::post('mobile_number1'] . '</strong></td>
					  </tr>
					  <tr>
						<td colspan="3">
					   ' . $delivery_address . '</td>
					  </tr>
					  <tr>
						<td colspan="3"><strong>Scheduled Delivery : ' . \Helpers\Request::post('delivery_date'] . ' - ' . $delivery_time . '</strong></td>
					  </tr>
				  </table>
				</div>
				<div id="logo-red" style="float: left;
				height: 120px;
				width: 240px;
				background-image: url(http://www.ayushmantechnology.com/onlymeat/images/logo-red.png);
				background-repeat: no-repeat;
				background-position: center center;"></div>
			  </div>';
    $message .= ' <div id="process" style="    height: auto;
				width: 660px;
				float: left;
				padding-top: 19px;
				padding-right: 30px;
				padding-bottom: 19px;
				padding-left: 30px;
				border-bottom-width: 1px;
				border-bottom-style: solid;
				border-bottom-color: #E3000F;
				background-color: #E6E7E8;">
				<div id="process-img" style="float: left;
				height: 120px;
				width: 660px;
				background-image: url(http://www.ayushmantechnology.com/onlymeat/images/process.png);
				background-repeat: no-repeat;
				background-position: center center;"></div>
			  </div><div id="main" style="height: 1400px;
				width: 720px;
				margin-right: auto;
				margin-left: auto;
				border: 1px solid #E3000F;
				padding-bottom: 0px;
				color: #333;
			"><div id="top-header"></div>';
    $message .= '<div id="notify-text" style="height: auto;
				width: 660px;
				float: left;
				padding-right: 30px;
				padding-left: 30px;
				padding-top: 20px;
				padding-bottom: 20px;
				font-size: 12px;
				color: #666;">
				Need to make changes to your order? please Call us on <font color="#e3000f"><strong>+91-94 93 92 25 25</strong></font><br/><br/>
				We hope to see you again soon.
			  </div>';
    $message .= '<div id="fresh-by-order" style="height: auto;
				width: 660px;
				float: left;
				padding-right: 30px;
				padding-left: 30px;
				padding-top: 20px;
				padding-bottom: 20px;
				font-size: 12px;
				background-image: url(http://www.ayushmantechnology.com/onlymeat/images/fesh-by-order.png);
				background-repeat: no-repeat;
				background-position: center center;"></div>
			  <div id="bottom-menu" style="height: 40px;
				width: 530px;
				margin-right: 95px;
				margin-left: 95px;
				float: left;
				margin-top: 15px;
				margin-bottom: 10px;
				border-top-width: 1px;
				border-top-style: dotted;
				border-top-color: #ED3237;
				line-height: 40px;
				text-align: center;
				font-size: 13px;">
			  <a href="#" style="color: #666666;
				text-decoration: none;">24x7 Customer Support</a>&nbsp;  |&nbsp;  
			  <a href="#" style="color: #666666;
				text-decoration: none;">Buyer Protection</a>&nbsp;  |&nbsp;  
			  <a href="#" style="color: #666666;
				text-decoration: none;">Flexible Payment Options</a> <br/>
			  </div><div id="footer" style="width: 660px;
				margin-right: 30px;
				margin-left: 30px;
				float: left;
				margin-top: 10px;
				margin-bottom: 10px;
				line-height: 25px;
				text-align: center;
				font-size: 10px;
				height: 25px;">  
				This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.
			  </div>
			</div>';

    $message .= '</body></html>';
    mail($to, $subject, $message, $headers);
    echo json_encode($output);
    //header("Location: $produ_a_redirect?insertkey=$orderId");
} catch (PDOException $e) {
    //$DBH->rollBack();
    echo json_encode(array('msg' => "I'm sorry, I'm afraid I can't do that."));
    file_put_contents('PDOErrors.txt', "\r\n" . date("Y-m-d H:i:s") . $e->getMessage(), FILE_APPEND);
}
?>