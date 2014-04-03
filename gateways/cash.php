<?php
require_once('../symbiotic/cart-load.php');
if(isset($_REQUEST['symbiotic'])){
$order_id= $_REQUEST['order_id'];
$checksum = $_SESSION['basket']['security'];
$checksum2 = $_SESSION['basket']['security2'];
}
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
	<input type="hidden" name="auth" value="2">
	</form></body></html>
      