<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Order{
		
	 var $error = '';
	 var $msg = '';
	 
 
	public function all($parm = null, $value= null){
	global $crypt;
		if($parm && $value){
		$result = mysql_query("SELECT * FROM  " . PFX . "orders WHERE callback != '0' AND $parm = '$value' ORDER BY id DESC");
		}else{
		$result = mysql_query("SELECT * FROM  " . PFX . "orders WHERE callback != '0' ORDER BY id DESC");
		}
	$orders = array();
	while($rows = mysql_fetch_assoc($result)){
		$rows['id']= $crypt->encrypt($rows['id']);
		$rows['customer']= $crypt->encrypt($rows['customer']);
		$orders[]=$rows;
		}
	return $orders;
	}
	public function is_order($id){
	global $crypt;
	$id = $crypt->decrypt($id);
		$result = mysql_query("SELECT id FROM  " . PFX . "orders WHERE id = '$id'");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such order exists";
		return false;
	}
	public function details($id){
	global $crypt;
		if($this->is_order($id)){
		$id = $crypt->decrypt($id);
			$result = mysql_query("SELECT * FROM  " . PFX . "orders WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			$result['id']= $crypt->encrypt($result['id']);
			$result['customer']= $crypt->encrypt($result['customer']);
			$result['address']= $crypt->encrypt($result['address']);
			return $result;
			}
			}
		return false;
	}
	public function update($id,$column,$data){
	global $crypt;
	if($this->is_order($id)){
		$id = trim($id);
		$column = trim($column);
		$data = trim($data);
	 $id = $crypt->decrypt($id);
	$update = mysql_query("UPDATE " . PFX . "orders  SET `$column` = '$data' WHERE id ='$id'");
	if($update){
		$this->msg = "Order updated successfully";
		return true;
	}
	$this->error = "Error updating order";
	return false;
	}
	$this->error = "Error updating order";
	return false;
	}
}
?>