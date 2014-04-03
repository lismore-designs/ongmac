<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Create HTML Code'; 
require_once('./include/admin-load.php');
$products = $product->all();
require_once('./header.php');
?>
<ul class="nav nav-pills"><li>
<a href="integration.php" >Integration</a></li><li><a href="products.php" >Products</a></li></ul>
<hr>
<form action="create-html.php" class="form-inline" method="post" id="createHTML">
<table class="table text-center ">
<tr>
<th>Product ID</th>
<th>Product Name</th>
<th>Quantity Box</th>
<th>Button Text</th>
<th>Product Price</th>
<th>Product Options</th>
<th></th>
</tr>
<tr>
<td><select class="form-control" class="input-small"  name="product_id" id="product-id">;
<?php foreach ($products as $pro){
echo "<option value=\"".$pro["id"]."\">".$pro["id"]." - ".$pro["name"]."</option>";
}?>
</select>
<td><select class="form-control" class="input-small"  name="product_name" id="product-name">
<option value="1">Show</option>
<option value="0">Don't Show</option>
</select></td>
<td><select class="form-control" class="input-small"  name="product_qty" id="product-qty">
<option value="1">Show</option>
<option value="0">Don't Show</option>
</select></td>
<td><input class="form-control"type="text"  class="input-small" name="button_text" value="" id="button-text" ></td>
<td><select class="form-control" class="input-small"  name="product_price" id="product-price">
<option value="1">Show</option>
<option value="0">Don't Show</option>
</select></td>
<td><select class="form-control" class="input-small"  name="product_options" id="product-options">
<option value="1">Show</option>
<option value="0" selected >Don't Show</option>
</select></td>
<td><button class="btn btn-primary">Create HTML Code</button></td>
</tr>
</table>
</form><hr>
<div id="generated" style="display:none;">
<h3>Copy the code from here</h3>
<h4>Buy Button Code</h4>
<pre id="btn-code"></pre>
<h4>Product LightBox Code</h4>
<pre id="lb-code"></pre>
<h4>Description Code</h4>
<pre id="desc-code"></pre>
<span id="desc-code-demo"></span><br /><br />
<h4>Small Image</h4>
<pre id="img-small-code"></pre>
<span id="img-small-code-demo"></span><br /><br />
<h4>Medium Image</h4>
<pre id="img-med-code"></pre>
<span id="img-med-code-demo"></span><br /><br />
<h4>Large Image</h4>
<pre id="img-large-code"></pre>
<span id="img-large-code-demo"></span><br /><br />
<h4>Normal Image</h4>
<pre id="img-code"></pre>
<span id="img-code-demo"></span><br /><br />
<button type="button" class="btn btn-default" id="hideCode">Hide</button>
</div>

<script type="text/javascript">
jQuery.noConflict();
(function($) {
$(document).ready(function(){
$("#createHTML").unbind().bind('submit',function(){
$("#message").hide();
$("#generated").hide();
var inputId=$("#product-id").val();
if(inputId == ""){
	$("#message").text("Please enter a product id");
	$("#message").show();
	return false;
}
var name =$("#product-name").val();
var price =$("#product-price").val();
var qty =$("#product-qty").val();
var opt =$("#product-options").val();
var btnText =$("#button-text").val();

var addOns ="";
if(name =='1'){ addOns = addOns + "data-name='show' "}
if(price =='1'){ addOns = addOns + "data-price='show' "}
if(qty =='1'){ addOns = addOns + "data-qty='show' "}
if(opt =='1'){ addOns = addOns + "data-options='show' "}
if(btnText !=''){ addOns = addOns + "data-text='"+btnText+"'"}

$("#btn-code").text("<span class='symbiotic' "+addOns+">"+inputId+"</span>");
$("#lb-code").text("<a href='#' class='symbiotic-lightBox' data-id='"+inputId+"'>Product Details</a>");
$("#desc-code").text("<span class='symbiotic-desc'>"+inputId+"</span>");
$("#desc-code-demo").html("<span class='symbiotic-desc'>"+inputId+"</span>");
$("#img-small-code").text("<span class='symbiotic-img' data-size='small'>"+inputId+"</span>");
$("#img-small-code-demo").html("<span class='symbiotic-img' data-size='small'>"+inputId+"</span>");
$("#img-med-code").text("<span class='symbiotic-img' data-size='medium'>"+inputId+"</span>");
$("#img-med-code-demo").html("<span class='symbiotic-img' data-size='medium'>"+inputId+"</span>");
$("#img-large-code").text("<span class='symbiotic-img' data-size='large'>"+inputId+"</span>");
$("#img-large-code-demo").html("<span class='symbiotic-img' data-size='large'>"+inputId+"</span>");
$("#img-code").text("<span class='symbiotic-img'>"+inputId+"</span>");
$("#img-code-demo").html("<span class='symbiotic-img'>"+inputId+"</span>");
$.getScript('../cart.js');
$("#generated").slideDown();
				return false;
});

	$("#hideCode").click(function(){
		$("#generated").slideUp();
		});
});
})(jQuery);
</script>
<?php
require_once('./footer.php');

?>