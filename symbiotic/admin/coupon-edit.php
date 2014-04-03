<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Edit coupon'; 
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
if(isset($_REQUEST['coupon_id']) && isset($_REQUEST['coupon_code']) && isset($_REQUEST['coupon_off'])  && isset($_REQUEST['order_min'])){
	
		$coupon_id = 	trim($_REQUEST['coupon_id']);
		$coupon_code = trim($_REQUEST['coupon_code']);
		$coupon_off = trim($_REQUEST['coupon_off']);
		$coupon_off_type = trim($_REQUEST['coupon_off_type']);
		$order_min = trim($_REQUEST['order_min']);
	
		$result = $coupon->update($coupon_id,$coupon_code,$coupon_off,$coupon_off_type,$order_min);
		$details =$coupon->details(trim($_REQUEST['coupon_id']));
	
		
	
}
if(!empty($coupon->msg)){
	$success = $coupon->msg;
	}
	if(!empty($coupon->error)){
	$error = $coupon->error;
	}	
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="coupons.php">Coupons</a></li><li><a href="coupon-add.php" >Add New Coupon</a></li></ul>
<hr>
<?php 

if(isset($details)){ 
?>
<form action="coupon-edit.php?coupon_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Coupon ID:</label><div class="col-md-4">
<input class="form-control"type="text" name="id" value="<?php echo $details['id']; ?>" disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Coupon Code:</label><div class="col-md-4">
<input class="form-control"type="text" name="coupon_code" value="<?php echo $details['code']; ?>" id="coupon-code" ></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Discount:</label><div class="col-md-4"><span class="col-md-8 no-gutter">
<input class="form-control"type="text" name="coupon_off" value="<?php echo $details['off']; ?>" class="input-small"></span><span class="col-md-4 no-gutter">
<select class="form-control" name="coupon_off_type" id="coupon-off-type">
<option value="1" <?php if ($details['off_type'] == 1) { echo 'selected';}?>>%</option>
<option value="2" <?php if ($details['off_type'] == 2) { echo 'selected';}?>><?php echo $setting['currency_symbol']; ?></option>
</select>
</span></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Minimum Oder Total (<?php echo $setting['currency_symbol']; ?>):</label><div class="col-md-4">
<input class="form-control"type="text" name="order_min" value="<?php echo $details['order_min']; ?>" id="order-min"></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Save</button></div></div>
</form>
<?php } ?>
<?php
require_once('./footer.php');

?>