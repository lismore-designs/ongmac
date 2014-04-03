<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Remove Product'; 
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
if(isset($_REQUEST['product_id']) && isset($_REQUEST['action'])){
if(!empty($_REQUEST['product_id']) && $_REQUEST['action'] =="delete"){
	
		$result = $product->remove($_REQUEST['product_id']);
		unset($details);

			}
	
}
if(!empty($product->msg)){
	$success = $product->msg;
	}
	if(!empty($product->error)){
	$error = $product->error;
	}	
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="products.php" >Products</a></li></ul>
<hr>
<?php 
if(isset($details)){ 
?>
<h3>Are you sure you want to remove "<?php echo $details['name']; ?>" from products?</h3>

<table><tr>
<td><img src="../images/products/medium-<?php echo $details['image']; ?>" /></td>
<td><table>
<tr><td>Product ID: <?php echo $details['id']; ?></td></tr>
<tr><td><h4><?php echo $details['name']; ?></h4></td></tr>
<tr><td>Price: <?php echo $setting['currency_symbol'] . $details['price']; ?></td></tr>
</table></td></tr></table><br />
<form action="product-remove.php?product_id=<?php echo $details['id']; ?>" method="post" ><input class="form-control"type="hidden" name="action" value="delete">
<button class="btn btn-danger">Yes, I am Sure. Delete</button>
</form>
<?php } ?>
<?php
require_once('./footer.php');

?>