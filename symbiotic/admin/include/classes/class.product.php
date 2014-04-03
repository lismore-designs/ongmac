<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
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
public function no_stock(){
	$result = mysql_query("SELECT * FROM  " . PFX . "products WHERE active = 1 AND stock <=5");
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
	public function details($id){
		if($this->is_product($id)){
			$result = mysql_query("SELECT * FROM  " . PFX . "products WHERE id = '$id'");
			while($result = mysql_fetch_assoc($result)){
			return $result;
			}
			}
		return false;
	}
	public function add($name,$price,$description,$stock,$shipping ='0',$region ='0',$partinfo,$partid){
		
		
		$name = trim($name);
		$price = trim($price);
		
		//$image = trim($image);
		$description = trim($description);
		$stock = trim($stock);
		$shipping = trim($shipping);
	
		$region = trim($region);
	if(empty($price) || empty($name)){
			echo 'Please input product name and price';
		
		}
		if(!is_numeric($price)){
			echo 'Invalid Price';
			
		}
		if(!is_numeric($stock)){
			echo  'Invalid Stock';
			
		}
		if(!is_numeric($shipping)){
			echo 'Invalid shipping price';
			
		}
		$shipping = number_format($shipping ,2,'.','');
		$price = number_format($price ,2,'.','');
		
		$functional_id = '';
		$get_prod = mysql_query("SELECT * FROM " . PFX . "products WHERE partid = '$partid'");
		if(mysql_num_rows($get_prod) > 0)
		{
			$qty = '';
			while($row = mysql_fetch_array($get_prod))
			{
				$qty = $row['stock'];
				$functional_id = $row['id'];
			}
			$qty = $qty + $stock;
			$query = "UPDATE " . PFX . "products  SET `stock` = '$qty',`price`='$price' WHERE partid ='$partid'";
			$add = mysql_query($query);
		}
		else
		{
			$query = "INSERT INTO " . PFX . "products (`id`, `name`, `price`,`description`,`stock`,`shipping`,`region`,`active`,`partinfo`,`partid`) VALUES (NULL, '$name' , '$price','$description','$stock','$shipping','$region','1','$partinfo','$partid')";
			$add = mysql_query($query);$functional_id = mysql_insert_id();
		}
		
		echo $functional_id;exit();
		
	/*if($add){
		
		
		//$absPath= dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		//$absPath= $absPath . '/symbiotic/images/products/';
		
		//rename('upload_temp/'.$image,$absPath.$image);
		//rename('upload_temp/small-'.$image,$absPath.'small-'.$image);
		//rename('upload_temp/medium-'.$image,$absPath.'medium-'.$image);
		//rename('upload_temp/large-'.$image,$absPath.'large-'.$image);
		
		//if(isset($_SESSION['uploaded_temp'])){
		//foreach($_SESSION['uploaded_temp'] as $temp_image){
		//if($temp_image != $image){
		//unlink('upload_temp/small-'.$temp_image);
		//unlink('upload_temp/medium-'.$temp_image);
		//unlink('upload_temp/large-'.$temp_image);
		//unlink('upload_temp/'.$temp_image);
		
		//}
		//}
		//unset($_SESSION['uploaded_temp']);
		//}
		
		
		
		
		
		
		
		}else{	
		echo 'Error saving product';}*/
	}
	public function add_option($id,$name,$price){
		$name = trim($name);
		$price = trim($price);
		
		// $price = number_format($price, 2, '.', '');
		if($this->is_product($id)){
		if(empty($price) || empty($name)){
			$this->error = 'Please input product name and price';
			return false;
		}
		if(!is_numeric($price)){
			$this->error = 'Invalid Price';
			return false;
		}
		$price = number_format($price ,2,'.','');
			$add = mysql_query("INSERT INTO " . PFX . "options (`id`, `product_id`, `name`,`price`,`active`) VALUES (NULL, '$id' , '$name','$price','1')");
			if($add){
		$this->msg = "Product option added successfully";
		return true;
		}	
		$this->error = 'Error saving product options';
		return false;
		}
		return false;
	}
public function update($id,$name,$price,$description,$stock,$shipping ='0',$region ='0',$partinfo,$partid){
		$name = trim($name);
		$price = trim($price);
		
	
		$description = trim($description);
		$stock = trim($stock);
		$shipping = trim($shipping);

		$region = trim($region);
		if($this->is_product($id)){
		if(empty($price) || empty($name)){
			$this->error = 'Please input product name and price';
			return false;
		}
		if(!is_numeric($price)){
			$this->error = 'Invalid Price';
			return false;
		}
			if(!is_numeric($stock)){
			$this->error = 'Invalid Stock';
			return false;
		}
		if(!is_numeric($shipping)){
			$this->error = 'Invalid Shipping Price';
			return false;
		}
		$price = number_format($price ,2,'.','');
		$shipping = number_format($shipping ,2,'.','');
					$update = mysql_query("UPDATE " . PFX . "products  SET `name` = '$name',`price` = '$price',`image` = '$image',`description` = '$description',`stock` = '$stock',`shipping`='$shipping',`region`='$region',`partinfo`='$partinfo',`partid`='$partid' WHERE id ='$id'");
								
	if($update){
		$this->msg = "Product updated successfully";
		
			$absPath= dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$absPath= $absPath . '/symbiotic/images/products/';
		
		/*if($image_old != $image){
	
		unlink($absPath . 'small-'.$image_old);
		unlink($absPath . 'medium-'.$image_old);
		unlink($absPath . 'large-'.$image_old);
		unlink($absPath . $image_old);
		rename('upload_temp/'.$image,$absPath.$image);
		rename('upload_temp/small-'.$image,$absPath.'small-'.$image);
		rename('upload_temp/medium-'.$image,$absPath.'medium-'.$image);
		rename('upload_temp/large-'.$image,$absPath.'large-'.$image);
		
		if(isset($_SESSION['uploaded_temp'])){
		foreach($_SESSION['uploaded_temp'] as $temp_image){
		if($temp_image != $image){
		unlink('upload_temp/small-'.$temp_image);
		unlink('upload_temp/medium-'.$temp_image);
		unlink('upload_temp/large-'.$temp_image);
		unlink('upload_temp/'.$temp_image);
		
		}
		}
		unset($_SESSION['uploaded_temp']);
		}
		unset($_SESSION['uploaded_temp']);
		}*/

		
		
		
		
		
		
		return true;
	}
	$this->error = "Error Saving Product";
	return false;
	}
	$this->error = "Error Saving Product";
	return false;
	}
	public function remove($id){
		if($this->is_product($id)){
		$img = $this->details($id);
		$img = $img['image'];
					$update = mysql_query("UPDATE " . PFX . "products  SET `active` = '0' WHERE id ='$id'");
								
	if($update){
	$absPath= dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$absPath= $absPath . '/symbiotic/images/products/';
		unlink($absPath . 'small-'.$img);
		unlink($absPath . 'medium-'.$img);
		unlink($absPath . 'large-'.$img);
		unlink($absPath . $img);
		$this->msg = "Product removed successfully";
		return true;
	}
	$this->error = "Error Removing Product";
	return false;
	}
	$this->error = "Error Removing Product";
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
public function remove_option($id){
			$update = mysql_query("UPDATE " . PFX . "options  SET `active` = '0' WHERE id ='$id'");
								
	if($update){
		return true;
	}
	$this->error = "Error removing product option";
	return false;
	}
	public function by_region($region){
	
			$result = mysql_query("SELECT * FROM  " . PFX . "products WHERE region = '$region'");
			while($result = mysql_fetch_assoc($result)){
			$list[] = $result;
			return $list;
			
			}
		return false;
	}
}
?>