<?php 

class Product{
	var $error = '';
	var $msg = '';
	public function all(){
	$result = mysql_query("SELECT * FROM  " . PFX . "products WHERE active = 1");
	$products = array();
	while($rows = mysql_fetch_assoc($result)){
		$products[]=$rows;
		}
	return $products;
}
	public function is_product($id){
		$result = mysql_query("SELECT active FROM  " . PFX . "products WHERE id = '$id' AND  active = 1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such product exists";
		return false;
	}
	public function is_option($id){
		$result = mysql_query("SELECT active FROM  " . PFX . "options WHERE id = '$id' AND  active = 1");
		if(mysql_num_rows($result) == 1){
		return true;
		}
		$this->error = "No such product exists";
		return false;
	}
	public function details($id){
		if($this->is_product($id)){
			$result = mysql_query("SELECT * FROM  " . PFX . "products WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
	public function option_details($id){
		if($this->is_option($id)){
			$result = mysql_query("SELECT * FROM  " . PFX . "options WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
	
	
	public function options($id){
		if($this->is_product($id)){
			$options = array();
		$result = mysql_query("SELECT * FROM " . PFX . "options WHERE product_id = '$id' AND active = '1'");
			while($rows = mysql_fetch_assoc($result)){
			$options[] =  $rows;
			}	
			return  $options;
		}
	$this->error = "Product not found";
	return false;
	}
public function stock($id,$stock){
		$id = trim($id);
		$stock = trim($stock);
		// $price = number_format($price, 2, '.', '');
		if($this->is_product($id)){
		if(!is_numeric($stock)){
			$this->error = 'Unknown error';
			return false;
		}
		$details = $this->details($id);
		$newStock = $details['stock'] - $stock ;
		$update = mysql_query("UPDATE " . PFX . "products  SET `stock` = '$newStock' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Product updated successfully";
		return true;
	}
	$this->error = "Error Saving Product";
	return false;
	}
	$this->error = "Error Saving Product";
	return false;
	}
	
}
?>