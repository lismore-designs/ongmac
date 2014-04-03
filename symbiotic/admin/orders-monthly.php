<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Month Wise Orders'; 
require_once('./include/admin-load.php');

if(isset($_REQUEST['y']) && isset($_REQUEST['y'])){
$getyear=$_REQUEST['y'];
$getmonth=$_REQUEST['m'];
$neworders = array();
$orders = $order->all();
foreach($orders as $ord){
$d = explode(' ',$ord['date']);
if($d[1] == $getmonth && $d[2] == $getyear){
$neworders[]=$ord;
}
}
$thismonth = true;
$orders = $neworders;
// Pagination
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 25;
$num = count($orders);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;

}
////////////////
require_once('./header.php');

?>
<ul class="nav nav-pills"><li>
<a href="orders.php">All Orders</a></li><li><a href="orders-new.php" >New Orders</a></li><li><a href="create-invoice.php" >Create Invoices</a></li></ul>
<hr>
<form action="orders-monthly.php" method="post" class="form-inline">
Please Select Month: <select class="form-control" name="m"  class="input-small">
<?php
for($i=1; $i<=12; $i++){
$monthSName = date("M", mktime(0, 0, 0, $i, 10));
$monthName = date("F", mktime(0, 0, 0, $i, 10));
if(!isset($getyear) || !isset($getmonth)){
$getyear = date('Y');
$getmonth = date('M');
}
if($monthSName == $getmonth) { $sel = 'selected';}else{ $sel = '';}
echo "<option $sel value=\"$monthSName\">$monthName</option>";

}
?></select>&nbsp;<select class="form-control" name="y" class="input-small">
<?php
for($i=2012;$i<=date('Y');$i++){
if($i == $getyear) { $sel = 'selected';} else{ $sel = '';}
echo "<option $sel value=\"$i\">$i</option>";
}
?>
</select>&nbsp;
<button class="btn btn-default">Show</button>
</form>
<?php if(isset($thismonth)) { if($num == 0){
echo "<hr><h2 class='center'>No orders found for $getmonth $getyear</h2>";
}else{?>
<hr><div class="text-center"><ul class="pagination"> 
<?php 
$i='';
$count= 1;
echo "<li><a href=\"orders-monthly.php?page=1&m=$getmonth&y=$getyear\">First</a></li>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<li><a href=\"orders-monthly.php?page=$i&m=$getmonth&y=$getyear\">" . $i . "</a></li>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<li><a href=\"orders-monthly.php?page=$i&m=$getmonth&y=$getyear\">" . $i . "</a></li>";
$count = $count+ 1;

}
}
echo "<li><a href=\"orders-monthly.php?page=$pages&m=$getmonth&y=$getyear\">Last</a></li>";
?>
</ul>
</div>
<table class="table table-hover">
<thead>
<tr>
<th>Date</th>
<th>Order ID</th>
<th>Amount</th>
<th>Gateway</th>
<th>Payment Status</th>
<th>Order Status</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php for($i = $start; $i <= $last; $i++) {
if (isset($orders[$i])){
switch ($orders[$i]['payment']){
	case '1':
	$payment = 'Completed';
	break;
	case '2':
	$payment = 'Pending';
	break;
	case '3':
	$payment = 'Failed';
	break;
	case '4':
	$payment = 'Refunded';
	break;
	default:
	$role = 'Unknown';	
}
switch ($orders[$i]['status']){
	case '1':
	$status = 'Completed';
	break;
	case '2':
	$status = 'Pending';
	break;
	case '3':
	$status = 'Cancelled';
	break;
	case '4':
	$status = 'Shipped';
	break;
	case '5':
	$status = 'Delivered';
	break;
	case '6':
	$status = 'Returned';
	break;
	default:
	$status = 'Unknown';
}

	?>
<tr>
<td><?php echo $orders[$i]['date']; ?></td>
<td><?php echo $orders[$i]['id']; ?></td>
<td><?php echo $setting['currency_symbol'] . " " . $orders[$i]['net']; ?></td>
<td><?php echo $orders[$i]['gateway']; ?></td>
<td><?php echo $payment; ?></td>
<td><?php echo $status; ?></td>
<td><a href="order-details.php?id=<?php echo $orders[$i]['id']; ?>">View / Edit</a></td>
</tr>
<?php }
}?></tbody>

</table>
<?php } }?>
<?php
require_once('./footer.php');

?>