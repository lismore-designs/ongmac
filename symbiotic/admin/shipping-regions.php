<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Shipping Regions'; 
require_once('./include/admin-load.php');
$regions = $shipping->region_all();
// Pagination
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 25;
$num = count($regions);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;
require_once('./header.php');

?>
<ul class="nav nav-pills"><li><a  href="shipping-region-add.php">Add a Shipping Region</a></li><li><a  href="shipping.php">Shipping Settings</a></li></ul>
<hr>
<div class="text-center"><ul class="pagination">
<?php 
$i='';
$count= 1;
echo "<li><a href=\"shipping-regions.php?page=1\">First</a></li>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<li><a href=\"shipping-regions.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<li><a href=\"shipping-regions.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+ 1;

}
}
echo "<li><a href=\"shipping-regions.php?page=" . $pages . "\">Last</a></li>";
?></ul></div>
<table class="table">
<thead>
<tr>
<th>Region ID</th>
<th>Name</th>
<th>Shipping (<?php echo $setting['currency_symbol'] ; ?>)</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php for($i = $start; $i <= $last; $i++) {
if (isset($regions[$i])){?>
<tr>
<td><?php echo $regions[$i]['id']; ?></td>
<td><?php echo $regions[$i]['name']; ?></td>
<td><?php echo $regions[$i]['shipping'] ; ?></td>
<td><ul class="pagination"><li><a href="shipping-region-edit.php?region_id=<?php echo $regions[$i]['id']; ?>" title="Edit Region"><i class="glyphicon glyphicon-pencil"></i></a></li><li><a href="shipping-region-remove.php?region_id=<?php echo $regions[$i]['id']; ?>" title="Remove Region"><i class="glyphicon glyphicon-trash"></i></a></li></ul></td>
</tr>
<?php }
}?>

</tbody></table>
* Products available in all regions
<?php 
require_once('./footer.php');

?>