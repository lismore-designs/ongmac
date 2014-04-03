<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
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
	public function region_add($name,$price){
		$name = trim($name);
		$price = trim($price);
		if(!is_numeric($price)){
			$this->error = 'Invalid Price';
			return false;
		}
		$price = number_format($price ,2,'.','');
		
	if(empty($name)){
			$this->error = 'Please input all details';
			return false;
		}
		
		$add = mysql_query("INSERT INTO " . PFX . "shipping_regions (`id`, `name`,`shipping`,`active`) VALUES (NULL, '$name','$price','1')");
	if($add){
		$this->msg = "Region added successfully";
		return true;
		}	
		$this->error = 'Error saving region';
		return false;	
	}
	
public function region_update($id,$name,$price){
		$name = trim($name);
		$price = trim($price);
		if(!is_numeric($price)){
			$this->error = 'Invalid Price';
			return false;
		}
		$price = number_format($price ,2,'.','');
		if($this->is_region($id)){
		if(empty($name)){
			$this->error = 'Please input region name';
			return false;
		}
		
					$update = mysql_query("UPDATE " . PFX . "shipping_regions  SET `name` = '$name',`shipping` = '$price' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Region updated successfully";
		return true;
	}
	$this->error = "Error Saving region";
	return false;
	}
	$this->error = "Error Saving region";
	return false;
	}
	public function region_remove($id){
		if($this->is_region($id)){
					$update = mysql_query("UPDATE " . PFX . "shipping_regions  SET `active` = '0' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Region removed successfully";
		return true;
	}
	$this->error = "Error removing region";
	return false;
	}
	$this->error = "Error removing region";
	return false;
	}
	
	
	
	
}
?>