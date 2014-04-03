<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Overview'; 

require_once('./include/admin-load.php');
$new_orders = $order->all('seen','no');
$setting = $settings->get_all();
require_once('./header.php');
 ?>
 <div class="row">
<div class="col-md-6">
<h3><a href="orders-new.php">New Orders <?php if($num_new > 0){echo "(".$num_new.")";}?></a></h3>
<?php if(isset($new_orders[0])){?>
<table class="table">
<thead>
<tr>
<th>Date</th>
<th>Order ID</th>
<th>Amount</th>
<th>Payment Status</th>
</tr>
</thead>
<tbody>
<?php for($i =0 ; $i<5;$i++){ if(isset($new_orders[$i])){
switch ($new_orders[$i]['payment']){
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
?>
<tr>
<td><?php echo $new_orders[$i]['date'];?></td>
<td><a href="order-details.php?id=<?php echo $new_orders[$i]['id']?>"><?php echo $new_orders[$i]['id'];?></a></td>
<td><?php echo $setting['currency_symbol'] . " " . $new_orders[$i]['net']; ?></td>
<td><?php echo $payment; ?></td>
</tr>
<?php }} ?>
</tbody>
</table><?php } else{
echo "<h3 class='text-center'>No new orders</h3>";
}?>
</div><div class="col-md-6">
<h3><a href="settings.php">Settings</a></h3>
<table class="table">
<thead>
<tr>
<th>Setting</th>
<th>Value</th>
</tr>
</thead>
<tbody>
<tr><td>Website URL</td><td><?php echo $setting['website_url'];?></td></tr>
<tr><td>Admin email</td><td><?php echo $setting['web_email'];?></td></tr>
<tr><td>Invoice email</td><td><?php echo $setting['invoice_email'];?></td></tr>
<tr><td>Currency</td><td><?php echo $setting['currency'] ." (". $setting['currency_symbol'];?> )</td></tr>
</tbody>
</table>

</div></div><div class="row"><div class="col-md-6">

<form action="order-details.php" method="post" class="form-inline">
    <h4>Search Orders:</h4><span class="col-md-8 no-gutter">
<input class="form-control" type="text" name="id" placeholder="Order ID"></span><span class="col-md-4 no-gutter">
<button class="btn btn-default">Show Details</button></span>
</form>

</div><div class="col-md-6">
<form action="create-invoice.php" method="post" class="form-inline"><h4>Create Invoice:</h4>
<span class="col-md-8 no-gutter"><input class="form-control"type="text" name="id" placeholder="Order ID" >
</span><span class="col-md-4 no-gutter"><button class="btn btn-default">Create Invoice</button></span>
</form>

</div>
</div>


<?php
require_once('./footer.php');

?>