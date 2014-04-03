<?php
require_once('../symbiotic/cart-load.php');

$skrill_email = 'concept@concept8.in'; // Set Your Skrill Email HERE
$secret_word= 'TOPSECRET';
if(isset($_REQUEST['symbiotic'])){
$order_id= $_REQUEST['order_id'];
$amount = $_REQUEST['total'];
$curr = $_REQUEST['curr'];
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$checksum = md5($secret_word . $skrill_email);
?>
     <html>
     <head><title>Processing Order...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed and you will be redirected to the Payment Gateway.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>

	<form name="payment_form"  action="https://www.moneybookers.com/app/payment.pl" method="post">
  <input type="hidden" name="pay_to_email" value="<?php echo $skrill_email; ?>"/>
  <input type="hidden" name="status_url" value="<?php echo $this_script; ?>?callback=true&order_id=<?php echo $order_id; ?>&checksum=<?php echo $checksum; ?>"/> 
  <input type="hidden" name="return_url" value="<?php echo $this_script; ?>?order_id=<?php echo $order_id; ?>">
	<input type="hidden" name="cancel_url" value="<?php echo $this_script; ?>?action=cancel&order_id=<?php echo $order_id; ?>">
  <input type="hidden" name="language" value="EN"/>
  <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
  <input type="hidden" name="currency" value="<?php echo $curr; ?>"/>
  <input type="hidden" name="detail1_description" value="Order no <?php echo $order_id; ?>"/>
  <input type="hidden" name="detail1_text" value="Online Shoping"/>
  
</form>

	
	</form></body></html>
	<?php exit; 
} elseif(isset($_GET['callback'])){
	if($_GET['checksum'] == md5($secret_word . $_POST['pay_to_email']) && $details = $order->is_order($_GET['$order_id'])){
	$order_id = $_GET['$order_id'];
	
switch($_REQUEST['status']) {
					case '2':
					$success = $order->update($order_id, 'payment', '1');
					$success = $order->update($order_id, 'callback', '1');
					break;
					
					case '0':
					$success = $order->update($order_id, 'payment', '2');
					$success = $order->update($order_id, 'callback', '1');
					break;
					
					case '-2':
					$success = $order->update($order_id, 'payment', '3');
					$success = $order->update($order_id, 'callback', '1');
					break;
					
	
	}
	}
	exit;
	}

	else{
	
	if(isset($_GET['action'])){
	if($_GET['action'] =='cancel'){
	$order_id = $_GET['order_id'];
	
					$payment = '3';
					$checksum = $_SESSION['basket']['security'];

			$checksum2 = $_SESSION['basket']['security2'];
?>
 <html>
     <head><title>Processing your Payment...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>
	<form method="post" name="payment_form"  action="<?php echo $setting['website_url'];?>/receipt.php">
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" name="checksum" value="<?php echo $checksum; ?>">
	<input type="hidden" name="checksum2" value="<?php echo $checksum2; ?>">
	<input type="hidden" name="auth" value="<?php echo $payment; ?>">
	</form></body></html>
	<?php 
	exit;
	}}
	if(isset($_SESSION['basket']['order'])){
	$email = $_SESSION['basket']['order']['email'];
if($_SESSION['basket']['order_id']){
$order_id = $_SESSION['basket']['order_id'];
}else{
$order_id = 0;
$_SESSION['basket']['order_id'] = $order_id;
}
$status = $order->details($order_id);
$status =$status['payment'];
		
					$payment = $status;
					$checksum = $_SESSION['basket']['security'];

			$checksum2 = $_SESSION['basket']['security2'];
?>
 <html>
     <head><title>Processing your Payment...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>
	<form method="post" name="payment_form"  action="<?php echo $setting['website_url'];?>/receipt.php">
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" name="checksum" value="<?php echo $checksum; ?>">
	<input type="hidden" name="checksum2" value="<?php echo $checksum2; ?>">
	<input type="hidden" name="auth" value="<?php echo $payment; ?>">
	</form></body></html>
	
	<?php 
	
exit;
	}}
?>