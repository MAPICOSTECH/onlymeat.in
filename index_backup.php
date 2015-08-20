
<?php
	include('db_config.php');
	//include('redirects.php');
	//include('params.php');
	
	try {
		$DB = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DB->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$statement = $DB->prepare("select * from products where status = :status");
		$statement->execute(array(':status' => "1"));
		$row = $statement->fetchAll(); // Use fetchAll() if you want all results, or just iterate over the statement, since it implements 
		
	//print_r($row);
	//print_r($row[0][product_name]);
	} 
	catch(PDOException $e) {
			//$DBH->rollBack();
			echo "I'm sorry, I'm afraid I can't do that.";
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
?>

<style>
input[type="number"] {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
   
   color: #ff0000;
    float: left;
    font-family: Lato;
    font-size: 18px;
    font-weight: 700;
    height: 35px;
    outline: medium none;
    padding: 0;
    pointer-events: none;
    text-align: center;
    text-transform: uppercase;
    width: 48px;
}
span.spinner > .sub{
   width: 35px;
   
    background: #fff000;
    border-right: 1px solid #ff0000;
    color: #ff0000;
    font-family: Lato;
    font-size: 18px;
    font-weight: 700;
    height: 35px;
    float: left;
    
   
    
}
span.spinner > .add {
	width: 35px;
    height: 37px;
    background: #fff000;
    border-left: 1px solid #ff0000;
    color: #ff0000;
    font-size: 18px;
    font-weight: 700;
    float: left;
    top: 0;
       border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
   
}
span.spinner {
    position: absolute;
    height: 37px;
    user-select: none;
    -ms-user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -webkit-touch-callout: none;
	    background: #fff000;
   
    color: #ff0000;
	border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}


sub, .sub {
    bottom: 0em;
}
sub, .sub, sup, .sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline;
}
input[type="submit"] {
	font-size: 18px;
    color: #fff;
    display: inline-block;
    font-weight: 600;
    padding: 15px 65px;
    border: 2px solid #ee1c24;
    -webkit-border-radius: 4px;
    background: #ee1c24;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Onlymeat</title>

<script type="text/javascript">
document.createElement("nav" );
document.createElement("section" );
document.createElement("footer" );
</script>

<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Raleway:400,600,800,500,300,700' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="wrapper">
	<div class="top_header">
		<div class="container">
			<div class="logo">
				<a href="#"><img src="images/logo.png" alt="" /></a>
			</div>
			<div class="phone">
				<p>94 93 92 25 25</p>
			</div>
		</div>
	</div>
	<div class="mid_sec">
	    <div class="container">
	    	<div class="mid_sec_innr">
	    		<h2>Fresh by Order</h2>
	           <div class="product_area">
	           	<div class="product">
	           		<h3><?php echo $row[2]['product_name']?>- &#8377; <?php echo $row[2]['price']?> / Kg</h3>
                     <input id="prod-price-1" value="<?php echo $row[2]['price']?>" name="prod-price-1" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd1.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n1">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in" id="product-cart">
                   <input type="number" id="p1" min="0" max="1000" value="0" name="quantity1"/>
	           			
						</div>
	           		</div>
	           	</div>
	           	<div class="product">
	           		<h3><?php echo $row[3]['product_name']?>- &#8377; <?php echo $row[3]['price']?> / Kg</h3>
                     <input id="prod-price-2" value="<?php echo $row[3]['price']?>" name="prod-price-2" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd2.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n2">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in" id="product-cart">
      	
        	<input type="number" id="p2" min="0" max="1000" value="0" name="quantity2" />
						</div>
	           		</div>
	           	</div>
	           	<div class="product">
	           		<h3><?php echo $row[1]['product_name']?>- &#8377; <?php echo $row[1]['price']?> / Kg</h3>
                     <input id="prod-price-3" value="<?php echo $row[1]['price']?>" name="prod-price-3" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd3.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n3">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in">
	           				<input type="number" id="p3" min="0" max="1000" value="0" onclick="" name="quantity3" />
						</div>
	           		</div>
	           	</div>
	           	<div class="product">
	           		<h3><?php echo $row[0]['product_name']?>- &#8377; <?php echo $row[0]['price']?>/ Kg</h3>
                     <input id="prod-price-4" value="<?php echo $row[0]['price']?>" name="prod-price-4" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd4.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n4">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in">
	           			<input type="number" id="p4" min="0" max="50" value="0" name="quantity4" />
						</div>
	           		</div>
	           	</div>
	           	<div class="product">
	           		<h3><?php echo $row[4]['product_name']?>- &#8377; <?php echo $row[4]['price']?> / Kg</h3>
                     <input id="prod-price-5" value="<?php echo $row[4]['price']?>" name="prod-price-5" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd5.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n5">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in">
	           				<input type="number" id="p5" min="0" max="1000" value="0" name="quantity5" />
						</div>
	           		</div>
	           	</div>
	           	<div class="product">
	           		<h3><?php echo $row[5]['product_name']?>- &#8377; <?php echo $row[5]['price']?>/ Kg</h3>
                    <input id="prod-price-6" value="<?php echo $row[5]['price']?>" name="prod-price-6" hidden />
	           		<div class="product_lft">
	           			<img src="images/prd6.jpg" alt="" />
	           		</div>
	           		<div class="product_rit">
	           			<div class="product_rit_in">
	           				<p>You Order for</p>
	           				<h4>&#x20B9;<span id="price-n6">0</span></h4>
	           			</div>
	           		</div>
	           		<div class="product_last">
	           			<div class="in">
	           			<input type="number" id="p6" min="0" max="1000" value="0" name="quantity6"/>
						</div>
	           		</div>
	           	</div>
	           </div> 
	            <div class="btn_prt">
	            	<div class="btn_prt_lft">
                     
	            		<a href="#">Your Order Value - <br><span id="price-total">0</span>/-</a>
	            	</div>
	            	<div class="btn_prt_rit">
                    <input type="hidden" id="tot" min="0" max="1000" value="0" name="total"/>
	            		<input type="submit" id="checkOut" name="prodata" value="Continue Checkout" class="maincheckout" />
	            	</div>
	            </div>	
	    	</div>
	    	
	    </div>	
	</div> 
  <div id="order" class="form_prt content-block reservations-block" style="display:none;">
  	<div class="container">
  		<div class="form_prt_innr">
  			<h2>Your Order details</h2>
  			<div class="from_sec">
  				<div class="from_sec_lft_main">
  				<div class="from_sec_lft">
  					<table table-border="0" cellspacing="0" colspacing="0" width="100%">
  						<tr>
  							<th class="cl1">Product</th>
  							<th class="cl2">Qty.</th>
  							<th class="cl2">Price</th>
  						</tr> 
  						<tr id="cart-product-1">
  							<td class="cl1">Whole Chicken</td>
                             <input id="pcode1" value="4" name="pcode1" hidden />
        	     <td class="cl2" id="con1" ><?php echo $_REQUEST["quantity1"]?> Kg</td>
        	      <td class="cl2" id="cop1">&#8377; <?php echo $subtot=$_REQUEST["quantity1"]*$_REQUEST["prod-price-1"];?></td>
  							
  						</tr> 	
  						<tr id="cart-product-2">
  							<td class="cl1">Skinless Chicken</td>
  							<input id="pcode2" value="5" name="pcode2" hidden />
        	     <td class="cl2"  id="con2"><?php echo $_REQUEST["quantity2"]?> Kg</td>
        	      <td class="cl2" id="cop2">&#8377; <?php echo $subtot=$_REQUEST["quantity2"]*$_REQUEST["prod-price-2"];?></td>
  						</tr>
  						<tr id="cart-product-3">
  							<td class="cl1">Boneless Chicken</td>
  							<input id="pcode3" value="6" name="pcode3" hidden />
        	     <td class="cl2" id="con3" ><?php echo $_REQUEST["quantity3"]?> Kg</td>
        	      <td class="cl2" id="cop3">&#8377; <?php echo $subtot=$_REQUEST["quantity3"]*$_REQUEST["prod-price-3"];?></td>
  						</tr>
  						<tr id="cart-product-4">
  							<td class="cl1">Leg Pieces</td>
  							<input id="pcode4" value="7" name="pcode4" hidden />
        	     <td class="cl2"  id="con4"><?php echo $_REQUEST["quantity4"]?> Kg</td>
        	      <td class="cl2" id="cop4">&#8377; <?php echo $subtot=$_REQUEST["quantity4"]*$_REQUEST["prod-price-4"];?></td>
  						</tr>
  						<tr id="cart-product-5">
  							<td class="cl1">Breast Pieces</td>
  							<input id="pcode5" value="8" name="pcode5" hidden />
        	     <td class="cl2"  id="con5"><?php echo $_REQUEST["quantity5"]?> Kg</td>
        	      <td class="cl2" id="cop5">&#8377; <?php echo $subtot=$_REQUEST["quantity5"]*$_REQUEST["prod-price-5"];?></td>
  						</tr>
  						<tr id="cart-product-6">
  							<td class="cl1">Chicken Liver</td>
  							<input id="pcode6" value="9" name="pcode6" hidden />
        	     <td class="cl2"  id="con6"><?php echo $_REQUEST["quantity6"]?> Kg</td>
        	      <td class="cl2" id="cop6">&#8377; <?php echo $subtot=$_REQUEST["quantity6"]*$_REQUEST["prod-price-6"];?></td>
  						</tr>
  						<tr id="cart-product-3">
  							<td class="cl1 cl">Delivary Charges</td>
  							<input id="pcode7" value="4" name="pcode1" hidden />
        	     <td class="cl2" > Kg</td>
        	      <td class="cl2">&#8377; 25</td>
  						</tr>					
  					</table>
  					<div class="table_btm">
  						<h4 id="cart-main-product-total">Total Price - <span>&#x20B9; <span id="p-tot"><?php echo $_REQUEST['total']; ?></span></h4>
  					</div>
  					</div>
  					<div class="table_last_prt">
  						<h5>Delivery Options</h5>
  						<div class="rad">
  						<input type="radio" name="1" value="" />
  						Delivery Now
  						</div>
  						<div class="rad">
  						<input type="radio" name="1" value="" />
  						Schduled Delivery
  						</div>
                        
                        
                        
                        
                        
                        
                      
                        
  						<div class="date">
  							<div class="styled-select">
                             <input type="text" name="delivery_date" id="delivery_date"  placeholder="Delivery Date" class="ccformfield">
							  
							</div>
							<div class="styled-select">
							  <select id="cd-dropdown" name="ord_slot" class="cd-select">
						<option value="S1" selected>7AM - 9AM </option>
						<option value="S2" selected>9AM - 11AM </option>
						<option value="S3" selected>11AM - 1PM </option>
						<option value="S4" selected>4PM - 6PM </option>
                        <option value="S4" selected>6PM - 8PM </option>
					</select>
							</div>
  						</div>
  					</div>
  				</div>
  				<div class="from_sec__rit">
  				<form action="#" method="post">
  				<div class="from_sec_rit_main">
  					<div class="rad2">
  						<input type="radio" name="usertype1" id="userexisting" value="Existing User" >
  							Existing Users
  					</div>
  					<div class="rad2">
  						<input type="radio" name="usertype1" id="usernew" value="New User"  checked>
  							New Users
  					</div>
  					 <input type="hidden"  name="mobile_number3" id="mobile_number3" value="" >
                <input type="hidden"  name="ccode" id="ccode"  value="">
                   <input type="hidden"  name="first_name" id="first_name" value="" >
                <input type="hidden"  name="email" id="email"  value="">
                <div class="from_sec_rit_form">
              
                
                <div class="ccfield-prepend newu1" style="display:none;">
				<span id="already-msg">Already ordered, Enter your mobile number:</span>
                <div class="form_1">
				<input type="text" required name="mobile_number" id="mobile_number" placeholder="Mobile Number / Landline" >
                </div>
                
                
                        <div class="submit_btn">
                         <input type="hidden" name="isExisting" id="isExisting" value="No">
                       
				<input type="submit" name="submit" id="f_login" value="Login" style="align:left"><br> 
                </div>
				</div>
                
              	
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic2.jpg" alt="" /></label>
  								 <input  type="text" placeholder="First Name" name="Name" id="first_name" required>
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic1.jpg" alt="" /></label>
  								<input  type="text" placeholder="Email" name="email" id="email" required>
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic3.jpg" alt="" /></label>
  								<input type="text" required name="mobile_number" id="mobile_number" placeholder="Mobile Number / Landline" >
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								 <input  type="text" placeholder="Addressline 1" name="add1" id="add1" required>
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								<input  type="text" placeholder="Addressline 2" name="add2" id="add2" required>
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								<div class="styled-select2">
							   <select id="cd-dropdown" name="area">
							     <option value="1" selected>Kondapur</option>
							     
							   </select>
							</div>
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								<input  type="text" placeholder="Landmark" name="landmark" id="landmark" required>
  							</div>
  							
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								<input  type="text" placeholder="City" name="city" id="city">
  							</div>
  							<div class="form_1 ccfield-prepend newu">
  								<label><img src="images/frm_pic4.jpg" alt="" /></label>
  								 <input  type="text" placeholder="Pincode" name="zipcode" id="zipcode">
  							</div>
  					</div>
  					</div>
  					<div class="table_last_prt" id="cart-main-tab-2">
  						<h5>Payment Method</h5>
  						<div class="rad">
  						<input type="radio" name="3" value="" />
  						Cash on Delivery
  						</div>
  						<div class="rad">
  						<input type="radio" name="3" value="" />
  						Card on Delivery
  						</div>
  						<div class="submit_btn">
                        <input type="hidden" name="isExisting" id="isExisting" value="No">
                <input type="submit" value="submit!" id="f_submit" name="submit" />
  							
  						</div>
  					</div>
  					</form>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>	
	<footer class="footer_sec">
	<div class="container">
		<div class="footer_col">
			<h3>Payment Method</h3>
            <ul class="str_sm">
				<li><a href="#"><img src="images/cash.png"></a></li>
                <li><a href="#"><img src="images/mswipe.png"></a></li>
			</ul>
		</div>
		<div class="footer_col">
			<h3>Delivery Slots</h3>			
            <div style="line-height:25px; color:#FFFFFF;">
            <span style="padding:5px; margin-bottom:5px;">7AM - 9AM</span>&nbsp; <font color="#000000">|</font> &nbsp;
            <span style="padding:5px; margin-bottom:5px;">9AM - 11AM</span> <br/>
            <span style="padding:5px; margin-bottom:5px;">11AM - 1PM</span>&nbsp; <font color="#000000">|</font> &nbsp;
            <span style="padding:5px; margin-bottom:5px;">4PM - 6PM</span> <br/>
            <span style="padding:5px; margin-bottom:5px;">6PM - 8PM</span>
            </div>
		</div>
		<div class="footer_col">
			<h3>Contact Us</h3>
			<p>email : <a href="#"> info@onlymeat.in</a></p>
			<p>Enquiry : +91 82973 99911</p>
			
			<ul class="str_sm">
				<li><a href="#"><img src="images/twitter.png"></a></li>
				<li><a href="#"><img src="images/facebook.png"></a></li>
			</ul>
			
		</div>
	</div>
</footer>	
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
<script type="text/javascript">
jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});

