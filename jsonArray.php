<?php
$con=mysqli_connect("localhost","root","","mapicosi_meatdb");
$query="SELECT * FROM order_details INNER JOIN order_headers ON order_details.cust_code=order_headers.cust_code";

$sel=mysqli_query($con, $query);
$arr=array();
while($data=mysqli_fetch_array($sel))
{
	
	 $cust_code= $data['cust_code'];	
	 $order_number= $data['order_number'];
	 $order_value= $data['order_value'];
	 $order_status=$data['order_status'];
	 $quantity= $data['quantity'];
	 $price=$data['price'];
	 $sub_total= $data['sub_total'];
	 

	$arr['Orders'][]=array('order_headers'=>array('cust_code'=>$cust_code, 'order_number'=>$order_number, 'order_value'=>$order_value, 'order_status' => $order_status, 'quantity' => $quantity, 'price' => $price, 'sub_total' => $sub_total));

	
	// echo "<br>";
	// echo "<br>";
}
// print_r($arr);
echo json_encode($arr);




?>

