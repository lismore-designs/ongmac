<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Orders Details'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['id'])){
	if(!empty($_REQUEST['id'])){
	
			$result = $order->update($_REQUEST['id'], "seen", "yes");
		$order->msg = false;
		
		if(isset($_REQUEST['action'])) { 
		if(isset($_REQUEST['status'])){
			if($_REQUEST['action'] == "paymentstatus"){
				$result = $order->update($_REQUEST['id'], "payment", $_REQUEST['status']);
			}
		if($_REQUEST['action'] == "orderstatus"){
				$result = $order->update($_REQUEST['id'], "status", $_REQUEST['status']);
			}
			}
		
			if($_REQUEST['action'] == "track"){
			$result = $order->update($_REQUEST['id'], "track", $_REQUEST['track']);
			}
			if($_REQUEST['action'] == "trackurl"){
			$result = $order->update($_REQUEST['id'], "track_url", $_REQUEST['track_url']);
			}
			if($_REQUEST['action'] == "remarks"){
			$result = $order->update($_REQUEST['id'], "remarks", $_REQUEST['remarks']);
			}
					}
			
		$details = $order->details($_REQUEST['id']);
		if(!isset($details['id'])){
		unset($details);
		}
	}else{
		header("location:orders.php");
	}
	}
	if(!empty($order->msg)){
	$success = $order->msg;
	}
	if(!empty($order->error)){
	$error = $order->error;
	}
require_once('./header.php');

?><ul class="nav nav-pills"><li>
<a href="orders.php" >All Orders</a></li><li><a href="orders-new.php" >New Orders</a></li><li><a href="orders-monthly.php" >Monthly Orders</a></li><li><a href="create-invoice.php" >Create Invoices</a></li></ul><hr>
<?php if(!isset($details)){?>
<div class="col-md-12">
<form action="order-details.php" method="get" class="form-inline">
<h4>Get Order Details</h4>
<span class="col-md-4 no-gutter">
<input class="form-control"type="text" name="id" placeholder="Order ID" required></span><span class="col-md-4 no-gutter">
<button class="btn btn-default">Show Details</button></span>
</form></div>
<?php } else { 
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
$details['coupon'] = !empty($details['coupon']) ? $details['coupon']: 'None';

 ?>
<h2>Order ID: <?php echo $_REQUEST['id']; ?></h2>

<table  style="width:100%;">
<tr>
<th></th>
<th>Shipping Address</th>
</tr>
<tr>
<td><b>Customer Name:</b> <?php $dis_name = $address->details($details['address']); echo $dis_name['firstname'].' '.$dis_name['lastname'];?><br>
<b>Customer Email:</b> <?php $x = $customer->details($details['customer']); echo $x['email'];?><br>
<b>Date:</b> <?php echo $details['date']; ?><br>
</td>
<td>
<?php
$addr_details = $address->details($details['address']);
?>
<table><tr><td>
Name:</td><td><?php echo $addr_details['firstname'].' '.$addr_details['lastname'];?></td></tr><tr><td>
Mobile:</td><td><?php echo $addr_details['mobile'];?></td></tr><tr><td>
Address:</td><td><?php if($addr_details['unitnumber'] != ''){echo $addr_details['unitnumber'] ."/". $addr_details['streetnumber']. ' '. $addr_details['streetname'].'<br />';}else{	echo $addr_details['streetnumber']. ' '. $addr_details['streetname'].'<br />';	}?></td></tr><tr><td>
Suburb:</td><td><?php echo $addr_details['urbtown']. ', ' .$addr_details['state'];?></td></tr><tr><td>
Postcode: </td><td><?php echo $addr_details['postcode'];?></td></tr>
</table>
</td>
</tr>
</table>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Order Total</th>
<th>Discount Coupon</th>
<th>Tax</th>
<th>Shipping</th>
<th>Net Amount</th>
<th>Gateway</th>
<th>Payment Status</th>
<th>Order Status</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $setting['currency_symbol'] ." ".$details['amount']; ?></td>
<td><?php echo $setting['currency_symbol'] ." ". $details['discount'] . "<br /><small>" .$details['coupon'] . "</small>"; ?></td>
<td><?php echo $setting['currency_symbol'] ." ".$details['tax']; ?></b></td>
<td><?php echo $setting['currency_symbol'] ." ".$details['shipping']; ?></b></td>
<td><?php echo $setting['currency_symbol'] ." ".$details['net']; ?></b></td>
<td><?php echo $details['gateway'];?></td>
<td><?php echo $payment; ?></td>
<td><?php echo $status; ?></td>
</tr>
</tbody>
</table>
<h2>Items</h2>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Product ID</th>
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
$pro['price'] =  number_format($pro['price'], 2, '.', '');
if($pro['shipping'] != 0){
		$append = "<br><small>Shipping: ". $setting['currency_symbol'] ." " .$pro['shipping']."</small>";
		}else{
		$append ="";
		}
		if(empty($pro['opt_name'])){
	$pro['opt_name'] = "None";
	}
?>
<tr>
<td><?php echo $pro['id']; ?></td>
<td><?php echo $pro['name']; ?></td>
<td><?php echo $pro['opt_name']; ?></td>
<td><?php echo $setting['currency_symbol'] ." " .number_format($pro['price'], 2, '.', '')  .$append ; ?></td>
<td><?php echo $pro['count']   ; ?></td>
<td><?php echo $setting['currency_symbol'] ." " .number_format($pro['price']  * $pro['count'], 2, '.', '');?></td>
</tr>
<?php } ?>
</tbody>
</table>
<h2>Update Order</h2>

