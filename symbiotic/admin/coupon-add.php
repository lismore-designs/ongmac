<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Add Coupon'; 
require_once('./include/admin-load.php');

if(isset($_REQUEST['coupon_code']) && isset($_REQUEST['coupon_off'])){

	
		
	$coupon_code = trim($_REQUEST['coupon_code']);
	$coupon_off = trim($_REQUEST['coupon_off']);
	$coupon_off_type = trim($_REQUEST['coupon_off_type']);
	$order_min = trim($_REQUEST['order_min']);
$result =$coupon->add($coupon_code,$coupon_off,$coupon_off_type,$order_min );

}
if(!empty($coupon->msg)){
	$success = $coupon->msg;
	}
	if(!empty($coupon->error)){
	$error = $coupon->error;
	}
require_once('./header.php');

?><ul class="nav nav-pills"><li>
<a href="coupons.php" >Coupons</a></li></ul>
<hr>
<form action="coupon-add.php" method="post" class="form-horizontal">

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Coupon Code:</label><div class="col-md-4">
<input class="form-control"required type="text" name="coupon_code" value="" id="coupon-code"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Discount:</label><div class="col-md-4"><span class="col-md-8 no-gutter">
<input class="form-control"required type="text" name="coupon_off" value="" id="coupon-off" class="input-small"> </span><span class="col-md-4 no-gutter">
<select class="form-control" name="coupon_off_type" id="coupon-off-type">
<option value="1" selected>%</option>
<option value="2"><?php echo $setting['currency_symbol']; ?></option>
</select></span>
</div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Minimum Oder Total (<?php echo $setting['currency_symbol']; ?>):</label><div class="col-md-4">
<input class="form-control"required type="text" name="order_min" value="" id="order-min"></div>
</div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Save</button></div></div>
</form>

<?php
require_once('./footer.php');

?>