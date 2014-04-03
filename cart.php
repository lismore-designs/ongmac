<?php


require_once('symbiotic/cart-load.php');
require_once('symbiotic/gateways.php');
$regions = $shipping->region_all();
// SET ITEM COUNT TO 0


$items_count = '0';
$cart_total  = '0';
$net_amount  = '0';
$shippingPrice  = '0';
$taxRate = $setting['tax'];
//COMPLETE  SOME REQUESTS
if(isset($_REQUEST['action'])){
// ADD ITEM
	if($_REQUEST['action'] == 'add'){
		
		
		
	if(isset($_REQUEST['product_id'])){
	if(!isset($_REQUEST['qty']) || $_REQUEST['qty'] == 'undefined'){
	$_REQUEST['qty'] = '1';
	}
	if(isset($_REQUEST['option']) && $_REQUEST['option'] != 'undefined'){
		$result = $cart->add($_REQUEST['product_id'],$_REQUEST['qty'],$_REQUEST['option']);
	  }	else{
		  
		 
		$result = $cart->add($_REQUEST['product_id'],$_REQUEST['qty']);
		
		echo $result;
		
	}
	
	}
	}
//UPDATE CART
	if($_REQUEST['action'] == 'update'){
	if(isset($_REQUEST['item'])){
		foreach($_REQUEST['item'] as $uitem){
		$result = $cart->update($uitem['id'],$uitem['count']); 
		if(!$result){
		break;
				}
			}
		}
	}
//EMPTY CART	
	if($_REQUEST['action'] == 'empty'){
		$result = $cart->empty_cart(); 	
	}
//APPLY COUPONS
if($_REQUEST['action'] == 'coupon'){
	if(!empty($_REQUEST['coupon'])){
	if($_REQUEST['coupon'] == 'FACEBOOK LIKE' || $_REQUEST['coupon'] =="GOOGLE PLUS"){
	$message = 'Coupon Applied Successfully';
	}elseif($coupon->details($_REQUEST['coupon'])){
 	$_SESSION['basket']['coupon']['code'] = $_REQUEST['coupon'];
 	$off = $coupon->details($_REQUEST['coupon']);
 	$_SESSION['basket']['coupon']['discount'] = $off['off'];
 	$_SESSION['basket']['coupon']['discount_type'] = $off['off_type'];
 	$_SESSION['basket']['coupon']['min'] = $off['order_min'];
	$message = 'Coupon Applied Successfully';
 	}
	} else{
 	unset($_SESSION['basket']['coupon']);
 	$message = 'Coupon Removed Successfully'; 
	}
	}
// OMG VIRAL COUPONS ARE ASLO PRESENT
if($_REQUEST['action'] == 'viral'){
	$req= md5(session_id());
 if(!empty($_REQUEST[$req])){
 	if($_REQUEST[$req] == 'FACEBOOK'){
 	$_SESSION['basket']['coupon']['code'] = 'FACEBOOK LIKE';
	$_SESSION['basket']['coupon']['discount_type'] = '1';
	$_SESSION['basket']['coupon']['min']='0';
 	$off = $setting['fb_dis'];
 	
 	$_SESSION['basket']['coupon']['discount'] = $off;
 	$result = 'Coupon Applied Successfully'; 
 	}elseif($_REQUEST[$req] == 'GPLUS'){
 	$_SESSION['basket']['coupon']['code'] = "GOOGLE PLUS";
	$_SESSION['basket']['coupon']['discount_type'] = '1';
	$_SESSION['basket']['coupon']['min']='0';
 	$off = $setting['g_dis'];
 	
 	$_SESSION['basket']['coupon']['discount'] = $off;
 	$result = $off['off'];
 	$result = 'Coupon Applied Successfully'; 	
 	}
 }else{
 	unset($_SESSION['basket']['coupon']);
 	$result = 'Coupon Removed Successfully'; 
 }
}
} //ALL REQUESTS PERFORMED

// LITTLE CALCULATIONS:

