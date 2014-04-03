<?php 

class Coupon{
	var $error = '';
	var $msg = '';
	
	public function is_coupon($code){
		$result = mysql_query("SELECT active FROM  " . PFX . "coupons WHERE code = '$code' AND  active = 1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such coupon exists";
		return false;
	}
	public function details($code){
		if($this->is_coupon($code)){
			$result = mysql_query("SELECT * FROM  " . PFX . "coupons WHERE code = '$code'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
	
}
?>