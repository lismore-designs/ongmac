<?php
$title='Order Status';
require_once('header.inc.php');
require_once('nav.inc.php');
if(isset($_REQUEST['id'])){
	if(!empty($_REQUEST['id'])){
		$details = $order->details($_REQUEST['id']);
	}else{
		echo "Order  doesn't exists";
	}
	}else{
		$details = false ;
	}
	?>

	<h2>Order Status</h2>
	<hr>
<?php 
if(!$details){?>
<div class="row">
<div class="col-md-12">
<form action="order-status.php" method="get" class="form-inline">
<h4>Get Order Status</h4>
<span class="col-md-4 no-gutter">
<input class="form-control" class="form-control"type="text" name="id" placeholder="Order ID" required></span><span class="col-md-4 no-gutter">
<button class="btn btn-primary">Show Details</button></span>
</form></div></div>
<hr>
<?php
if($order->msg){
	echo "<div class=\"alert alert-success\" style=\"display:block;\">$order->msg</div>";
	}
	if($order->error){
	echo "<div class=\"alert alert-danger\" style=\"display:block;\">$order->error</div>";
	}
} else {
switch ($details['payment']){
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
switch ($details['status']){
	case '1':
	$status = 'Approved';
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
$details['coupon'] = !empty($details['coupon']) ? $details['coupon']: 'None';
 ?>
<h3>Order ID: <?php echo $_REQUEST['id']; ?></h3>
<table class="table table-bordered">
<thead>
<tr>
<th>Net Amount</th>
<th>Discount Coupon</th>
<th>Tax</th>
<th>Shipping</th>
<th>Gateway</th>
<th>Payment Status</th>
<th>Order Status</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo  $setting['currency_symbol'] ." ".$details['net'] ; ?></td>
<td><?php echo $setting['currency_symbol'] ." ". $details['discount'] . " (" .$details['coupon'] . " )"; ?></td>
<td><?php echo  $setting['currency_symbol'] ." ".$details['tax'] ; ?></td>
<td><?php echo  $setting['currency_symbol'] ." ".$details['shipping'] ; ?></td>
<td><?php echo $details['gateway'];?></td>
<td><?php echo $payment; ?></td>
<td><?php echo $status; ?></td>
</tr>
</tbody>
</table>
<h3>Items</h3>
<table class="table table-bordered ">
<thead>
<tr>
<th>Sr no.</th>
<th>Product Name</th>
<th>Options</th>
<th>Price</th>
<th>Quantity</th>
<th>Total Price</th>
</tr>
</thead>
<tbody><?php 
$products = json_decode($details['items'],true);
$i = 0;
foreach($products as $pro){
	$i = $i + 1;
	if($pro['shipping'] == 0){$append = "";}else{$append = "<br><small>Shipping: ". $setting['currency_symbol'] ." " .$pro['shipping']."</small>";}
	if(empty($pro['opt_name'])){
	$pro['opt_name'] = "None";
	}
?>
<tr>
<td><?php echo $i;?></td>
<td><?php /*?><span class="symbiotic-img" data-size="small"><?php echo $pro['id']; ?></span><?php */?> <?php echo $pro['name'] ; ?></td>
<td><?php echo $pro['opt_name']; ?></td>
<td><?php echo   $setting['currency_symbol'] ." " .number_format($pro['price'], 2, '.', '')  .$append ; ?></td>
<td><?php echo $pro['count']   ; ?></td>
<td><?php echo $setting['currency_symbol'] ." " . number_format($pro['price'] * $pro['count'], 2, '.', '') ;?></td>
</tr>
<?php } ?>
</tbody>
<tfoot><tr>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th>Total: <?php echo $setting['currency_symbol']. " " .$details['amount'];?></th>
</tr></tfoot>
</table>
<h3>Shipping Details</h3>
<?php if(!empty($details['track'])){
if(empty($details['track_url'])){$details['track_url'] ="#";} 
echo "Track id:".$details['track'] ." <a href=\"".$details['track_url'] ."\">Click here to track</a>";
 } else {
echo 'No details available yet. Come back later';
}?>
<h3>Order Remarks</h3>
<?php if(!empty($details['remarks'])){
echo $details['remarks'];
}else{
echo 'No details available yet. Come back later';
} 
 }  ?>
 </div>
<?php
require_once('footer.inc.php');
?>