</script>
<script src="js/vendor/wow.js"></script>
<script src="js/vendor/webfontloader.js"></script>
<script src="js/default.js"></script>
<script src="js/custom.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<!--                <script> $(document).ready(function(){
       jQuery('.web').click(function () {
        $("#f_submit").trigger( "click" );
          alert('alert');
    });
  });</script>-->
<script>

$(function() {
    $( "#delivery_date" ).datepicker({minDate: 0});
  });
$(document).ready(function() {
	$("#userexisting").click(function() {
	
		$(".newu1").show(); 
		$(".newu").hide(); 

		});
	
	$("#usernew").click(function() {
	
		$(".newu").show(); 
		$(".newu1").hide();

		});
		$('#f_submit').click(function () {
			var isExisting = $("#isExisting").val();
			
			var userType = $("#myForm input[type='radio']:checked").val();
			var add1 = $('#add1').val();
			var add2 = $('#add2').val();
			var zipcode = $('#zipcode').val();
			var city = $('#city').val();
			var delivery_date = $('#delivery_date').val();
			  var orderTotal = $('#p-tot').html();
			  var  products ="";
			  var qtys ="";
			  var prices ="";
			  var totalPrices ="";
			  var tQuantity ="";
			  var tPid ="";
			   var tPrice ="";
			 for (i = 1; i < 7; i++) 
			 { 
			 	tQuantity = $( "#con"+i ).html();
			 	if(tQuantity !=0)
				{
					
					tPid = $( "#pcode"+i ).val();
					ttPrice = $( "#cop"+i ).html();
					tPrice = $( "#prod-price-"+i ).val();
					products = products+","+tPid;
					qtys= qtys+","+tQuantity;
					prices = prices+","+tPrice;
					totalPrices = totalPrices+","+ttPrice;
				}
			 	//var city = $('#city').val();			 
				//quant[i] = $( "#p"+i ).val();
			 }
			if (userType == "New User")
			{
			  var first_name = $('#first_name').val();
			  var last_name = $('#last_name').val();
			  var email = $('#email').val();
			  var mobile_number1 = $('#mobile_number1').val();
			  $.ajax({
			url: 'ajax_refresh1.php',
			type: 'POST',
			data: {userType:userType,first_name:first_name,last_name:last_name,email:email,mobile_number1:mobile_number1,add1:add1,add2:add2,zipcode:zipcode,city:city,orderTotal:orderTotal,products:products,qtys:qtys,prices:prices,totalPrices:totalPrices,delivery_date:delivery_date},
			dataType: 'json',
			success:function(data){
			for (i = 1; i < 7; i++) { 
			$( "#p"+i ).val(0);
			$( "#price-n"+i ).html(0);
			$( "#cop"+i ).html(0);
			$( "#con"+i ).html(0);
			}

			$("#price-total").html(0);
			$("#p-tot").html(0);
				$("#order").hide();
				$("#result").show();
				$("#result").html(data.msg);
				
				/*alert(data);*/
			  //$('#mobile_number').attr("disabled", "disabled");
			 
			}
		});
			}
			else if (userType == "Existing User")
			{
				if (isExisting == "Yes")
				{
				var mobile_number = $('#mobile_number3').val();
				var ccode = $('#ccode').val();
				var first_name = $('#first_name').val();
				var email = $('#email').val();
				 $.ajax({
			url: 'ajax_refresh1.php',
			type: 'POST',
			data: {userType:userType,first_name:first_name,email:email,mobile_number:mobile_number,ccode:ccode,add1:add1,add2:add2,zipcode:zipcode,city:city,orderTotal:orderTotal,products:products,qtys:qtys,prices:prices,totalPrices:totalPrices,delivery_date:delivery_date},
			dataType: 'json',
			success:function(data){
			for (i = 1; i < 7; i++) { 
			$( "#p"+i ).val(0);
			$( "#price-n"+i ).html(0);
			$( "#cop"+i ).html(0);
			$( "#con"+i ).html(0);
			}

			$("#price-total").html(0);
			$("#p-tot").html(0);
				$("#order").hide();
				$("#result").show();
				$("#result").html(data.msg);
				
				/*alert(data);*/
			  $('#mobile_number').attr("disabled", "disabled");
			 
			}
		});
				}
				else if(isExisting == "No")
				{
					alert("You are not an existing user.");
				}
			}
			  
		
			  return false;
		});
	
	     $('#f_login').click(function () {
		var mobile_number = $('#mobile_number').val();	 
        $.ajax({
			url: 'ajax_refresh.php',
			type: 'POST',
			data: {mobile_number:mobile_number},
			dataType: 'json',
			success:function(data){
				if (data == null)
				{
					alert('Sorry, This number is not registered. ');
				}
				else
				{
			  $('#mobile_number3').val(data.mobile_number);
			  $('#ccode').val(data.cust_code);
			   $('#first_name').val(data.first_name);
			    $('#email').val(data.email);
			  $('#add1').val(data.address_1);
			  $('#add2').val(data.address_2);
			  $('#city').val(data.city);
			  $('#zipcode').val(data.post_code);
			   $("#isExisting").val("Yes");
			   $(".newu1").html(data.msg); 
				$(".newu").hide();
				$(".utype").hide();
				}
			 
			},
		error: function(xhr, textStatus, errorThrown)
		{
       
    		}
		});
		 return false;
		 
    });
	$("#checkOut").click(function() {
		var tQty =0;
		var quant = [];
		var price = [];
		for (i = 1; i < 7; i++) { 
			quant[i] = $( "#p"+i ).val();
			//alert(quant[i] );
		}
		for (j = 1; j < 7; j++) { 
			price[j] = $( "#price-n"+j ).html();
			//alert(quant[j] );
		}

		
		var  totalp = $( "#price-total" ).html();
		$( "#p-tot" ).html(totalp);
		var ctr=0;
		for (i = 1; i < 7; i++) 
		{ 
			if (quant[i] != "0")
			{
				$("#con"+i).html(quant[i]);
				$("#cop"+i).html(price[i]);
				tQty = parseFloat(tQty)+parseFloat(quant[i]);
				
			}
			else
			{
				ctr++;
				$("#cart-product-"+i).hide();
			}
		}
		if(ctr !=6 && tQty > 0.5) {$("#order").show();
		$(window).scrollTop(850);
		 }
		if(tQty < 1) { alert ("Total value should be more than or equal to one."); }

		
		return(false);

		});
	
	});	
