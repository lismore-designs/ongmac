<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Remove Region'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['region_id'])){
	if(!empty($_REQUEST['region_id'])){
		$details =$shipping->region_details(trim($_REQUEST['region_id']));
	}else{
		header("location:regions.php");
	}
}else{
		header("location:shipping-regions.php");
	}
if(isset($_REQUEST['region_id']) && 'delete' == @$_REQUEST['action']){
if(!empty($_REQUEST['region_id'])){
	
		$result = $shipping->region_remove($_REQUEST['region_id']);
		unset($details);
			}
	
}	

if(!empty($shipping->msg)){
	$success = $shipping->msg;
	}
	if(!empty($shipping->error)){
	$error = $shipping->error;
	}
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="shipping-regions.php" >Shipping Regions</a></li></ul>
<hr>
<?php 
if($details){ 
//print_r($details);
	?>
<h3>Are you sure you want to remove this region?</h3>
<form action="shipping-region-remove.php?region_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Region ID:</label><div class="col-md-4">
<input class="form-control"type="text" name="id" value="<?php echo $details['id']; ?>" disabled></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Name:</label><div class="col-md-4">
<input class="form-control"type="text" name="name" value="<?php echo $details['name']; ?>"  disabled></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<input class="form-control"type="hidden" name="action" value="delete" >
<button class="btn btn-danger">Yes, I am sure. Delete</button></div></div>
</form>
<?php } ?>
<?php
require_once('./footer.php');

?>