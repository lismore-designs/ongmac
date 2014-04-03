<?php
class Order{

	 var $error = '';
	 var $msg = '';
	 
 
	 	public function is_order($id){
		global $crypt;
		$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "orders WHERE id = '$id' AND customer ='" .$crypt->decrypt($_SESSION['uid']) ."'");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such order exists";
		return false;
	}
	
	public function all(){
	global $crypt;
	$result = mysql_query("SELECT * FROM  " . PFX . "orders WHERE callback != '0' AND customer ='" . $crypt->decrypt($_SESSION['uid']) . "' ORDER BY id DESC");
	$orders = array();
	while($rows = mysql_fetch_assoc($result)){
	$rows['id']= $crypt->encrypt($rows['id']);
		$orders[]=$rows;
		}
	return $orders;
	}
	public function details($id){
	global $crypt;
		if($this->is_order($id)){
		$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "orders WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
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
	if($this->is_order($id)){
	$id = $crypt->decrypt($id);
	$update = mysql_query("UPDATE " . PFX . "orders  SET `$column` = '$data' WHERE id ='$id'");
	if($update){
		$this->msg = "Status updated successfully";
		return true;
	}
	$this->error = "Error updating status";
	return false;
	}
	$this->error = "Error updating status";
	return false;
	}
	
	public function add($email,$address,$items,$net,$total,$tax,$shipping,$discount,$couponused,$gateway,$id = null){
	global $crypt;
		if($this->is_order($id)){
			return $id;
		}
		$email = trim($email);
		$address = trim($address);
		$address = $crypt->decrypt($address);
		$items =trim($items);
		$net= trim($net);
		$total= trim($total);
		$tax= trim($tax);
		$shipping= trim($shipping);
		$discount= trim($discount);
		$gateway = trim($gateway);
		
		$date = date('d M Y');
		$add = mysql_query("INSERT INTO " . PFX . "orders (`id`, `date`, `items`,`net`, `amount`,`tax`,`discount`,`shipping`,`coupon`, `payment`, `status`,`customer`,`address`,`gateway`,`callback`,`seen`) VALUES (NULL, '$date' , '$items' , '$net','$total' ,'$tax','$discount' ,'$shipping' , '$couponused' , '2', '2','$email','$address','$gateway', '0', 'no')");
	if($add){
	$order_id= $crypt->encrypt(mysql_insert_id());
		return 	$order_id;
		}
		return false;
	}
}
?>