if(isset($_SESSION['basket']['items'])){
	$items_count = count($_SESSION['basket']['items']);
	foreach($_SESSION['basket']['items'] as $item){
		$price = $item['price']*$item['count'];
		$cart_total = $cart_total + $price;
		$shippingPrice = $shippingPrice + ($item['shipping']*$item['count']);
		$shippingPrice = number_format($shippingPrice, 2, '.', '');
	}
	// COUPONS ARE FUN
	if(isset($_SESSION['basket']['coupon'])){
	if($cart_total >=  $_SESSION['basket']['coupon']['min']){
	$discount =  $_SESSION['basket']['coupon']['discount'];
	if($_SESSION['basket']['coupon']['discount_type'] == '1'){
	$discount = $cart_total  * $discount / 100;
			}
	$discount = number_format($discount, 2, '.', '');
		}else{
		$discount = 0;
		}
	}else{
	$discount = 0;
	}
	$tax = $taxRate * ($cart_total- $discount) /100 ;
	
	
	if(($cart_total- $discount + $tax) >= FREESHIPPING && FREESHIPPING != 0){
	$shippingPrice = 0;
	}
	$cart_total = number_format($cart_total, 2, '.', '');
	$net_amount = number_format(($cart_total + $tax + $shippingPrice - $discount), 2, '.', '');
	
}

if($_REQUEST['action'] == 'count_cart_prod'){
if(count($_SESSION['basket']['items']) > 0){
	echo  count($_SESSION['basket']['items']);
	exit();
}
else
{
	echo 0;
	exit();	
}

}


//COMPLETE SOME MORE REQUESTS
if(isset($_REQUEST['action'])){
// HERE WE COUNT TOTAL ITEMS IN CART
if($_REQUEST['action'] == 'count_cart'){
$message = $items_count;
}
// HERE WE COUNT TOTAL AMOUNT IN CART
if($_REQUEST['action'] =='show_total'){
$message = CS. " ".$net_amount;
}
if($_REQUEST['action'] == 'show_cart'){
if($items_count != 0){
$total = 0;
$message = '<table class=\'table cart-shown-table\'>';
foreach($_SESSION['basket']['items'] as $item){
	$price = $item['price'] *$item['count'];
		if($item['opt_name']){
			$message .= "<tr><td>". $item['name']  . " - " .  $item['opt_name'] . "</td><td>".CS. " ".number_format($price, 2, '.', '')."</td></tr>";
		}else{
			$message .= "<tr><td>". $item['name']  . "</td><td>".CS. " ".number_format($price, 2, '.', '')."</td></tr>";
		}
	}
	$message .= "<tr><td><strong>Sub-Total:</strong></td><td><strong>".CS. " ".number_format($cart_total, 2, '.', '')."</strong></td></tr>";
	
	if($discount != 0){
	$message .= "<tr><td><strong>Discount:</strong></td><td><strong>".CS. " ".$discount."</strong></td></tr>";
	}
	if($taxRate > 0){
	$message .= "<tr><td><strong>Tax @ ($taxRate %):</strong></td><td><strong>".CS. " ".$tax."</strong></td></tr>";
	}
	
		if(SHIPPINGMODE == '1' && $shippingPrice > 0){
		$message .= "<tr><td><strong>Shipping:</strong></td><td><strong>".CS. " ".$shippingPrice."</strong></td></tr>";
	}
	
	$message .= "<tr><td><strong>Total:</strong></td><td><strong>".CS. " ".$net_amount."</strong></td></tr>";
	echo $message;
}else{
$message = "Cart is empty";
}
}
}

//Login and Authentication
if(isset($_REQUEST['login'])){
		if(empty($_REQUEST['email']) || empty($_REQUEST['pwd'])){
			$error = 'Please enter Email and Password';
		}
		else{
		$email=trim($_REQUEST['email']);
		$password=trim($_REQUEST['pwd']);
		$auth->login($email,$password);
		$error = $auth->error;
		}
		}

