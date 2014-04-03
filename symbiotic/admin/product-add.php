<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Add Product'; 
require_once('include/config.php');


@$db_connection = mysql_connect(DBHOST,DBUSER,DBPWD,DBNAME);

if(!$db_connection){
	echo 'Database Connection error</h1>';exit();
}
$db_selection =mysql_select_db(DBNAME,$db_connection);


if(isset($_REQUEST['product_name']) && isset($_REQUEST['product_price'])&& isset($_REQUEST['product_description']) && 
isset($_REQUEST['product_stock'])&& isset($_REQUEST['product_shipping'])&& isset($_REQUEST['partinfo'])&&isset($_REQUEST['partid'])&& isset($_REQUEST['product_shipping_region'])){


		
	$product_name = trim($_REQUEST['product_name']);
	$product_price = trim($_REQUEST['product_price']);
	//$product_image = trim($_REQUEST['product_image']);
	$product_description = trim($_REQUEST['product_description']);
	$product_stock = trim(($_REQUEST['product_stock']));
	$product_shipping = trim($_REQUEST['product_shipping']);
	$product_region = trim($_REQUEST['product_shipping_region']);
	
	$partinfo = trim($_REQUEST['partinfo']);
	$partid = trim($_REQUEST['partid']);
	
	$product_stock = $product_stock + 5;
	
	if(empty($product_shipping)){
	$product_shipping = 0;
	} if(empty($product_region)){
	$product_region = 0;
	}
	
	if(!empty($partinfo) && !empty($partid) && !empty($product_name) && !empty($product_price) && !empty($product_description) && !empty($product_stock) ){
	$result = add($product_name,$product_price,$product_description,$product_stock,$product_shipping,$product_region,$partinfo,$partid);		
	}else{
	$product->error ="All fields are required";
	}


}

function add($name,$price,$description,$stock,$shipping ='0',$region ='0',$partinfo,$partid){
		
		
		$name = trim($name);
		$price = trim($price);
		
		//$image = trim($image);
		$description = trim($description);
		$stock = trim($stock);
		$shipping = trim($shipping);
	
		$region = trim($region);
	if(empty($price) || empty($name)){
			echo 'Please input product name and price';
		
		}
		if(!is_numeric($price)){
			echo 'Invalid Price';
			
		}
		if(!is_numeric($stock)){
			echo  'Invalid Stock';
			
		}
		if(!is_numeric($shipping)){
			echo 'Invalid shipping price';
			
		}
		$shipping = number_format($shipping ,2,'.','');
		$price = number_format($price ,2,'.','');
		
		$functional_id = '';
		$get_prod = mysql_query("SELECT * FROM " . PFX . "products WHERE partid = '$partid'");
		if(mysql_num_rows($get_prod) > 0)
		{
			$qty = '';
			while($row = mysql_fetch_array($get_prod))
			{
				$qty = $row['stock'];
				$functional_id = $row['id'];
			}
			$qty = $qty + $stock;
			$query = "UPDATE " . PFX . "products  SET `stock` = '$qty',`price`='$price' WHERE partid ='$partid'";
			$add = mysql_query($query);
		}
		else
		{
			$query = "INSERT INTO " . PFX . "products (`id`, `name`, `price`,`description`,`stock`,`shipping`,`region`,`active`,`partinfo`,`partid`) VALUES (NULL, '$name' , '$price','$description','$stock','$shipping','$region','1','$partinfo','$partid')";
			$add = mysql_query($query);$functional_id = mysql_insert_id();
		}
		
		echo $functional_id;
}


	/*if(!empty($product->msg)){
	$success = $product->msg;
	}
	if(!empty($product->error)){
	$error = $product->error;
	}
$regions = $shipping->region_all();
require_once('./header.php');
*/
?>
<?php /*?><ul class="nav nav-pills"><li><a href="products.php" >Products</a></li></ul>
<hr>
<form action="product-add.php" method="post" class="form-horizontal">

<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-name">Name</label><div class="col-md-4">
<input class="form-control" required type="text" name="product_name" value="" id="product-name"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-price">Price (<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control" required type="text" name="product_price" value="" id="product-price"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-description">Description</label><div class="col-md-4">
<textarea class="form-control" name="product_description" style="width:300px;height:100px;" id="product-description"></textarea></div></div>
<div class="form-group">
<label required class="col-md-3 control-label text-right" for="img_init">Product Image</label><div class="col-md-4">
<!-- begin display uploaded image --><a href="#" id="img_init">Click to upload new Image</a>
			<div id="upload_area" class="corners align_center">
            	
			</div><!-- begin display uploaded image -->
			</div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-stock">Stock</label><div class="col-md-4">
<input class="form-control" required type="text" name="product_stock"  id="product-stock"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-shipping">Shipping Price(<?php echo $setting['currency_symbol'] ; ?>)</label><div class="col-md-4">
<input class="form-control" required type="text" name="product_shipping" value="0" id="product-shipping"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="product-shipping-region">Shipping Region</label><div class="col-md-4">
<select class="form-control" name="product_shipping_region" id="product-shipping-region">
<option value="0">All (Default)</option>
<?php
foreach($regions as $region){
echo "<option value=\"" . $region['id']. "\">".$region['name']."</option>";
}
?></select></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Add product</button>
</div></div>

</form>
<form action="upload.php" method="post" name="image_upload" id="image_upload" enctype="multipart/form-data" style="display:none;">

        <!-- begin image label and input -->
		<label>Upload product image (gif, jpg, png)</label>
		<input class="form-control" required type="file" size="45" name="uploadfile" id="uploadfile" class="file margin_5_0" onchange="ajaxUpload(this.form);" /><!-- end image label and input -->
		 </form>
		 
<script type="text/javascript" src="js/upload.js"></script>
<?php
require_once('./footer.php');

?><?php */?>