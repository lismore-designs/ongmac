<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Customers'; 
require_once('./include/admin-load.php');
if($user->is_admin(USER)){
if(isset($_REQUEST['action']) && isset($_REQUEST['id'])){
			if($_REQUEST['action'] == "activate"){
				$result = $customer->status($_REQUEST['id'],'1');
				
			}
		if($_REQUEST['action'] == "deactivate"){
				$result = $customer->status($_REQUEST['id'],'0');
				
			}
		
}
$customers = $customer->all();
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 50;
$num = count($customers);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;

if(!empty($customer->msg)){
	$success = $customer->msg;
	}
	if(!empty($customer->error)){
	$error = $customer->error;
	}
}
////////////////
require_once('./header.php');
if($user->is_admin(USER)){
 if($num == 0){
?>
<h2 align='center'>No Customers Registered.</h2>
<?php
}else{?>
<div class="text-center"><ul class="pagination">
<?php 
$i='';
$count= 1;
echo "<li><a href=\"customers.php?page=1\">First</a></li>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<li><a href=\"customers.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<li><a href=\"customers.php?page=" . $i . "\">" . $i . "</a></li>";
$count = $count+ 1;

}
}
echo "<li><a href=\"customers.php?page=" . $pages . "\">Last</a></li>";
?>
</ul></div>
<table class="table">
<thead>
<tr>
<th>ID</th>
<th>Email</th>
<th>Addresses</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php for($i = $start; $i <= $last; $i++) {
if (isset($customers[$i])){

	?>
<tr>
<td><?php echo $customers[$i]['id']; ?></td>
<td><?php echo $customers[$i]['email']; ?> </td>
<td><?php 
$addr = $customer->address($customers[$i]['id']);
$a = 0;
foreach($addr as $ad){
$a = $a + 1;
echo "<a href=\"address-details.php?id=" . $ad['id'] . "\" class=\"addr\">Address " . $a . "</a><br>";
}
 ?></td>
<td><?php
if($customers[$i]['active'] == 1){ ?>
<a href="customers.php?id=<?php echo $customers[$i]['id']; ?>&action=deactivate&page=<?php echo $currpage;?>" class="status">Active</a>
<?php }else{ ?>
<a href="customers.php?id=<?php echo $customers[$i]['id']; ?>&action=activate&page=<?php echo $currpage;?>" class="status">Deactive</a>
<?php }  }
}?></tbody>

</table>
<?php }} else {?>
<p><strong>You are not authorised to view this page.</strong></p>
<?php }

require_once('./footer.php');

?>