if(isset($_REQUEST['checkoutWithEmail'])){
		if(empty($_REQUEST['newEmail'])){
			$error = 'Please enter email';
		}
		else{
		$email=trim($_REQUEST['newEmail']);
		if($user->is_new_user($email)){
		$pwd = randomPassword();
		$result= $user->add($email,$pwd);
		if($result == true){
				$result= $auth->login($email,$pwd);
				}
			}else{
	$error =  'Email already registered, Please login to your account';
	}
}
}
// WE NEED TO ADD ADDRESS
if(isset($_REQUEST['add_address'])){
			 
 				$uid = $_SESSION['uid'];
				$name = trim($_POST['addr_name']);
				$addr = mysql_real_escape_string($_POST['addr_addr']);
				$country = trim($_POST['addr_c']);
				$region = trim($_POST['addr_region']);
				$zip = trim($_POST['addr_zip']);
				$mobile = trim($_POST['addr_mob']);
				$result = $address->add($uid,$name,$addr,$country,$region,$zip,$mobile);
}		

if(!empty($address->error)){
$error = $address->error;
}
if(!empty($address->msg)){
$message = $address->msg;
}
if(!empty($cart->error)){
$error = $cart->error;
}
if(!empty($cart->msg)){
$message = $cart->msg;
}
if(!empty($coupon->error)){
$error = $coupon->error;
}
if(!empty($coupon->msg)){
$message = $coupon->msg;
}
if(!empty($auth->error)){
$error = $auth->error;
}
if(!empty($auth->msg)){
$message = $auth->msg;
}
if(!empty($user->error)){
$error = $user->error;
}
if(!empty($user->msg)){
$message = $user->msg;
}




if(isset($_REQUEST['ajax'])){
		if(isset($error) && !empty($error[0])){
		echo "ERROR:".$error;
		exit;
		}
		if(isset($message)){
		echo $message;
		exit;
		}
		
	}
	

// Process Order
		