(function($) {
	$.fn.spinner = function() {
		this.each(function() {
			var el = $(this);

			// add elements
			el.wrap('<span class="spinner"></span>');     
			el.before('<span class="sub">-</span>');
			el.after('<span class="add">+</span>');
			var items_qty = [];
			// substract
			el.parent().on('click', '.sub', function () {
				if (el.val() > parseInt(el.attr('min')))
					el.val( function(i, oldval) { 
					oldval =parseFloat (oldval) - 0.5;
					//alert(oldval);
					return oldval ; });
					
					var oldval1=$( "#p1" ).val();
					 var p1 = $( "#prod-price-1" ).val()
					var sum1=parseFloat(p1)*parseFloat(oldval1);
					
					$('#price-n1').html(sum1);
					$("#con1").html(oldval1);
					$("#cop1").html(sum1);
					items_qty[1]=oldval1;
					var oldval2=$( "#p2" ).val();
					var p2 = $( "#prod-price-2" ).val()
					var sum2=parseFloat(p2)*parseFloat(oldval2);
					//alert(sum2);
					$('#price-n2').html(sum2);
					$("#con2").html(oldval2);
					$("#cop2").html(sum2);
					items_qty[2]=oldval2;
					var oldval3=$( "#p3" ).val();
					var p3 = $( "#prod-price-3" ).val()
					var sum3=parseFloat(p3)*parseFloat(oldval3);
					//alert(sum);
					$('#price-n3').html(sum3);
					$("#con3").html(oldval3);
					$("#cop3").html(sum3);
					items_qty[3]=oldval3;
					var oldval4=$( "#p4" ).val();
					var p4 = $( "#prod-price-4" ).val()
					var sum4=parseFloat(p4)*parseFloat(oldval4);
					//alert(sum);
					$('#price-n4').html(sum4);
					$("#con4").html(oldval4);
					$("#cop4").html(sum4);
					items_qty[4]=oldval4;
					var oldval6=$( "#p6" ).val();
					var p6 = $( "#prod-price-6" ).val()
					var sum6=parseFloat(p6)*parseFloat(oldval6);
					//alert(sum);
					$('#price-n6').html(sum6);
					$("#con6").html(oldval6);
					$("#cop6").html(sum6);
					items_qty[6]=oldval6;
					var oldval5=$( "#p5" ).val();
					var p5 = $( "#prod-price-5" ).val();
					var sum5=parseFloat(p5)*parseFloat(oldval5);
					//alert(sum);
					$('#price-n5').html(sum5);
					$("#con5").html(oldval5);
					$("#cop5").html(sum5);
					items_qty[5]=oldval5;
					var total=parseFloat(sum1)+parseFloat(sum2)+parseFloat(sum3)+parseFloat(sum4)+parseFloat(sum5)+parseFloat(sum6);
					
					//alert(total);
					$('#price-total').html(total);

					$( "#tot" ).val(total);
					$( "#p-tot" ).html(total);
				console.log(oldval);
			});

			// increment
			el.parent().on('click', '.add', function () {
				
				if (el.val() < parseInt(el.attr('max')))
					el.val( function(i, oldval) { 
					oldval = parseFloat (oldval)+ 0.5;
					
					//alert(oldval);
					return oldval; });
					
					
					
					var oldval1=$( "#p1" ).val();
					 var p1 = $( "#prod-price-1" ).val()
					var sum1=parseFloat(p1)*parseFloat(oldval1);
					//alert(sum1);
					$('#price-n1').html(sum1);
					$("#con1").html(oldval1);
					$("#cop1").html(sum1);
					items_qty[1]=oldval1;
					var oldval2=$( "#p2" ).val();
					var p2 = $( "#prod-price-2" ).val()
					var sum2=parseFloat(p2)*parseFloat(oldval2);
					//alert(sum2);
					$('#price-n2').html(sum2);
					$("#con2").html(oldval2);
					$("#cop2").html(sum2);
					items_qty[2]=oldval2;
					var oldval3=$( "#p3" ).val();
					var p3 = $( "#prod-price-3" ).val()
					var sum3=parseFloat(p3)*parseFloat(oldval3);
					//alert(sum3);
					$('#price-n3').html(sum3);
					$("#con3").html(oldval3);
					$("#cop3").html(sum3);
					items_qty[3]=oldval3;
					var oldval4=$( "#p4" ).val();
					var p4 = $( "#prod-price-4" ).val()
					var sum4=parseFloat(p4)*parseFloat(oldval4);
					//alert(sum4);
					$('#price-n4').html(sum4);
					$("#con4").html(oldval4);
					$("#cop4").html(sum4);
					items_qty[4]=oldval4;
					var oldval6=$( "#p6" ).val();
					var p6 = $( "#prod-price-6" ).val()
					var sum6=parseFloat(p6)*parseFloat(oldval6);
					//alert(sum6);
					$('#price-n6').html(sum6);
					$("#con6").html(oldval6);
					$("#cop6").html(sum6);
					items_qty[6]=oldval6;
					var oldval5=$( "#p5" ).val();
					//alert('old'+oldval5);
					var p5 = $( "#prod-price-5" ).val()
					//alert('old11'+p5);
					var sum5=parseFloat(p5)*parseFloat(oldval5);
					//alert(sum5);
					$('#price-n5').html(sum5);
					$("#con5").html(oldval5);
					$("#cop5").html(sum5);
					items_qty[5]=oldval5;
					
					for (i = 1; i < 7; i++) 
					{ 
						if (items_qty[i] != "0")
						{
							$("#cart-product-"+i).show();						
						}
					}
					
					var total=parseFloat(sum1)+parseFloat(sum2)+parseFloat(sum3)+parseFloat(sum4)+parseFloat(sum5)+parseFloat(sum6);
					$('#price-total').html(total);
					$( "#tot" ).val(total);
					$( "#p-tot" ).html(total);
					//var multipleValues = $( "input[type=number]" ).val();
					
			});
	    });
	};
})(jQuery);

$('input[type=number]').spinner();


function get_price(val)
{
	
	alert("The input value has changed. The new value is: " + val);
    var qty =  $(el.val).spinner();
    var price = $("#prod-price-6").html();
    var tot_price =  qty * price;
    $("#price-number").html(tot_price);
    document.write(qty);
	document.write(price);
	document.write(tot_price);
	return false;
}
</script>

</div>	
</body>
</html>
