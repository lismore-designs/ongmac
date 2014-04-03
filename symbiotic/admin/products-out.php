<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Out of Stock Products'; 
require_once('./include/admin-load.php');
$products = $product->no_stock();
// Pagination
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 25;
$num = count($products);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;


require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a href="product-add.php" >Add New Product</a></li><li><a href="create-html.php" >Create HTML Code</a></li></ul>
<hr>
<?php if($num == 0){
?>
<h2 align='center'>No attention required.</h2>
<?php
}else{?>
<div class="text-center"><ul class="pagination">
<?php 
$i='';
$count= 1;
echo "<li><a href=\"products-out.php?page=1\">First</a></li>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<li><a href=\"products-out.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<li><a href=\"products-out.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+ 1;

}
}
echo "<li><a href=\"products-out.php?page=" . $pages . "\">Last</a></li>";
?></ul>
</div>
<table class="table table-hover">
<thead>
<tr>
<th>Product ID</th>
<th>Name</th>
<th>Price and Shipping (<?php echo $setting['currency_symbol']; ?>)</th>
<th>Options</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php for($i = $start; $i <= $last; $i++) {
if (isset($products[$i])){
if(empty($products[$i]['shipping'])){
$products[$i]['shipping'] = '0';
}
$products[$i]['shipping_charge'] = ($products[$i]['shipping'] !='0')?$products[$i]['shipping']:'Free';
?>
<tr>
<td><?php echo $products[$i]['id']; ?></td>
<td><?php echo $products[$i]['name']; ?></td>
<td><?php echo $products[$i]['price'] ." + ".$products[$i]['shipping_charge']." = ".number_format(($products[$i]['shipping'] + $products[$i]['price']),2); ?></td>
<td>
<?php 
$options = $product->options($products[$i]['id']);

foreach ($options as $option){
echo $option['name'] . " - " . $setting['currency_symbol'] . " " . $option['price'] . "<br>";
 } ?>
</td>
<td><ul class="pagination"><li><a href="product-edit.php?product_id=<?php echo $products[$i]['id']; ?>" title="Edit Product"><i class="glyphicon glyphicon-pencil"></i></a></li><li><a href="product-remove.php?product_id=<?php echo $products[$i]['id']; ?>" title="Remove Product"><i class="glyphicon glyphicon-trash"></i></a></li></ul></td>
</tr>
<?php }
}?>

</tbody></table>

<?php
}
require_once('./footer.php');

?>