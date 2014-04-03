<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Customer{
	var $error = '';
	var $msg = '';
	var $key = 'SYMBIOTIC';
 
public function all(){
global $crypt;
	$result = mysql_query("SELECT * FROM  " . PFX . "customers");
	$customers = array();
	while($rows = mysql_fetch_assoc($result)){
	$rows['id']= $crypt->encrypt($rows['id']);
		$customers[]=$rows;
		}
	return $customers;
}
public function is_customer($id){
global $crypt;
$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "customers WHERE id = '$id'");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such customer exists";
		return false;
	}
	public function details($id){
	global $crypt;
		if($this->is_customer($id)){
		$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "customers WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			$result['id']= $crypt->encrypt($result['id']);
			return $result;
			}
	
}
$this->error = "No such customer exists";
		return false;
}

	public function address($id){
	global $crypt;
		if($this->is_customer($id)){
		$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "address WHERE customer = '$id' AND active = 1");
			$address = array();
	while($rows = mysql_fetch_assoc($result)){
	$rows['id']= $crypt->encrypt($rows['id']);
		$address[]=$rows;
		}
	return $address;
	}
$this->error = "No such customer exists";
		return false;
}
public function status($id,$status){
global $crypt;
if($this->is_customer($id)){
$id = $crypt->decrypt($id);
$result = mysql_query("UPDATE " . PFX . "customers SET `active` = '$status' WHERE id = '$id'");
$this->msg = "Customer updated successfully";
if($result){
return true;
}
$this->error = "Error occurred";
return false;
}
$this->error = "No such customer exists";
		return false;
}
}
?>