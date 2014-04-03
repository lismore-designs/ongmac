<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Edit Shipping Region'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['region_id'])){
	if(!empty($_REQUEST['region_id'])){
		$details =$shipping->region_details(trim($_REQUEST['region_id']));
	}else{
		header("location:shipping-regions.php");
	}
}else{
		header("location:shipping-regions.php");
	}
	if($_POST){
if(isset($_REQUEST['region_id']) && isset($_REQUEST['region_name'])&& isset($_REQUEST['region_shipping']) ){
	
		$region_id = 	trim($_REQUEST['region_id']);
		$region_name = trim($_REQUEST['region_name']);
		$region_shipping = trim($_REQUEST['region_shipping']);
			
		$result = $shipping->region_update($region_id,$region_name,$region_shipping);
		$details =$shipping->region_details(trim($_REQUEST['region_id']));

}else{
$error ="All fields are required";
}	}
if(!empty($shipping->msg)){
	$success = $shipping->msg;
	}
	if(!empty($shipping->error)){
	$error = $shipping->error;
	}
	
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="shipping-regions.php">Shipping Regions</a></li><li><a  href="shipping-region-add.php">Add New Region</a></li></ul>
<hr>
<?php 
if(isset($details)){ 
?>
<form action="shipping-region-edit.php?region_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Region ID</label><div class="col-md-4">
<input class="form-control"type="text" name="id" value="<?php echo $details['id']; ?>" disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="region-name">Name</label><div class="col-md-4">
<input class="form-control"type="text" name="region_name" value="<?php echo $details['name']; ?>" id="region-name" ></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="region-shipping">Shipping Charges (<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"type="text" name="region_shipping" value="<?php echo $details['shipping']; ?>" id="region-shipping" >&nbsp; Used in Flat shipping</div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>

</form>
<?php } ?>
<?php
require_once('./footer.php');

?>