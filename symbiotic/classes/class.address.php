<?php
class Address{
	 var $error = '';
	 var $msg = '';
	var $key = 'SYMBIOTIC';
 
	 
	 	public function is_address($id){
		global $crypt;
			$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "address WHERE id = '$id' AND customer ='" .$crypt->decrypt($_SESSION['uid']) ."' AND active =1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such addres exists";
		return false;
	}
	
	public function all(){
	global $crypt;
	$result = mysql_query("SELECT * FROM  " . PFX . "address WHERE  customer ='" . $crypt->decrypt($_SESSION['uid']) . "' AND active =1 ORDER BY id DESC");
	$address = array();
	while($rows = mysql_fetch_assoc($result)){
	$rows['id']= $crypt->encrypt($rows['id']);
		$address[]=$rows;
		}
	return $address;
	}
	public function details($id){
	global $crypt;
		if($this->is_address($id)){
			$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "address WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			$result['id']= $crypt->encrypt($result['id']);
			return $result;
			}
			}
		return false;
	}
	public function update($id,$column,$data){
	global $crypt;
		
		
		$id = trim($id);
		$column = trim($column);
		$data = trim($data);
		if($this->is_address($id)){
		if(empty($column) || empty($data)){
	$this->msg = false;
	if($column != 'unitnumber' and $column != 'fax' and $column != 'mobile'){
	$this->error = "You did not fill in all the required fields.";
	return false;}
	}
			$id = $crypt->decrypt($id);
	$update = mysql_query("UPDATE " . PFX . "address  SET `$column` = '$data' WHERE id ='$id'");
	if($update){
		$this->msg = "Address updated successfully";
		return true;
	}
	$this->error = "Error updating status";
	return false;
	}
	$this->error = "Error updating status";
	return false;
	}
	public function add($customer,$post){
		$firstname = $post['firstname'];
		$lastname = $post['lastname'];
		$unitnumber = $post['unitnumber'];
		$streetnumber = $post['streetnumber'];
		$streetname = $post['streetname'];
		$urbtown = $post['urbtown'];
		$postcode = $post['postcode'];
		$phone = $post['phone'];
		$fax = $post['fax'];
		$mobile = $post['mobile'];
		$state = $post['state'];
				
		global $crypt;
			
			
			if(empty($customer) || empty($firstname) || empty($lastname) || empty($streetnumber) || empty($streetname) || 
			empty($urbtown) || 
			empty($postcode) || 
			empty($phone) || 
			empty($state)){
				$this->error = "You did not fill in all the required fields.";
			return false;
		}
		
		if(count($this->all()) >= 4){
			$this->error = "You can add only 4 addresses. For adding more address delete previous";
			return false;
		}
		$customer = $crypt->decrypt($customer);
		
		$add = mysql_query("INSERT INTO " . PFX . "address (`id`, `customer`, `firstname`,`lastname`,`unitnumber`,`streetnumber`,`streetname`,`urbtown`,`postcode`,`phone`,`fax`,`mobile`,`state`,`region`) VALUES (NULL, '$customer' ,'$firstname','$lastname','$unitnumber','$streetnumber','$streetname','$urbtown','$postcode','$phone','$fax','$mobile','$state','1')");
	if($add){
		
		$curr_name = $firstname .' '.$lastname;
		
		$_SESSION['curr_user_name'] = $curr_name;
		
	
		
		
	$this->msg = 'Success saving new address';
		return mysql_insert_id();
		}
		$this->error = 'Error saving new address';
		return false;
	
		
	}
}
?>