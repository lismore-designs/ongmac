<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Coupons'; 
require_once('./include/admin-load.php');
$coupons = $coupon->all();
// Pagination
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 25;
$num = count($coupons);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;


if(!empty($product->msg)){
	$success = $product->msg;
	}
	if(!empty($product->error)){
	$error = $product->error;
	}

////////////////
require_once('./header.php');

?>
<ul class="nav nav-pills"><li>
<a href="coupon-add.php">Add New Coupon</a></li></ul>
<hr>
<?php if($num == 0){
?>
<h2 align='center'>No Coupons Added</h2>
<?php
}else{?>
<div class="text-center"><ul class="pagination">
<?php 
$i='';
$count= 1;
echo "<li><a href=\"coupons.php?page=1\">First</a></li>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<li><a href=\"coupons.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<li><a href=\"coupons.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+ 1;

}
}
echo "<li><a href=\"coupons.php?page=" . $pages . "\">Last</a></li>";
?></ul></div>
<table class="table">
<thead>
<tr>
<th>Coupon ID</th>
<th>Coupon Code</th>
<th>Off Price</th>
<th>Minimum Order Total</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php for($i = $start; $i <= $last; $i++) {
if (isset($coupons[$i])){?>
<tr>
<td><?php echo $coupons[$i]['id']; ?></td>
<td><?php echo $coupons[$i]['code']; ?></td>
<td><?php echo $coupons[$i]['off'] . " "; if ($coupons[$i]['off_type'] == 1) { echo '%';} elseif($coupons[$i]['off_type'] == 2){ echo $setting['currency_symbol'];}?></td>
<td><?php echo $coupons[$i]['order_min'] . " (" . $setting['currency_symbol'] . ")"; ?></td>
<td><ul class="pagination"><li><a href="coupon-edit.php?coupon_id=<?php echo $coupons[$i]['id']; ?>" title="Edit coupon"><i class="glyphicon glyphicon-pencil"></i></li><li></a><a href="coupon-remove.php?coupon_id=<?php echo $coupons[$i]['id']; ?>" title="Remove coupon"><i class="glyphicon glyphicon-trash"></i></a></li></ul></td>
</tr>
<?php }
}?>

</tbody></table>

<?php
}
require_once('./footer.php');

?>