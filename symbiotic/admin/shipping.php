<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Shipping'; 
require_once('./include/admin-load.php');
if($user->is_admin(USER)){
if(isset($_REQUEST['save'])){
if($_REQUEST['save'] == 'shipping'){
	$newsettings = array();
	$newsettings['shipping_min_items'] = $_REQUEST['shipping_min_items'];
	$newsettings['max_order_total'] = $_REQUEST['max_order_total'];
	$newsettings['free_shipping'] = $_REQUEST['free_shipping'];
	$newsettings['shipping_mode'] = $_REQUEST['shipping_mode'];
	$result =$settings->update($newsettings);
}
$setting = $settings->get_all();
}
	
}


if(!empty($settings->msg)){
	$success = $settings->msg;
	}
	if(!empty($settings->error)){
	$error = $settings->error;
	}
	
require_once('./header.php');

if($user->is_admin(USER)){
	 ?>
<ul class="nav nav-pills"><li><a href="shipping-regions.php" >Shipping Regions</a></li></ul>
<hr>
<h3>Shipping Settings</h3>
<form action="shipping.php" method="post" class="form-horizontal">
<input class="form-control"type="hidden" name="save" value="shipping">

<div class="form-group">

<label class="col-md-3 control-label text-right" for="">Minimum no of items in order</label><div class="col-md-4">

<input class="form-control"type="text" name="shipping_min_items" value="<?php echo $setting['shipping_min_items'] ; ?>" id="min-items"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Maximum order total (<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"type="text" name="max_order_total" value="<?php echo $setting['max_order_total'] ; ?>" id="max-order"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Free shipping after(<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"type="text" name="free_shipping" value="<?php echo $setting['free_shipping'] ; ?>" id="max-order">&nbsp; Set 0 to disable free shipping.</div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Shipping mode</label><div class="col-md-4">
<select class="form-control" name="shipping_mode">
<option value="1" <?php if($setting['shipping_mode'] == '1'){echo "selected";}?>>Per item</option>
<option value="2" <?php if($setting['shipping_mode'] == '2'){echo "selected";}?>>Flat Shipping</option>
</select>
&nbsp;Flat shipping overrides shipping prices of individual products.
</div></div>
<div class="form-group"></label><div class="col-md-4 col-md-offset-3"><button class="btn btn-primary">Save</button></div></div>
</form>

<?php } else {?>
<p><strong>You are not authorised to view this page.</strong></p>
<?php } 
require_once('./footer.php');

?>