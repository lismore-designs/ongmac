<?php
$title='My Addresses';
require_once('header.inc.php');
require_once('nav.inc.php');
$regions = $shipping->region_all();
if(isset($_REQUEST['action'])){
		
			if(isset($_REQUEST['id']) && $_REQUEST['action'] == "edit"){
				// Edit Form
				$id = $_REQUEST['id'];
				$verify= $address->is_address($id);
				if($verify){
				if(isset($_REQUEST['save']) && $_POST){
				$save = array(
				'name' => trim($_POST['addr_name']),
				'address' => mysql_real_escape_string($_POST['addr_addr']),
				'country' => trim($_POST['addr_c']),
				'region' => trim($_POST['addr_region']),
				'zip' => trim($_POST['addr_zip']),
				'mobile' => trim($_POST['addr_mob'])
				);
				
				
				
				foreach($save  as $key=>$value){
				
				$result = $address->update($id,$key,$value);
				
				}
								}	
				$addr= $address->details($id);				
				?>
				
				<h2>Edit address</h2>
					<ul class="nav nav-pills">
				 <li><a href="addresses.php" >My Addresses</a></li>
				 <li><a href="addresses.php?action=add" >Add New Address</a></li>
				</ul>
				<hr>
				<?php 
				if($address->msg){
				echo  "<div class=\"alert alert-success\" style=\"display:block;\">".$address->msg."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				if($address->error){
				echo "<div class=\"alert alert-danger\" style=\"display:block;\">".$address->error."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				
				?>
				<form class="form-horizontal" action="addresses.php?id=<?php echo $id; ?>&action=edit" method="post" id="addr-edit">
					
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Recipient Name:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_name" value="<?php echo $addr['name'] ;?>" id="addr-name" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-addr">Address:</label><div class="col-md-4">
					<textarea  class="form-control" style="width:300px;height:100px;" name="addr_addr" id="addr-addr"><?php echo trim($addr['address']) ;?>
					</textarea></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-c">Country:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_c" value="<?php echo $addr['country'] ;?>" id="addr-c" ></div></div>	<div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-region">Region</label><div class="col-md-4">
					<select  class="form-control"  name="addr_region" id="product-shipping-region">
<?php
foreach($regions as $region){
if($addr['region'] == $region['id']){
echo "<option selected value=\"" . $region['id']. "\">".$region['name']."</option>";
}else{
echo "<option value=\"" . $region['id']. "\">".$region['name']."</option>";
}
}
?></select></div></div>
					
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-zip">Zip Code:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_zip" value="<?php echo $addr['zip'] ;?>" id="addr-zip" ></div></div>
					
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-mob">Mobile no:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_mob" value="<?php echo $addr['mobile'] ;?>" id="addr-mob" ></div></div>
					<div class="form-group">
					<div class="form-group"><div class="col-md-4 col-md-offset-3">
					<button type="submit" name="save"  class="btn btn-primary">Save</button></div>
					</div>
					
				</form>
				<?php
			}else{ echo 'Invalid Request';
			}
			}elseif(isset($_REQUEST['id']) && $_REQUEST['action'] == "delete"){
				// Edit Form
				$id = $_REQUEST['id'];
				$verify= $address->is_address($id);
				if($verify){
				if(isset($_REQUEST['delete']) && $_POST){
				
				$result = $address->update($id,'active','2');
				if($address->msg){
				echo "<div class=\"alert alert-success\" style=\"display:block;\">".$address->msg."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				}	
				$addr= $address->details($id);	
if(empty($address->error)){				
				?> 
				<h2>Delete address</h2>
				<ul class="nav nav-pills">
				 <li><a href="addresses.php" >My Addresses</a></li>
				<li> <a href="addresses.php?action=add" >Add New Address</a></li>
				</ul>
				<hr>
				<?php 
				if($address->msg){
				echo  "<div class=\"alert alert-success\" style=\"display:block;\">".$address->msg."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				if($address->error){
				echo "<div class=\"alert alert-danger\" style=\"display:block;\">".$address->error."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				
				?>
				<form class="form-horizontal" action="addresses.php?id=<?php echo $id; ?>&action=delete" method="post" id="addr-del">
					
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Recipient Name:</label><div class="col-md-4">
					<input class="form-control" disabled type="text" name="addr_name" value="<?php echo $addr['name'] ;?>" id="addr-name" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-addr">Address:</label><div class="col-md-4">
					<textarea  class="form-control" disabled style="width:300px;height:100px;" name="addr_addr" id="addr-addr"><?php echo $addr['address'] ;?>
					</textarea></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-c">Country:</label><div class="col-md-4">
					<input class="form-control" disabled type="text" name="addr_c" value="<?php echo $addr['country'] ;?>" id="addr-c" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-zip">Zip Code:</label><div class="col-md-4">
					<input class="form-control" disabled type="text" name="addr_zip" value="<?php echo $addr['zip'] ;?>" id="addr-zip" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-mob">Mobile no:</label><div class="col-md-4">
					<input class="form-control" disabled type="text" name="addr_mob" value="<?php echo $addr['mobile'] ;?>" id="addr-mob" ></div></div>
					
					<div class="form-group"><div class="col-md-4 col-md-offset-3">
					<button class="btn btn-danger"  type="submit" name="delete">Delete</button></div>
					</div>
					
				</form>
				<?php
				}
			}
			else {echo 'Invalid Request';}
			}
			elseif($_REQUEST['action'] == "add"){
			 // Add Form
			 if($_POST){
 				$uid = $_SESSION['uid'];
				$name = trim($_POST['addr_name']);
				$addr = mysql_real_escape_string($_POST['addr_addr']);
				$country = trim($_POST['addr_c']);
				$region = trim($_POST['addr_region']);
				$zip = trim($_POST['addr_zip']);
				$mobile = trim($_POST['addr_mob']);
				
				$result = $address->add($uid,$name,$addr,$country,$region,$zip,$mobile);
				
				
			 }
			 
			 ?>
				<h2>Add new address</h2>
				<ul class="nav nav-pills">
				 <li><a href="addresses.php" >My Addresses</a></li>
				
				</ul>
				<hr>
				<?php
			if($address->msg){
				echo  "<div class=\"alert alert-success\" style=\"display:block;\">".$address->msg."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				if($address->error){
				echo "<div class=\"alert alert-danger\" style=\"display:block;\">".$address->error."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
				?>
				<form class="form-horizontal" action="addresses.php?&action=add" method="post" id="addr-add-userpanel">
					
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Recipient Name:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_name" value="" id="addr-name" ></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-addr">Address:</label><div class="col-md-4">
					<textarea  class="form-control" style="width:300px;height:100px;" name="addr_addr" id="addr-addr">
					</textarea></div></div>
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-c">Country:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_c" value="" id="addr-c" ></div></div>
					 
					<div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-region">Region</label><div class="col-md-4">
					<select  class="form-control"  name="addr_region" id="product-shipping-region">
<?php
foreach($regions as $region){
echo "<option value=\"" . $region['id']. "\">".$region['name']."</option>";
}
?></select>
</div></div>
					<div class="form-group">
									<label class="col-md-3 control-label text-right" for="addr-zip">Zip Code:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_zip" value="" id="addr-zip" ></div></div>
					<div class="form-group">
				
					<label class="col-md-3 control-label text-right" for="addr-mob">Mobile no:</label><div class="col-md-4">
					<input class="form-control" type="text" name="addr_mob" value="" id="addr-mob" ></div></div>
						<div class="form-group"><div class="col-md-4 col-md-offset-3">
					<button class="btn btn-primary"  >Save</button></div>

					</div>
					
				</form>
				<?php
 			}
		

	
		
	}else{
$all_address = $address->all();
/*
$currpage = (isset($_GET['page'])) ? $_GET['page'] : 1;
$maxres = 5;
$num = count($all_address);
$pages = $num / $maxres;
$pages = ceil($pages);
$start = ( $currpage - 1 ) * $maxres ;
$last = $start + $maxres -1;
*/
$start = 0 ;
$last = 4;

?>
<h2>My addresses</h2>
<ul class="nav nav-pills">
		<li>
				 <a href="addresses.php?action=add" >Add New Address</a></li>
				</ul>
				<hr>
<!--<div class="pagination center">Pages: !-->
<?php 
/*
$i='';
$count= 1;
echo "<a href=\"addresses.php?page=1\">First</a>";
for($i = 1 ; $i<=$pages ; $i++){
if(($currpage - $i) <=3  && ($count <= 7)){

echo "<a href=\"addresses.php?page=" . $i . "\">" . $i . "</a>";
$count = $count+1 ;
}
elseif($currpage==$i){
echo "<a href=\"addresses.php?page=" . $i . "\">" . $i . "</a>";
$count = $count+ 1;

}
}
echo "<a href=\"addresses.php?page=" . $pages . "\">Last</a>";
*/
?><!--</div> !-->
<div class="row">
<?php
for($i = $start; $i <= $last; $i++) {
if (isset($all_address[$i])){
?>
<div class="col-md-6">
<strong><?php echo $all_address[$i]['name']; ?></strong><br>
<?php echo nl2br($all_address[$i]['address']); ?><br>
<?php echo $all_address[$i]['country']; ?><br>
<?php echo "Zip Code: " . $all_address[$i]['zip']; ?><br>
<?php echo "Mobile: " . $all_address[$i]['mobile']; ?><br>
<a class="btn btn-link" href="addresses.php?action=edit&id=<?php echo $all_address[$i]['id']; ?>">Edit</a> <a class="btn btn-link" href="addresses.php?action=delete&id=<?php echo $all_address[$i]['id']; ?>">Delete</a><br>
</div>
<?php
}
}
?>
</div>
<?php
}
echo "</div>";
require_once('footer.inc.php');
?>