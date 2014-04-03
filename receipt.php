<?php

require_once('symbiotic/cart-load.php');
require_once('symbiotic/gateways.php');
if(isset($_SESSION['basket']['order'])){
$cid = $crypt->decrypt($_SESSION['uid']);
if($_SESSION['basket']['order_id'] == $_REQUEST['order_id']){
$order_id = $_SESSION['basket']['order_id'];
}else{
$order_id = 0;
$_SESSION['basket']['order_id'] = $order_id;
}

$str = $setting['secret'] . $order_id . $cid . $_SESSION['basket']['order']['gateway']; 
$checksum = md5($str);
$str2 = $setting['secret'] . $order_id . $cid . '1' . $_SESSION['basket']['order']['gateway']; 
$checksum2 = md5($str2);
$details = true; //$order->is_order($order_id);
if($_REQUEST['checksum'] == $checksum && $details ){
	if($_REQUEST['auth'] == '1' && $_REQUEST['checksum2'] == $checksum2 ){
		$success = $order->update($order_id, 'payment', '1');
		if($success){
			$status = '1';
			//$sendmail = true;
		}
	}
	elseif($_REQUEST['auth'] == '2'){
	$success = $order->update($order_id, 'payment', '2');
		if($success){
			$status = '2';
			//$sendmail = true;
		}
		}else{
	$success = $order->update($order_id, 'payment', '3');
		if($success){
			$status = '3';
			//$sendmail = true;
		}
 	}
	$success = $order->update($order_id, 'callback', '1');

switch ($status){
	case '1':
	$payment = 'Completed';
	break;
	case '2':
	$payment = 'Pending';
	break;
	case '3':
	$payment = 'Failed';
	break;
	default:
	$payment = 'Unknown';	
}

	$msg = 'Hello, your payment for order no %s is %s. an email has been send to %s. Thanks for Purchasing with us.';
	
	$cart_temp = $_SESSION['basket'];
	$user_email = $_SESSION['curr_user'] ;
	foreach($cart_temp['items'] as $item){
	if($item['count'] > 0){
	$result = $product->stock($item['id'],$item['count']);
	}
	}
	// Email notification
	$headers ="";
	$headers .= "Content-type: text/html; charset=utf-8\n";
    $headers .= "From:Symbiotic Cart <no-reply@".$_SERVER['HTTP_HOST']."> \n";
	$subject = "New order notification";
	$messageUser = "<h2>Hello, ".$user_email ."</h2><br />";
	$messageUser .= "You just placed an order with us.<br />";
	$messageUser.= "Your order id is <b>".$order_id."</b> .<br />";
	$messageUser.= "You can use this order id to track your order on our website<br />";
	$messageUser.= "<br />Payment Status: ".$payment."<br />";
	$messageUser .= "&copy; ".$_SERVER['HTTP_HOST'];
	
	$messageAdmin = "<h2>Hello Admin</h2><br />";
	$messageAdmin .= "There is a new order at website.<br />";
	$messageAdmin.= "Order id is <b>".$order_id."</b> .<br />";
	$messageAdmin.= "<br />Payment Status: ".$payment."<br />";
	$messageAdmin .= "&copy; ".$_SERVER['HTTP_HOST'];
	
	@mail($user_email,$subject,$messageUser,$headers);
	@mail($setting['web_email'],$subject,$messageAdmin,$headers);
		
	unset($_SESSION['basket']);
	$details= $order->details($order_id);
	?>
	
	<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>AJAX Cart for HTML websites with Orders & Invoices</title>

<link href="symbiotic/style.css" rel="stylesheet"  type="text/css">
<script type="text/javascript" src="symbiotic/jquery.min.js"></script>
<script type="text/javascript" src="symbiotic/cart.js"></script>
<script type="text/javascript" src="symbiotic/print.js"></script>
</head>
<body>
<body><div class="container">
<div class="row"><div class="col-md-12 page-header">
<img src="symbiotic/images/logo.png" />
</div>
</div>
<div class="row"><div class="col-md-12">
<div id='cart-popup'>
<div id="cart-body"><h4>Order Recipt</h4>
<center><?php printf($msg,$order_id,$payment,$user_email);?><br><br></center>
<h4>Order Details</h4>
<?php 
if(isset($cart_temp)){
switch ($details['payment']){
	case '1':
	$payment = 'Completed';
	break;
	case '2':
	$payment = 'Pending';
	break;
	case '3':
	$payment = 'Failed';
	break;
	case '4':
	$payment = 'Refunded';
	break;
	default:
	$role = 'Unknown';	
}
switch ($details['status']){
	case '1':
	$status = 'Approved';
	break;
	case '2':
	$status = 'Pending';
	break;
	case '3':
	$status = 'Cancelled';
	break;
	case '4':
	$status = 'Shipped';
	break;
	case '5':
	$status = 'Delivered';
	break;
	case '6':
	$status = 'Returned';
	break;
	default:
	$status = 'Unknown';
}
$details['coupon'] = !empty($details['coupon']) ? $details['coupon']: 'None';
 ?>
<h3>Order ID: <?php echo $order_id; ?></h3>
<table class="table table-bordered">
<thead>
<tr>
<th>Net Amount</th>
<th>Discount Coupon</th>
<th>Tax</th>
<th>Shipping</th>
<th>Gateway</th>
<th>Payment Status</th>
<th>Order Status</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo  $setting['currency_symbol'] ." ".$details['net'] ; ?></td>
<td><?php echo $setting['currency_symbol'] ." ". $details['discount'] . " (" .$details['coupon'] . " )"; ?></td>
<td><?php echo  $setting['currency_symbol'] ." ".$details['tax'] ; ?></td>
<td><?php echo  $setting['currency_symbol'] ." ".$details['shipping'] ; ?></td>
<td><?php echo $details['gateway'];?></td>
<td><?php echo $payment; ?></td>
<td><?php echo $status; ?></td>
</tr>
</tbody>
</table>
<h3>Items</h3>
<table class="table table-bordered ">
<thead>
<tr>
<th>Sr no.</th>
<th>Product Name</th>
<th>Options</th>
<th>Price</th>
<th>Quantity</th>
<th>Total Price</th>
</tr>
</thead>
<tbody><?php 
$products = json_decode($details['items'],true);
$i = 0;
foreach($products as $pro){
	$i = $i + 1;
	if($pro['shipping'] == 0){$append = "";}else{$append = "<br><small>Shipping: ". $setting['currency_symbol'] ." " .$pro['shipping']."</small>";}
	if(empty($pro['opt_name'])){
	$pro['opt_name'] = "None";
	}
?>
<tr>
<td><?php echo $i;?></td>
<td><?php /*?><span class="symbiotic-img" data-size="small"><?php echo $pro['id']; ?></span><?php */?> <?php echo $pro['name'] ; ?></td>
<td><?php echo $pro['opt_name']; ?></td>
<td><?php echo   $setting['currency_symbol'] ." " .number_format($pro['price'], 2, '.', '')  .$append ; ?></td>
<td><?php echo $pro['count']   ; ?></td>
<td><?php echo $setting['currency_symbol'] ." " . number_format($pro['price'] * $pro['count'], 2, '.', '') ;?></td>
</tr>
<?php } ?>
</tbody>
<tfoot><tr>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th>Total: <?php echo $setting['currency_symbol']. " " .$details['amount'];?></th>
</tr></tfoot>
</table>
	<div class='text-center'><a href='<?php echo $setting['website_url'] ?>'><button type='button' class='btn btn-default' ><i class='glyphicon glyphicon-home'></i> Home</button></a> <a href='<?php echo $setting['website_url'] ?>/user'><button type='button' class='btn btn-default' ><i class='glyphicon glyphicon-user'></i> My Account</button></a> <a href='<?php echo $setting['website_url'] ?>/user/order-status.php?id=<?php echo $order_id;?>'><button type='button' class='btn btn-default' ><i class='glyphicon glyphicon-file'></i> View Order Status</button></a></div>
	<?php } ?>
	</div>
	</div>
</div></div>
		
<div class="row">
<div class="span12 text-right" ><hr>
&copy; SuperbLab <?php echo date('Y');?>
</div>
</div>
	</div>
</body>
</html>
	
	<?php 
}
exit;
}
?>
	<html><head><title>Error While Processing Your Order</title></head>
	<body style="color:red;">
	<center><h1>:( Regrets..</h1></center>
	 <center><h2>Sorry an error occured while processing your order.</h2></center>
	 <center><h4>Please Try Again</h4></center>
	 </body></html>
<?php
exit;

?>