if(isset($_POST) && isset($_REQUEST['action']) && $auth->is_loggedin()){
unset($error);
$error = array();
$cid = $crypt->decrypt(	$_SESSION['uid']);
if(!isset($_REQUEST['address'])){
$error[] = 'Please Select a proper address' ;
}else{
	$verify = $address->is_address($_REQUEST['address']);
	if(!$verify){
		$error[] = $address->error;
	}
}
	if(!isset($_REQUEST['gateway'])){
		$error[] ='Please Select  a Gateway';
	}
	if(isset($_REQUEST['ajax'])){
		if(isset($error) && !empty($error[0])){
		echo "ERROR:".$error[0];
		exit;
		}
}
$addr_details = $address->details($_REQUEST['address']);
$addr_region = $addr_details['region'];
foreach($_SESSION['basket']['items'] as $item){
			if($item['count'] >= 1){
			if($item['region'] != 0 || $item['region'] !== $addr_region){
			
			}else{
			$error[] = $item['name']." is not available in your location";
			}
			}
			}
	if(SHIPPINGMODE == '2'){
		foreach($regions as $regn){
		if($regn['id'] == $addr_region){
		$shippingPrice = number_format($regn['shipping'],2,'.','');
		$net_amount = $net_amount + $shippingPrice ;
		}
		}
	
	}
	if(($cart_total- $discount + $tax) >= FREESHIPPING && FREESHIPPING != 0){
	$shippingPrice = 0;
	}
if(!isset($error[0])){
$items = json_encode($_SESSION['basket']['items']);
$_SESSION['basket']['order']['address'] = $_REQUEST['address'];
$_SESSION['basket']['order']['gateway'] = $_REQUEST['gateway'];
$_SESSION['basket']['order']['total'] = $cart_total;
$_SESSION['basket']['order']['shipping'] = $shippingPrice;
$_SESSION['basket']['order']['discount'] = $discount;
$_SESSION['basket']['order']['tax'] = $tax;
$_SESSION['basket']['order']['net_amount'] = $net_amount;
foreach($gateways as $gate){
if($gate['file'] == $_SESSION['basket']['order']['gateway']){
$gname = $gate['name'];
break;
}else{
$gname = 'Unknown';
}
}
$ip= $_SERVER['REMOTE_ADDR'];
$gname .= " (IP " . $ip. ")";
if(isset($_SESSION['basket']['coupon']['code'])){
$couponused = ($_SESSION['basket']['coupon']['code'] != 'Invalid Coupon')? $_SESSION['basket']['coupon']['code']: 'None';
}else{
	$couponused = 'None';
}

$order_id = $order->add($cid,$_REQUEST['address'],$items,$net_amount,$cart_total,$tax,$shippingPrice,$discount,$couponused,$gname);

$_SESSION['basket']['order_id'] = $order_id;
$str = $setting['secret'] . $order_id . $cid . $_SESSION['basket']['order']['gateway']; 
$_SESSION['basket']['security'] = md5($str);
$str = $setting['secret'] . $order_id . $cid . '1' . $_SESSION['basket']['order']['gateway']; 
$_SESSION['basket']['security2'] = md5($str);
$URLstring = $setting['website_url']."/gateways/".$_SESSION['basket']['order']['gateway'] ."?symbiotic=symbiotic&curr=".$setting['currency']."&total=$net_amount&order_id=$order_id";
if(isset($_REQUEST['ajax'])){

		echo $URLstring;
		exit;
	}else{
header('location:'.$URLstring);
}
}else{
if(isset($_REQUEST['ajax'])){
		echo "<ul>";
		foreach($error as $err){
		echo "<li>$err</li>";
		}
		echo "</ul>";
		exit;
	}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Ongmac Motorcycles | Cart</title>

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="icon" type="image/vnd.microsoft.icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
  
<link href="symbiotic/style.css" rel="stylesheet"  type="text/css">
<script type="text/javascript" src="symbiotic/jquery.min.js"></script>
<script type="text/javascript" src="symbiotic/cart.js"></script>
<script type="text/javascript">
jQuery.noConflict();
(function($) {
$(document).ready(function(){
$("#continue-shopping-btn").click(function(){
					top.location.href='<?php echo $setting['website_url'];?>';
					});
					});
					
					})(jQuery);
</script>
</head>
<body><div class="container">
<div class="row"><div class="col-md-12 page-header">
<img src="symbiotic/images/logo.png" />
</div>
</div>
<div id='cart-popup'>
<div id="cart-body"><div class="alert" id="sym-alert"></div><span id="cartpage" <?php if(isset($_REQUEST['checkout'])){ echo "style=\"display:none;\"";}?>><h1 class="text-center">Cart</h1>
<?php 
if($items_count >= 1){
	
?>
<form action='<?php echo $setting['website_url'];?>/cart.php' method='post' class="form-horizontal" id='cart-form'>
	<table id="cart-table" class="table table-hover table-striped table-bordered">
	<thead>
	<tr>
	<td>Item</td>
	<td>Option</td>
	<td class="col-md-2">Quantity</td>
	<td class="col-md-2">Unit Price</td>
	<td class="col-md-3">Total Price</td>
	</tr>
	</thead>
	<tbody>
	
	<?php 		

	foreach($_SESSION['basket']['items'] as $key => $item){
	
		$price = $item['price']*$item['count'];
		if($item['shipping'] != 0){
		$append = "<br /><small>Shipping: ". CS . " " .$item['shipping'] ."</small>";
		}else{
		$append ="";
		}
		 $single = number_format($item['price'], 2,'.',',');
		 $net = number_format($price, 2,'.',',');
			if($item['opt_name']){
			echo  "<tr><td>". $item['name']  . "</td><td>" .  $item['opt_name']  . "</td><td><div class=\"col-md-6 no-gutter\"><input class=\"form-control\"   name='item[".$key."][count]' type='text' min='0' value='" .  $item['count'] . "' class=\"sym-count\" id=\"item-$key\">";
			echo "<input type='hidden' name='item[".$key."][id]' value='" .$key . "' class='sym-array-item''></div><div class=\"col-md-6 no-gutter\"><button type=\"button\" name='remove' class='sym-remove btn btn-danger' data-item='".$key."'><i class='glyphicon glyphicon-remove'></i></button></div></td><td>" .  CS . " " .  $single .$append. "</td><td>" .  CS . " " .$net . "</td></tr>";
		}else{
		
			echo  "<tr><td>". $item['name']  . "</td><td> - - </td><td><div class=\"col-md-6 no-gutter\"><input class=\"form-control\"   name='item[".$key."][count]' type='text' min='0' value='" .  $item['count'] . "' class=\"sym-count\" id=\"item-$key\">";
			echo "<input type='hidden' name='item[".$key."][id]' value='" .$key . "'  class='sym-array-item'></div><div class=\"col-md-6 no-gutter\"><button type=\"button\" name='remove' class='sym-remove btn btn-danger' data-item='".$key."'><i class='glyphicon glyphicon-remove'></i></button></div></td><td>" .  CS . " " .   $single .$append. "</td><td>" .  CS . " " .  $net . "</td></tr>";
		}
	}
		?>
	
	</tbody>
	<tfoot>
	<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?php
	$message = "<table class='col-md-12'>";
	$message .= "<tr><td><span class='col-md-6 no-gutter'>Sub-Total:</span><span class='col-md-6'>".CS. " ".number_format($cart_total, 2, '.', '')."</span></td></tr>";
	if($discount != 0){
	$message .= "<tr><td><span class='col-md-6 no-gutter'>Discount:</span><span class='col-md-6'>".CS. " ".$discount."</span></td></tr>";
	}
	if($tax > 0){
	$message .= "<tr><td><span class='col-md-6 no-gutter'>Tax($taxRate %):</span><span class='col-md-6'>".CS. " ".$tax."</span></td></tr>";
	}
	if(SHIPPINGMODE == '1' && $shippingPrice > 0){
	$message .= "<tr><td><span class='col-md-6 no-gutter'>Shipping:</span><span class='col-md-6'>".CS. " ".$shippingPrice."</span></td></tr>";
	}
	$message .= "<tr><td><span class='col-md-6 no-gutter'><strong>Total:</strong></span><span class='col-md-6'><strong>".CS. " ".$net_amount."</strong></span></td></tr>";
	$message .= "</table>";
	echo $message;
	?></td>
	</tr>
	</tfoot>
	</table>
	<button type='submit' id="cart-update-button" name='update' class='btn btn-primary'><i class='glyphicon glyphicon-refresh'></i> Update Cart</button> <button type='button'  name='empty'  class='btn btn-default cart-empty-button'><i class='glyphicon glyphicon-remove-sign'></i> Empty Cart</button>
	</form>
<br>
	<form action="<?php echo $setting['website_url'];?>/cart.php" method="post" id="coupons-form">Got Coupons? Enter here to get Discount<br><div class="col-md-6 no-gutter"><input class="form-control" type="hidden" value="coupon" name="action"><input class="form-control" type="text" name="coupon" id="coupon-input" value="<?php if(isset($_SESSION['basket']['coupon']['code'])){ echo $_SESSION['basket']['coupon']['code'];} ?>">
	</div><div class="col-md-6 no-gutter"><button  type="submit" class='btn btn-primary'><i class='glyphicon glyphicon-ok'></i> Apply Coupon</button><?php if(isset($_SESSION['basket']['coupon']['code'])){ ?> <button   type='button' name='remove' id="coupon-remove" class="btn btn-danger"><i class='glyphicon glyphicon-remove-sign'></i> Remove Coupon</button><?php } ?>
	</div>
	<?php if(isset($_SESSION['basket']['coupon']['discount'])){ 
	$sym = ($_SESSION['basket']['coupon']['discount_type'] == 1)? "%":$setting['currency_symbol'];
	echo "<br><b>Current Coupon: ".$_SESSION['basket']['coupon']['discount'] . $sym." off on order of ". $setting['currency_symbol']. $_SESSION['basket']['coupon']['min']." and above.</b>";
	} ?></form><?php 
	if(!empty($setting['fb_url'])|| !empty($setting['g_url'])){
	?>
<iframe src='<?php echo $setting['website_url'];?>/symbiotic/coupons.php' width='100%' height="100px"style="border:none;" ></iframe>	
<?php } ?><br>
<form  id ="cart-checkout-form" class="text-right" action="<?php echo $setting['website_url'];?>/cart.php?checkout" method="post"><button type='button' class='btn btn-default' id='continue-shopping-btn' >Continue Shopping</button> <button type='submit' name='checkout'  class='btn btn-primary'><i class="glyphicon glyphicon-shopping-cart icon-white"></i> Continue to Checkout</button></form>
	</span>
	<span id="checkoutpage" <?php if(!isset($_REQUEST['checkout'])){ echo "style=\"display:none;\"";}?>>
	<h1 class="text-center">Checkout</h1>
<?php 
if(MINITEMS > $items_count){

		echo "<div class='text-center'>You need atleast ".MINITEMS." items before you can checkout</div>";
}
elseif($net_amount > MAX){

		echo "<div class='text-center'>Order exceed maximum order limit.</div>";
}
elseif($auth->is_loggedin()){
	?>
	<span id="add-address" style="display:none;">
		
		<form class="form-horizontal" action="<?php echo $setting['website_url'];?>/cart.php?add_address" method="post" id="addr-add">
				<h4 class="text-center">Add new address</h4><br />	
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Recipient Name:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_name" value="" id="addr-name" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-addr">Address:</label><div class="col-md-4">
					<textarea  class="form-control" style="width:300px;height:100px;" name="addr_addr" id="addr-addr">
					</textarea></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-c">Country:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_c" value="" id="addr-c" ></div></div>
					 
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-region">Region</label><div class="col-md-4">
					<select  class="form-control"  name="addr_region" id="product-shipping-region">
<?php
foreach($regions as $region){
echo "<option value=\"" . $region['id']. "\">".$region['name']."</option>";
}
?></select>
</div></div>
					<div class="form-group">
									<label class="col-md-3 control-label text-right" for="addr-zip">Zip Code:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_zip" value="" id="addr-zip" ></div></div>
					<div class="form-group">
				
					<label class="col-md-3 control-label text-right" for="addr-mob">Mobile no:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_mob" value="" id="addr-mob" ></div></div>
						<div class="form-group"><div class="col-md-4 col-md-offset-3">  <input class="form-control" type="hidden" value="true" name="add_address">
					<button class="btn btn-primary" type="submit" name="submit" >Save</button>&nbsp;<a id="cancel-add-address" class="btn btn-default">Cancel</a></div>

					</div>
					
				</form></span>
	
	<form  class="checkout-form form-horizontal" id="checkout-form" action="<?php echo $setting['website_url'];?>/cart.php?checkout" method="post">
	<table class="table" id="checkout-table" >
	<tr><td><h2>Hello, <?php echo $_SESSION['curr_user'];?></h2><a href="<?php echo $setting['website_url'];?>/user/sign-in.php?action=signout">signout</a></div></td><td></td></tr><tr>
	<tr><td><h4>Select an Address</h4><a id="add-address-btnn" class="btn btn-default" href="user/addresses.php?action=add">Add a new address</a></td><td></td></tr><tr>
	<?php 
		$all_address = $address->all(); 
		$addr_count= 1;
		foreach($all_address as $addr){
		
		if(!is_int($addr_count/2)){
		echo "<tr>";
		}
		?>
		<td><span class="checkout-cols"><span class="col-md-1 no-gutter"><input class="form-control"  class="radio" type="radio" name="address" value="<?php echo $addr['id']; ?>" id="adr-<?php echo $addr['id']; ?>"></span><span class="col-md-11 no-gutter">
       <label class="radio-label" for="adr-<?php echo $addr['id']; ?>"><b><?php echo $addr['firstname'].' '. $addr['lastname']; ?></b><br>
		

<?php 
if($addr['unitnumber'] != ''){
echo "Address: " . $addr['unitnumber'] ."/". $addr['streetnumber']. ' '. $addr['streetname'].'<br />';
}
else
{
	echo "Address: " .  $addr['streetnumber']. ' '. $addr['streetname'].'<br />';	
}

?>
<?php  if($addr['urbtown'] != ''){echo "Suburb/Town: " . $addr['urbtown'].'<br>';} ?>
<?php  if($addr['postcode'] != ''){echo "Postcode: " . $addr['postcode'].'<br>';} ?>
<?php  if($addr['fax'] != ''){echo "Fax: " . $addr['fax'].'<br>';} ?>
<?php  if($addr['mobile'] != ''){echo "Mobile: " . $addr['mobile'].'<br>';} ?>
<?php  if($addr['state'] != ''){echo "State: " . $addr['state'].'<br>';} ?>
<br />
		<?php
			if(SHIPPINGMODE == '2'){
			?><b>Shipping Charges:</b> <?php
		$r =  $addr['region'];
		foreach($regions as $regn){
		if($regn['id'] == $r){
		echo  $setting['currency_symbol'] ." " .number_format($regn['shipping'],2,'.','');
		}
		}
		 ?></span>
		</span></td>
		<?php
			}
		if(is_int($addr_count/2) && $addr_count != 1 ){
		echo "</tr>";
		}
		$addr_count = $addr_count + 1;
		}
			
		?></tr>
		<tr> <td><h4>Select a Payment Method</h4></td><td><img src="<?php echo $setting['website_url'];?>/symbiotic/images/pay_icons.png"></td></tr>
		<tr>
	<?php 
	$g_count= 1;
	foreach($gateways as $gateway){
	if(!is_int($g_count/2)){
		echo "<tr>";
		}
	
	?>
	<td><span class="checkout-cols"><span class="col-md-1 no-gutter"><input class="form-control" class="radio" type="radio" name="gateway" value="<?php echo $gateway['file']; ?>" id="<?php echo $gateway['file']; ?>"></span><span class="col-md-11 no-gutter"><label class="radio-label" for="<?php echo $gateway['file']; ?>"><?php echo $gateway['name'];
	if(isset($gateway['info'])){
	echo "<br>" . $gateway['info'] ; 
	}
	?></label></span></span></td>
	<?php 
	if(is_int($g_count/2) && $g_count != 1 ){
		echo "</tr>";
		}
		$g_count = $g_count + 1;
	}
	?></tr>
	<tr><td colspan='2'>
	
	</td></tr>
	</table>
	<div class="text-right" ><input class="form-control" type="hidden" name="action" value="checkout"><button type='button'  name='empty'  id="cart-edit-button" class='btn btn-default'><i class='glyphicon glyphicon-shopping-cart'></i> Edit Cart</button> <button type="submit" class="btn btn-primary" name="submit">Place Order</button></div></form>
	
	<?php 
	}else{
	?>
		<div class="col-md-6">
<h4 class="text-center">Sign in</h4>
<form class="form-horizontal" action="<?php echo $setting['website_url'];?>/cart.php?checkout" method="post" id="checkout-login">
  <div class="form-group">
    <label class="col-md-3 control-label text-right" for="inputEmail">Email</label>
    <div class="col-md-9">
      <input class="form-control" type="text" id="inputEmail" placeholder="Email" name="email" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label text-right" for="inputPassword" >Password</label>
    <div class="col-md-9">
      <input class="form-control" type="password" id="inputPassword" name="pwd" placeholder="Password" >
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-9 col-md-offset-3">
      <input class="form-control" type="hidden" name="login">
      <button type="submit" class="btn btn-primary">Sign in</button> <?php if(!empty($setting['fb_app_secret']) && !empty($setting['fb_app_secret'])){ ?><a href='<?php echo $setting['website_url'];?>/user/auth/facebook.php?ref=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>' class="btn btn-default">Login with Facebook</a> <?php }?>
    </div>
  </div>  
  <div class="form-group">
    <div class="col-md-9 col-md-offset-3">
         <a class="btn btn-link" href="user/sign-up.php">Sign up</a> <a class="btn btn-link" href="<?php echo $setting['website_url'];?>/user/sign-in.php?action=recover">Forgot Password</a>
    </div>
  </div>
</form></div><div class="col-md-6"><h4 class="text-center">Checkout using email id</h4>
<form class="form-horizontal" action="<?php echo $setting['website_url'];?>/cart.php?checkout" method="post" id="checkout-by-email">
  <div class="form-group">
    <label class="col-md-3 control-label text-right" for="inputNewEmail">Email</label>
    <div class="col-md-9">
      <input class="form-control" type="text" name="newEmail" id="inputNewEmail" placeholder="Email">
      <input class="form-control" type="hidden" value="true" name="checkoutWithEmail">
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-9 col-md-offset-3">
      <button type="submit" class="btn btn-default">Continue</button> 
    </div>
  </div>
</form>



  </div>
  
 
	</span>
	<?php
	}
	
	}
	else{
		echo "<h4 class='text-center'>Cart is Empty</h4>";
		echo "<div class='text-center'><a href='". $setting['website_url'] ."'><button type='button' class='btn btn-default' >Continue Shopping</button></a></div>";
	}
	?>
	
	</div></div>
<div class="text-right" ><hr>
&copy; Ongmac Motorcycles Centre <?php echo date('Y');?>
</div>
	</div>
</body>
</html>
