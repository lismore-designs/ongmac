<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Edit Product'; 
require_once('./include/admin-load.php');

if(isset($_REQUEST['product_id'])){
	if(!empty($_REQUEST['product_id'])){
		$details =$product->details(trim($_REQUEST['product_id']));
		if(!empty($details)){
		if(empty($details['shipping'])){
		$details['shipping'] ='0';
		}}
	}else{
		header("location:products.php");
	}
}else{
		$details = $product->details('0');
		
	}
	

	
if(isset($_REQUEST['product_name']) && isset($_REQUEST['product_price'])&& isset($_REQUEST['product_description']) && 
isset($_REQUEST['product_stock'])&& isset($_REQUEST['product_shipping'])&& 
isset($_REQUEST['partinfo'])&& isset($_REQUEST['partid'])&& isset($_REQUEST['product_shipping_region'])){
	
		$product_id = 	trim($_REQUEST['product_id']);
		$product_name = trim($_REQUEST['product_name']);
		$product_price = trim($_REQUEST['product_price']);

		$product_description = trim($_REQUEST['product_description']);
		$product_stock = trim(($_REQUEST['product_stock']));
		$product_shipping = trim($_REQUEST['product_shipping']);
		$product_region = trim($_REQUEST['product_shipping_region']);
		$partinfo = trim($_REQUEST['partinfo']);
		$partid = trim($_REQUEST['partid']);
		
				
		$result = $product->update($product_id,$product_name,$product_price,$product_description,$product_stock,$product_shipping,$product_region,$partinfo,$partid);
		$details =$product->details(trim($_REQUEST['product_id']));
	
}
if(!empty($product->msg)){
	$success = $product->msg;
	}
	if(!empty($product->error)){
	$error = $product->error;
	}
$regions = $shipping->region_all();	
require_once('./header.php');

?>
<?php /*?><ul class="nav nav-pills"><li><a href="products.php" >Products</a></li><li><a href="product-add.php">Add New Product</a></li></ul>
<hr><?php */?>
<?php 
if(!empty($details)){ 

?>
<form action="product-edit.php?product_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Product ID</label><div class="col-md-4">
<input class="form-control"required type="text" name="id" value="<?php echo $details['id']; ?>" disabled></div></div>

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Part ID</label><div class="col-md-4">
<input class="form-control"required type="text" name="partid" value="<?php echo $details['partid']; ?>" ></div></div>


<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Part Info</label><div class="col-md-4">
<input class="form-control"required type="text" name="partinfo" value="<?php echo $details['partinfo']; ?>" ></div></div>



<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-name">Name</label><div class="col-md-4">
<input class="form-control"required type="text" name="product_name" value="<?php echo $details['name']; ?>" id="product-name" ></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-price">Price (<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"required type="text" name="product_price" value="<?php echo $details['price']; ?>" id="product-price"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-description">Description</label><div class="col-md-4">
<textarea class="form-control" required name="product_description" style="width:300px;height:100px;" id="product-description"><?php echo $details['description']; ?></textarea></div></div>
<?php /*?><div class="form-group">
<label class="col-md-3 control-label text-right" for="">Product Image</label><div class="col-md-4">
     	<!-- begin display uploaded image --><a href="#" id="img_init">Click to upload new Image</a>
			<div id="upload_area" class="corners align_center">
            	<img src="../images/products/medium-<?php echo $details['image']; ?>" />
				<input class="form-control" type="hidden" name="product_image" id="product-image" value="<?php echo $details['image']; ?>">
			</div><!-- begin display uploaded image -->

<input class="form-control" type="hidden" name="product_old_image" id="product-old-image" value="<?php echo $details['image']; ?>">
</div></div><?php */?>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-shipping">Shipping Price(<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"required type="text" name="product_shipping" value="<?php echo $details['shipping']; ?>" id="product-shipping"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-stock">Stock</label><div class="col-md-4">
<input class="form-control"required type="text" name="product_stock" value="<?php echo $details['stock']; ?>" id="product-stock"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-shipping-region">Shipping Region</label><div class="col-md-4">
<select class="form-control" name="product_shipping_region" id="product-shipping-region">
<option value="0">All (Default)</option>
<?php
foreach($regions as $region){
if($details['region'] == $region['id']){
echo "<option selected value=\"" . $region['id']. "\">".$region['name']."</option>";
}else{
echo "<option value=\"" . $region['id']. "\">".$region['name']."</option>";
}
}
?></select></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div>

</div>
</table>
</form>
<form action="upload.php" method="post" name="image_upload" id="image_upload" enctype="multipart/form-data"  style="display:none;">

        <!-- begin image label and input -->
		<label>Upload product image (gif, jpg, png)</label>
		<input class="form-control"required type="file" size="45" name="uploadfile" id="uploadfile" class="file margin_5_0" onchange="ajaxUpload(this.form);" /><!-- end image label and input -->
			<br />
           
   

     </form>
	 <script type="text/javascript" src="js/upload.js"></script>
<?php } ?>
<?php
require_once('./footer.php');

?>