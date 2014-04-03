<?php 

class Shipping{
	var $error = '';
	var $msg = '';
	public function region_all(){
	$result = mysql_query("SELECT * FROM  " . PFX . "shipping_regions WHERE active = 1");
	$shipping_regions = array();
	while($rows = mysql_fetch_assoc($result)){
		$shipping_regions[]=$rows;
		}
	return $shipping_regions;
}
	public function is_region($id){
		$result = mysql_query("SELECT active FROM  " . PFX . "shipping_regions WHERE id = '$id' AND  active = 1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such region exists";
		return false;
	}
	public function region_details($id){
		if($this->is_region($id)){
			$result = mysql_query("SELECT * FROM  " . PFX . "shipping_regions WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
		
	
}
?>