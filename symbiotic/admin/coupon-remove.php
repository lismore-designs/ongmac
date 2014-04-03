<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Remove coupon'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['coupon_id'])){
	if(!empty($_REQUEST['coupon_id'])){
		$details =$coupon->details(trim($_REQUEST['coupon_id']));
	}else{
		header("location:coupons.php");
	}
}else{
		$details = $coupon->details('0');
	}
if(isset($_REQUEST['coupon_id']) && 'delete' == @$_REQUEST['action']){
if(!empty($_REQUEST['coupon_id'])){
	
		$result = $coupon->remove($_REQUEST['coupon_id']);
		unset($details);

			}
	
}	

if(!empty($coupon->msg)){
	$success = $coupon->msg;
	}
	if(!empty($coupon->error)){
	$error = $coupon->error;
	}
	
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="coupons.php">Coupons</a></li></ul>
<hr>
<?php 

if(isset($details)){ 
//print_r($details);
	?>
<h3>Are you sure you want to remove this coupon?</h3>
<form action="coupon-remove.php?coupon_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">
<table class="main-table">
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Coupon ID</label><div class="col-md-4">
<input class="form-control"type="text" name="id" value="<?php echo $details['id']; ?>" disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Coupon Code</label><div class="col-md-4">
<input class="form-control"type="text" name="code" value="<?php echo $details['code']; ?>"  disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Discount</label><div class="col-md-4">
<input class="form-control"type="text" name="off" value="<?php echo $details['off'] ." "; if ($details['off_type'] == 1) { echo '%';} elseif($details['off_type'] == 2){ echo $setting['currency'];}?>"  disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Minimum Oder Total (<?php echo $setting['currency_symbol']; ?>)</label><div class="col-md-4">
<input class="form-control"type="text" name="order_min" value="<?php echo $details['order_min']; ?>" id="order-min" disabled></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<input class="form-control"type="hidden" name="action" value="delete">
<button class="btn btn-danger">Yes, I am sure. Delete</button></div></div>
</form>
<?php } ?>
<?php
require_once('./footer.php');

?>