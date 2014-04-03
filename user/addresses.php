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
				'firstname' => trim($_POST['firstname']),
				'lastname' => trim($_POST['lastname']),
				'unitnumber' => trim($_POST['unitnumber']),
				'streetnumber' => trim($_POST['streetnumber']),
				'streetname' => trim($_POST['streetname']),
				'urbtown' => trim($_POST['urbtown']),
				'postcode' => trim($_POST['postcode']),
				'phone' => trim($_POST['phone']),
				'fax' => trim($_POST['fax']),
				'mobile' => trim($_POST['mobile']),
				'state' => trim($_POST['state']),
				'region' => trim($_POST['addr_region'])
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
					<label class="col-md-3 control-label text-right" for="addr-name">First Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="firstname" value="<?php echo $addr['firstname'] ;?>" 
                    id="addr-fname" ></div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Last Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="lastname" value="<?php echo $addr['lastname'] ;?>" 
                    id="addr-lname" ></div></div>
                    
                    
                   <?php /*?> <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_addr">Address:</label><div class="col-md-4">
					<input type="text" class="form-control" name="address" id="addr-addr" value="<?php echo trim($addr['address']) ;?>">
					</div></div><?php */?>
					
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_un">Unit Number</label><div class="col-md-4">
					<input type="text" class="form-control" name="unitnumber" id="addr_un" 
                    value="<?php echo trim($addr['unitnumber']) ;?>">
					</div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_sn">Street Number<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetnumber" id="addr_sn" 
                    value="<?php echo trim($addr['streetnumber']) ;?>">
					</div></div>
                  
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_snn">Street Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetname" id="addr_snn" 
                    value="<?php echo trim($addr['streetname']) ;?>">
					</div></div>
                  
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_st">Suburb/Town<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="urbtown" id="addr_st" value="<?php echo trim($addr['urbtown']) ;?>">
					</div></div>
                    
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_postcode">Postcode<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="postcode" id="addr_postcode" 
                    value="<?php echo trim($addr['postcode']) ;?>">
					</div></div>
                    
                    
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_phone">Phone<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="phone" id="addr_phone" 
                    value="<?php echo trim($addr['phone']) ;?>">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_fax">Fax:</label><div class="col-md-4">
					<input type="text" class="form-control" name="fax" id="addr_fax" 
                    value="<?php echo trim($addr['fax']) ;?>">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_mobile">Mobile:</label><div class="col-md-4">
					<input type="text" class="form-control" name="mobile" id="addr_mobile" 
                    value="<?php echo trim($addr['mobile']) ;?>">
					</div></div>
                  
                  
                  
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-state">State<span style="color:#F00;"> * </span></label>
                    <div class="col-md-4">
					<select  class="form-control"  name="state" id="product-shipping-state">
                    <option value="NSW" <?php if($addr['state'] == 'NSW'){echo 'selected="selected"';}?>>NSW</option>
                    <option value="QLD" <?php if($addr['state'] == 'QLD'){echo 'selected="selected"';}?>>QLD</option>
                    <option value="SA" <?php if($addr['state'] == 'SA'){echo 'selected="selected"';}?>>SA</option>
                    <option value="WA" <?php if($addr['state'] == 'WA'){echo 'selected="selected"';}?>>WA</option>
                    <option value="ACT" <?php if($addr['state'] == 'ACT'){echo 'selected="selected"';}?>>ACT</option>
                    <option value="TAS" <?php if($addr['state'] == 'TAS'){echo 'selected="selected"';}?>>TAS</option>
                    <option value="NT" <?php if($addr['state'] == 'NT'){echo 'selected="selected"';}?>>NT</option>
                    <option value="VIC" <?php if($addr['state'] == 'VIC'){echo 'selected="selected"';}?>>VIC</option>
					</select></div></div>
                  
                    
                    
                    
                    <div class="form-group" style="display:none;">
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
					<div class="form-group"><div class="col-md-4 col-md-offset-3">
					<button type="submit" name="save"  class="btn btn-primary">Save</button></div>
					</div>
					
				</form>
				<?php
			}else{ echo 'Invalid Request';
			}
			}
			elseif(isset($_REQUEST['id']) && $_REQUEST['action'] == "delete"){
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
					<label class="col-md-3 control-label text-right" for="addr-name">First Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="firstname" value="<?php echo $addr['firstname'] ;?>" 
                    id="addr-fname" ></div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Last Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="lastname" value="<?php echo $addr['lastname'] ;?>" 
                    id="addr-lname" ></div></div>
                    
                    
                <?php /*?>    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_addr">Address:</label><div class="col-md-4">
					<input type="text" class="form-control" name="address" id="addr-addr" value="<?php echo trim($addr['address']) ;?>">
					</div></div><?php */?>
					
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_un">Unit Number</label><div class="col-md-4">
					<input type="text" class="form-control" name="unitnumber" id="addr_un" 
                    value="<?php echo trim($addr['unitnumber']) ;?>">
					</div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_sn">Street Number<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetnumber" id="addr_sn" 
                    value="<?php echo trim($addr['streetnumber']) ;?>">
					</div></div>
                  
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_snn">Street Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetname" id="addr_snn" 
                    value="<?php echo trim($addr['streetname']) ;?>">
					</div></div>
                  
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_st">Suburb/Town<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="urbtown" id="addr_st" value="<?php echo trim($addr['urbtown']) ;?>">
					</div></div>
                    
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_postcode">Postcode<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="postcode" id="addr_postcode" 
                    value="<?php echo trim($addr['postcode']) ;?>">
					</div></div>
                    
                    
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_phone">Phone<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="phone" id="addr_phone" 
                    value="<?php echo trim($addr['phone']) ;?>">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_fax">Fax:</label><div class="col-md-4">
					<input type="text" class="form-control" name="fax" id="addr_fax" 
                    value="<?php echo trim($addr['fax']) ;?>">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_mobile">Mobile:</label><div class="col-md-4">
					<input type="text" class="form-control" name="mobile" id="addr_mobile" 
                    value="<?php echo trim($addr['mobile']) ;?>">
					</div></div>
                  
                  
                  
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-state">State<span style="color:#F00;"> * </span></label>
                    <div class="col-md-4">
					<select  class="form-control"  name="state" id="product-shipping-state">
                    <option value="NSW" <?php if($addr['state'] == 'NSW'){echo 'selected="selected"';}?>>NSW</option>
                    <option value="QLD" <?php if($addr['state'] == 'QLD'){echo 'selected="selected"';}?>>QLD</option>
                    <option value="SA" <?php if($addr['state'] == 'SA'){echo 'selected="selected"';}?>>SA</option>
                    <option value="WA" <?php if($addr['state'] == 'WA'){echo 'selected="selected"';}?>>WA</option>
                    <option value="ACT" <?php if($addr['state'] == 'ACT'){echo 'selected="selected"';}?>>ACT</option>
                    <option value="TAS" <?php if($addr['state'] == 'TAS'){echo 'selected="selected"';}?>>TAS</option>
                    <option value="NT" <?php if($addr['state'] == 'NT'){echo 'selected="selected"';}?>>NT</option>
                    <option value="VIC" <?php if($addr['state'] == 'VIC'){echo 'selected="selected"';}?>>VIC</option>
					</select></div></div>
                  
					
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
				
				
				
				$result = $address->add($uid,$_POST);
				
				
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
					<label class="col-md-3 control-label text-right" for="addr-name">First Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="firstname" value="" 
                    id="addr-fname" ></div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr-name">Last Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input class="form-control" type="text" name="lastname" value="" 
                    id="addr-lname" ></div></div>
                    
                    
                    <?php /*?><div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_addr">Address:</label><div class="col-md-4">
					<input type="text" class="form-control" name="address" id="addr-addr" value="">
					</div></div><?php */?>
					
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_un">Unit Number</label><div class="col-md-4">
					<input type="text" class="form-control" name="unitnumber" id="addr_un" 
                    value="">
					</div></div>
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_sn">Street Number<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetnumber" id="addr_sn" 
                    value="">
					</div></div>
                  
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_snn">Street Name<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="streetname" id="addr_snn" 
                    value="">
					</div></div>
                  
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_st">Suburb/Town<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="urbtown" id="addr_st" value="">
					</div></div>
                    
                    
                    <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_postcode">Postcode<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="postcode" id="addr_postcode" 
                    value="">
					</div></div>
                    
                    
                   <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_phone">Phone<span style="color:#F00;"> * </span></label><div class="col-md-4">
					<input type="text" class="form-control" name="phone" id="addr_phone" 
                    value="">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_fax">Fax:</label><div class="col-md-4">
					<input type="text" class="form-control" name="fax" id="addr_fax" 
                    value="">
					</div></div>
                    
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="addr_mobile">Mobile:</label><div class="col-md-4">
					<input type="text" class="form-control" name="mobile" id="addr_mobile" 
                    value="">
					</div></div>
                  
                  
                  
                     <div class="form-group">
					<label class="col-md-3 control-label text-right" for="product-shipping-state">State<span style="color:#F00;"> * </span></label>
                    <div class="col-md-4">
					<select  class="form-control"  name="state" id="product-shipping-state">
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="SA">SA</option>
                    <option value="WA">WA</option>
                    <option value="ACT">ACT</option>
                    <option value="TAS">TAS</option>
                    <option value="NT">NT</option>
                    <option value="VIC" >VIC</option>
					</select></div></div>
                  
                    
                    
                    
                    <div class="form-group" style="display:none;">
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
<strong><?php echo $all_address[$i]['firstname'].' '. $all_address[$i]['lastname'] ; ?></strong><br>

<?php 
if($all_address[$i]['unitnumber'] != ''){
echo "Address: " . $all_address[$i]['unitnumber'] ."/". $all_address[$i]['streetnumber']. ' '. $all_address[$i]['streetname'].'<br />';
}
else
{
	echo "Address: " .  $all_address[$i]['streetnumber']. ' '. $all_address[$i]['streetname'].'<br />';	
}

?>
<?php  if($all_address[$i]['urbtown'] != ''){echo "Suburb/Town: " . $all_address[$i]['urbtown'].'<br>';} ?>
<?php  if($all_address[$i]['postcode'] != ''){echo "Postcode: " . $all_address[$i]['postcode'].'<br>';} ?>
<?php  if($all_address[$i]['fax'] != ''){echo "Fax: " . $all_address[$i]['fax'].'<br>';} ?>
<?php  if($all_address[$i]['mobile'] != ''){echo "Mobile: " . $all_address[$i]['mobile'].'<br>';} ?>
<?php  if($all_address[$i]['state'] != ''){echo "State: " . $all_address[$i]['state'].'<br>';} ?>
<br />
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