<table class="table">
<tr>
<td><form action="order-details.php?id=<?php echo $details['id']; ?>" method="post" class="form-inline">
Track ID<br><span class="col-md-8 no-gutter">
<input class="form-control"type="text"  required value="<?php echo $details['track'];?>" name="track" placeholder="Tracking ID" >
 <input class="form-control"type="hidden" name="action" value="track"></span><span class="col-md-4 no-gutter">
<button class="btn btn-default">Update</button></span>
</form></td>
<td><form action="order-details.php?id=<?php echo $details['id']; ?>" method="post" class="form-inline">
Track URL<br><span class="col-md-8 no-gutter">
<input class="form-control"type="text"  class="input-small" required value="<?php echo $details['track_url'];?>" name="track_url" placeholder="Tracking URL" id="track_url">

<input class="form-control"type="hidden" name="action" value="trackurl"></span><span class="col-md-4 no-gutter">
<button class="btn btn-default">Update</button></span>
</form></td>
<td><form action="order-details.php?id=<?php echo $details['id']; ?>" method="post" class="form-inline">
Remarks<br><span class="col-md-8 no-gutter">
<textarea class="form-control" name="remarks"   class="input-small" required ><?php echo $details['remarks'];?></textarea>

<input class="form-control"type="hidden" name="action" value="remarks"></span><span class="col-md-4 no-gutter">
<button class="btn btn-default">Update</button></span>
</form></td>
<td></td>
</tr>
<tr><td>
<form action="order-details.php?id=<?php echo $details['id']; ?>" method="post" class="form-inline">
Payment Status<br><input class="form-control"type="hidden" name="action" value="paymentstatus">
<select class="form-control" name="status"  id="payment_status" class="input-small">
<option value="1" <?php $i=1; if($i == $details['payment']){ echo "selected=selected"; }?>>Completed</option>
<option value="2" <?php $i=2; if($i == $details['payment']){ echo "selected=selected"; }?>>Pending</option>
<option value="3" <?php $i=3; if($i == $details['payment']){ echo "selected=selected";}?>>Failed</option>
<option value="4" <?php $i=4; if($i == $details['payment']){ echo "selected=selected"; }?>>Refunded</option>
</select>&nbsp;
<button class="btn btn-default">Update</button>
</form></td><td>
<form action="order-details.php?id=<?php echo $details['id']; ?>" method="post"  class="form-inline">
Order Status<br><input class="form-control"type="hidden" name="action" value="orderstatus">
<select class="form-control" name="status" id="order_status" class="input-small">
<option value="1" <?php $i=1; if($i == $details['status']){ echo "selected=selected"; }?>>Completed</option>
<option value="2" <?php $i=2; if($i == $details['status']){ echo "selected=selected"; }?>>Pending</option>
<option value="3" <?php $i=3; if($i == $details['status']){ echo "selected=selected"; }?>>Cancelled</option>
<option value="4" <?php $i=4; if($i == $details['status']){ echo "selected=selected"; }?>>Shipped</option>
<option value="5" <?php $i=5; if($i == $details['status']){ echo "selected=selected"; }?>>Delivered</option>
<option value="6" <?php $i=6; if($i == $details['status']){ echo "selected=selected"; }?>>Returned</option>
</select>&nbsp;
<button class="btn btn-default">Update</button>
</form>
</td>
<td>
<form action="create-invoice.php"  method="get" class="form-inline">Invoice<br>
<input class="form-control"type="hidden" name="id" value="<?php echo $details['id']; ?>">
<button class="btn btn-default">Create Invoice</button>
</form>
</td>
</tr>
</table>
<?php }  ?>

<?php
require_once('./footer.php');

?>