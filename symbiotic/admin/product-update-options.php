<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Add Product Options'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['product_id'])){
	if(!empty($_REQUEST['product_id'])){
		$details =$product->details(trim($_REQUEST['product_id']));
			if(!empty($product->error)){
		unset($details);
	}
	}else{
		header("location:products.php");
	}
}else{
		$details = $product->details('0');
	}

if(isset($_REQUEST['product_id']) && isset($_REQUEST['product_name']) && isset($_REQUEST['product_price'])){
	$product_name = trim($_REQUEST['product_name']);
	$product_id = trim($_REQUEST['product_id']);
	$product_name = trim($_REQUEST['product_name']);
	$product_price = trim($_REQUEST['product_price']);
$result =$product->add_option($product_id,$product_name, $product_price);
	
}
if(isset($_REQUEST['remove'])){
	
	$rid = trim($_REQUEST['remove']);
	$product->remove_option($rid);
}
if(!empty($product->msg)){
	$success = $product->msg;
	}
	if(!empty($product->error)){
	$error = $product->error;
	}	
require_once('./header.php');

?>
<ul class="nav nav-pills"><li>
<a href="products.php">Products</a></li><li><a href="product-add.php">Add New Product</a>
</li></ul>
<hr>
<?php 
if(isset($details)){ 
?>
<form action="product-update-options.php?product_id=<?php echo $details['id']; ?>" method="post" class="form-horizontal">
<table><tr>
<td><img src="../images/products/medium-<?php echo $details['image']; ?>" /></td>
<td><table>
<tr><td>Product ID: <?php echo $details['id']; ?></td></tr>
<tr><td><h4><?php echo $details['name']; ?></h4></td></tr>
<tr><td>Price: <?php echo $setting['currency_symbol'] . $details['price']; ?></td></tr>
</table></td></tr></table><br />
<h3>Current Options:</h3>
<?php 
$options = $product->options($details['id']);
foreach ($options as $option){
echo $option['name'] ." - " . $setting['currency_symbol'] . " " . $option['price'] . " - <a href='product-update-options.php?remove=" . $option['id'] . "&product_id=". $details['id'] ."'>Remove</a><br />";
 } ?>


<h3>Add new option</h3>
<div class="form-group"><label class="col-md-3 control-label text-right" for="product-name">Name</label><div class="col-md-4">
<input class="form-control"type="text" name="product_name" value="" id="product-name">
</div></div>
<div class="form-group"><label class="col-md-3 control-label text-right" for="product-price">Price (<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control"type="text" name="product_price" value="" id="product-price">
</div></div>

<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Add Option</button>
</div></div>

</tr>
</table>
</form>
<?php } ?>
<?php
require_once('./footer.php');

?>