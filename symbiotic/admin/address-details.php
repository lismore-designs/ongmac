<?php
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Address Details'; 
require_once('./include/admin-load.php');
if(isset($_REQUEST['id'])){
	if(!empty($_REQUEST['id'])){
		$details = $address->details($_REQUEST['id']);
	}else{
		header("location:customers.php");
	}
	}else{
		header("location:customers.php");
	}
	if(!empty($address->msg)){
	$success = $address->msg;
	}
	if(!empty($address->error)){
	$error = $address->error;
	}
require_once('./header.php');

?><ul class="nav nav-pills"><li>
<a href="customers.php">Customers</a></li><li><a  href="orders.php">Orders</a></li></ul>
<hr>
<h4>Customer email: <?php $x = $customer->details($details['customer']); echo $x['email'];?></h4><br>
<table ><tr><td>
Name:</td><td><b><?php echo $details['name'];?></b></td></tr><tr><td>
Mobile:</td><td><?php echo $details['mobile'];?></td></tr><tr><td>
Address:</td><td><?php echo nl2br($details['address']);?></td></tr><tr><td>
Country:</td><td><?php echo $details['country'];?></td></tr><tr><td>
ZIP: </td><td><?php echo $details['zip'];?></td></tr>
</table>
<hr>
<?php
require_once('./footer.php');

?>