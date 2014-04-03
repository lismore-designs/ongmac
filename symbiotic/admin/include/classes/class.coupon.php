<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
class Coupon{
	var $error = '';
	var $msg = '';
	public function all(){
	$result = mysql_query("SELECT * FROM  " . PFX . "coupons WHERE active = 1");
	$coupons = array();
	while($rows = mysql_fetch_assoc($result)){
		$coupons[]=$rows;
		}
	return $coupons;
}
	public function is_coupon($id){
		$result = mysql_query("SELECT active FROM  " . PFX . "coupons WHERE id = '$id' AND  active = 1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such coupon exists";
		return false;
	}
	public function details($id){
		if($this->is_coupon($id)){
			$result = mysql_query("SELECT * FROM  " . PFX . "coupons WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
	public function add($code,$off,$type,$min){
		$code = trim($code);
		$code = strtoupper($code);
		$off = trim($off);
		$type = trim($type);
		$min = trim($min);
	if(empty($code) || empty($off)){
			$this->error = 'Please input all details';
			return false;
		}
		if(!is_numeric($off)){
			$this->error = 'Invalid details';
			return false;
		}
		if(!is_numeric($type) || $type > 2 || $type < 1){
			$this->error = 'Invalid details';
			return false;
		}
		if(!is_numeric($min)){
			$this->error = 'Invalid details';
			return false;
		}
		
		if($type == '1' && $off > 100){
		$this->error = 'Invalid discount price';
			return false;
		}
				if($type == '2' && $off > $min){
		$this->error = 'Invalid discount price';
			return false;
		}
		if($type == '2'){
		$off = number_format($off,2);
		}
		
		
		$add = mysql_query("INSERT INTO " . PFX . "coupons (`id`, `code`, `off`,`off_type`,`order_min`,`active`) VALUES (NULL, '$code' , '$off','$type','$min','1')");
	if($add){
		$this->msg = "Coupon added successfully";
		return true;
		}	
		$this->error = 'Error saving coupon';
		return false;	
	}
	
public function update($id,$code,$off,$type,$min){
		$code = trim($code);
		$code = strtoupper($code);
		$off = trim($off);
		$min = trim($min);
		if($this->is_coupon($id)){
		if(empty($code) || empty($off)){
			$this->error = 'Please input all details';
			return false;
		}
		if(!is_numeric($type) || $type > 2 || $type < 1){
			$this->error = 'Invalid details';
			return false;
		}
		if(!is_numeric($off)){
			$this->error = 'Invalid details';
			return false;
		}
		if(!is_numeric($min)){
			$this->error = 'Invalid details';
			return false;
		}
		
				if($type == '1' && $off > 100){
		$this->error = 'Invalid discount price';
			return false;
		}
				if($type == '2' && $off > $min){
		$this->error = 'Invalid discount price';
			return false;
		}
		if($type == '2'){
		$off = number_format($off,2);
		}
		
					$update = mysql_query("UPDATE " . PFX . "coupons  SET `code` = '$code',`off` = '$off',`off_type`= '$type',`order_min` = '$min' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Coupon updated successfully";
		return true;
	}
	$this->error = "Error saving coupon";
	return false;
	}
	$this->error = "Error saving coupon";
	return false;
	}
	public function remove($id){
		if($this->is_coupon($id)){
					$update = mysql_query("UPDATE " . PFX . "coupons  SET `active` = '0' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Coupon removed successfully";
		return true;
	}
	$this->error = "Error removing coupon";
	return false;
	}
	$this->error = "Error removing coupon";
	return false;
	}	
	public function restore($id){
		
					$update = mysql_query("UPDATE " . PFX . "coupons  SET `active` = '1' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Coupon restored successfully";
		return true;
	}
	$this->error = "Error restoring coupon";
	return false;
	}
	
		public function deleted(){
	$result = mysql_query("SELECT * FROM  " . PFX . "coupons WHERE active = 0");
	$coupons = array();
	while($rows = mysql_fetch_assoc($result)){
		$coupons[]=$rows;
		}
	return $coupons;
}
}
?>