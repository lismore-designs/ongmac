<?php
class Cart{
	 var $error = '';
	 var $msg = '';
	 public function add($id,$qty='1',$option =null){
	 	global $product;
	 	if($qty <= 0){
		$this->error = 'Quantity of Product must be 1 or more';
		return false;
		 
		}
	 	$verify_product = $product->is_product($id);
	 	if($verify_product){
		$pro_detail =$product->details($id);
		if(SHIPPINGMODE == '2'){
		$pro_detail['shipping'] = '0';
		}
		if($pro_detail['stock'] < 1){
		$this->error = 'Out of stock';
		return false;
			}
	 	if($option != null){
	 		$verify_option = $product->is_option($option);
	 		if($verify_option){
	 			$detail = $product->option_details($option);
	 			if(isset($_SESSION['basket']['items'][$id.'_'.$option])){
						$this->error = 'Item already in Cart';
						return false;
					}
					
	 			$_SESSION['basket']['items'][$id.'_'.$option] = array('id'=>$id,'count'=>$qty,'name'=> $pro_detail['name'],'opt_name'=>  $detail['name'],'price'=>  $detail['price'],'stock'=>$pro_detail['stock'],'img'=>$pro_detail['image'],'opt_id'=>$detail['id'],'shipping'=> $pro_detail['shipping'],'region'=> $pro_detail['region'],'type'=>'option');
				$this->msg = 'Item added to cart successfully';
	 			return true;
				}
			}
	 			if(isset($_SESSION['basket']['items'][$id])){
										$this->error = 'Item already in Cart';
						return false;
				}
	 			$_SESSION['basket']['items'][$id] = array('id'=>$id,'count'=>$qty,'name'=> $pro_detail['name'],'opt_name'=>  null,'price'=>number_format($pro_detail['price'], 2, '.', ''),'stock'=>$pro_detail['stock'],'img'=>$pro_detail['image'],'opt_id'=>null,'shipping'=> $pro_detail['shipping'],'region'=> $pro_detail['region'],'type'=>'product');
	 			$this->msg = 'Item added to cart successfully';
				return true;
	 	}

	 	$this->error = 'Unexpected error';
		return false;
	 }
	 public function update($id,$count){
	  	if(is_numeric($count) && ctype_digit($count)){
	 		if(isset($_SESSION['basket']['items'][$id])){
			if($count > $_SESSION['basket']['items'][$id]['stock']){
			$this->error = 'Stock not available';
			return false;
			}
			if($count == '0'){
			unset($_SESSION['basket']['items'][$id]);
			$this->msg =  'Item removed successfully';
			return true;
			}
	 			$_SESSION['basket']['items'][$id]['count'] = $count;
	 			$this->msg =  'Cart updated successfully';
				return true;
	 		}
	 	}
		$this->error = 'Cart not updated, Try again';
	 	return false;
	 }
	 public function empty_cart(){
	 	unset($_SESSION['basket']);
	 	$this->msg =  'Cart updated successfully';
				return true;
	 	 }
	}
?>