<?php
	include('db_config.php');
	include('redirects.php');
	include('params.php');
	  /* 
   * PDO
   */
   print_r($_POST); 
   $sts_flg = "0";
   $cre_ts = date('Y-m-d H:i:s');
   $delivery_address = $_POST['add1'].",".$_POST['add1'].",".$_POST['city'].",".$_POST['zipcode'];
   $prices = array();
   $prices = $_POST['price'];
   $stocks = array();
   $stocks = $_POST['stock'];
   $images = array();
   $images = $_POST[product]['image'];
	print_r($_FILES["file"]["imagename"]);
	print_r ($prices);
	print_r ($stocks);
	print_r ($images);
	echo date('Y-m-d H:i:s');
	echo microtime();
	
		
	# connect to the database
	try {
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		//$DBH->beginTransaction();
		# SQL
			$custdet = "INSERT INTO customer(
				first_name,
				last_name,
				mobile_number,
				email,
				sts_flg,
				cre_ts
				) VALUES (
				:first_name,
				:last_name,
				:mobile_number,
				:email,
				:sts_flg,
				:cre_ts)";
						
			$custaddr = "INSERT INTO customer_address(
				cust_code,
				add1,
				add2,
				city,
				zipcode,
				cre_ts
				) VALUES (
				:cust_code,
				:add1,
				:add2,
				:city,
				:zipcode,
				:cre_ts)";
			
			$orderheader = "INSERT INTO order_headers(
				cust_code,
				order_value,
				order_status,
				payment_type,
				delivery_date,
				delivery_address,
				order_datetime,
				sub_total,
				vat_percent,
				vat_amount,
				delivery_charge,
				grand_total,
				cre_ts
				) VALUES (
				:cust_code,
				:order_value,
				:order_status,
				:payment_type,
				:delivery_date,
				:delivery_address,
				:order_datetime,
				:sub_total,
				:vat_percent,
				:vat_amount,
				:delivery_charge,
				:grand_total,
				:cre_ts)";
			
			$orderdetail = "INSERT INTO order_details(
				cust_code,
				order_number,
				product_code,
				quantity,
				price,
				value,
				sub_total,
				cre_ts
				) VALUES (
				:cust_code,
				:order_number,
				:product_code,
				:quantity,
				:price,
				:value,
				:sub_total,
				:cre_ts)";
	 	 
		 
			/*** prepare the SQL statement ***/
				$stmt1 = $DBH->prepare($custdet);
				$stmt2 = $DBH->prepare($custaddr);
				$stmt3 = $DBH->prepare($orderheader);
				$stmt4 = $DBH->prepare($orderdetail);
				
		# custdet
		
			/*** bind the parameters ***/
				$stmt1->bindParam(':first_name', $_POST['first_name'], PDO::PARAM_STR);
				$stmt1->bindParam(':last_name', $_POST['last_name'], PDO::PARAM_STR);
				$stmt1->bindParam(':mobile_number', $_POST['mobile_number'], PDO::PARAM_STR);
				$stmt1->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt1->bindParam(':sts_flg', $sts_flg, PDO::PARAM_STR);
				$stmt1->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);	
			
			
			/*** execute the prepared statement ***/
				$stmt1->execute();
				$custId = $DBH->lastInsertId();
				print_r($custId);
				
		# custaddr
			/*** bind the parameters ***/	
		
				//foreach($stocks as $stock)
				//{
					$stmt2->bindParam(':cust_code', $custId, PDO::PARAM_STR);
					$stmt2->bindParam(':add1', $_POST['add1'], PDO::PARAM_STR);
					$stmt2->bindParam(':add2', $_POST['add2'], PDO::PARAM_STR);
					$stmt2->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
					$stmt2->bindParam(':zipcode', $_POST['zipcode'], PDO::PARAM_STR);
					$stmt2->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);
				/*** execute the prepared statement ***/
					$stmt2->execute();
					$custaddId = $DBH->lastInsertId();
				print_r($custaddId);
				//}		
		
		# orderheader
			/*** bind the parameters ***/	
	
				//foreach($prices as $price)
				//{
					$stmt3->bindParam(':order_value', $_POST['order_value'], PDO::PARAM_STR);
					$stmt3->bindParam(':cust_code', $custId, PDO::PARAM_STR);
					$stmt3->bindParam(':order_status', $_POST['order_status'], PDO::PARAM_STR);
					$stmt3->bindParam(':payment_type', $_POST['payment_type'], PDO::PARAM_STR);
					$stmt3->bindParam(':delivery_date', $_POST['delivery_date'], PDO::PARAM_STR);
					$stmt3->bindParam(':delivery_address', $delivery_address, PDO::PARAM_STR);
					$stmt3->bindParam(':order_datetime', $cre_ts, PDO::PARAM_STR);
					$stmt3->bindParam(':sub_total', $_POST['sub_total'], PDO::PARAM_STR);
					$stmt3->bindParam(':vat_percent', $_POST['vat_percent'], PDO::PARAM_STR);
					$stmt3->bindParam(':vat_amount', $_POST['vat_amount'], PDO::PARAM_STR);
					$stmt3->bindParam(':delivery_charge', $_POST['delivery_charge'], PDO::PARAM_STR);
					$stmt3->bindParam(':grand_total', $_POST['grand_total'], PDO::PARAM_STR);
					//$stmt2->bindParam(':sts_flg', $sts_flg, PDO::PARAM_STR);
					$stmt3->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);
				/*** execute the prepared statement ***/
					$stmt3->execute();
					$orderId = $DBH->lastInsertId();
				//}
							  
				
		# orderdetail
			/*** bind the parameters ***/	
		
				//foreach($images as $image)
				//{
					$stmt4->bindParam(':order_number', $orderId, PDO::PARAM_STR);
					$stmt4->bindParam(':cust_code', $custId, PDO::PARAM_STR);
					$stmt4->bindParam(':product_code', $_POST['product_code'], PDO::PARAM_STR);
					$stmt4->bindParam(':quantity', $_POST['quantity'], PDO::PARAM_STR);
					$stmt4->bindParam(':price', $_POST['price'], PDO::PARAM_STR);
					$stmt4->bindParam(':sub_total', $_POST['sub_total'], PDO::PARAM_STR);
					//$stmt2->bindParam(':sts_flg', $sts_flg, PDO::PARAM_STR);
					$stmt4->bindParam(':cre_ts', $cre_ts, PDO::PARAM_STR);
				/*** execute the prepared statement ***/
					$stmt4->execute();
				//}	
			
			//$DBH->commit();



			//header("Location: $produ_a_redirect?insertkey=$orderId");
	 	}
		catch(PDOException $e) {
			//$DBH->rollBack();
			echo "I'm sorry, I'm afraid I can't do that.";
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
	
  //var_dump($_POST["selected"]);
  
  
?>