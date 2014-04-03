<?php
header('Cache-control: max-age='.(60*60*24*365));
header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
require_once('cart-load.php');
if(isset($_REQUEST['product_id'])){
	if(!empty($_REQUEST['product_id'])){
		$id = $_REQUEST['product_id'];
		$details = $product->details($id);
		if($details){
		switch($_REQUEST['type']){
		
		case 'btn':
			if($details['stock'] < 1){
			echo "<span class=\"btn btn-danger\">Out of stock</span>";
			exit;
			}
			$html= "<form  action=\"".BASE."/cart.php\" class=\"symbiotic-form form-inline\" method=\"post\">
			<input name=\"product_id\" type=\"hidden\" value=\"" . $id . "\">
			<input name=\"action\" type=\"hidden\" value=\"add\">
			<input name=\"ajax\" type=\"hidden\" value=\"true\">";
		
		$price = $details['price'];
		$name = $details['name'];
		

			//echo  $setting['currency_symbol']  .  $price;

		if($_REQUEST['options'] == 'show' ){
			$options = $product->options($id);
			//print_r($options);
			$html .= "<select class=\"form-control\" name=\"option\">";
			foreach($options as $option){
			$html .= $option['id'];
				$disprice = $option['price'];
				$html .= "<option value=\"" . $option['id'] ."\">" . $option['name'] . "&nbsp;&nbsp;" .$setting['currency_symbol']."&nbsp;". $disprice . "</option>";
			}
			$html .="</select> ";
		} // End Options
		else{
		if($_REQUEST['name'] == 'show' ){
			$options = $product->options($id);
			//print_r($options);
			$html .= "<strong>" . $name . "</strong> ";
			
		}
		if($_REQUEST['price'] == 'show'){
			
		
			$html .= "<strong>Price: " . $setting['currency_symbol']. "&nbsp;" . $price .  "</strong> ";
		}
		}
		//End  Price
		if($_REQUEST['qty'] == 'show' ){
			$html .= "<input name=\"qty\" class=\"form-control sym-count\"  type=\"text\" value=\"1\"> ";
			
		}else{
		$html .= "<input name=\"qty\" type=\"hidden\" value=\"1\">";
		}
		if($_REQUEST['button_text'] != 'undefined'){
			$html .= " <button class='btn btn-primary' type=\"submit\" >" . $_REQUEST['button_text'] . "</button>";
			
		}
		else{
			$html .= " <button class='btn btn-primary' type=\"submit\" >Buy Now</button>";
		}
		
		$html .= "</form>";
		echo $html;

		exit;
		
		case 'img':
		if(isset($_REQUEST['size'])){
		switch($_REQUEST['size']){
		
		case 'small':
		$prefix= "small-";
		break;
		case 'medium':
		$prefix= "medium-";
		break;
		case 'large':
		$prefix= "large-";
		break;
		default:
		$prefix= "";
		}
		}else{
		$prefix= "";
		}
		$style ="style=\"";
		if(isset($_REQUEST['w']) && $_REQUEST['w'] != 'undefined' && isset($_REQUEST['size'])){
		$style .= " width:".$_REQUEST['w']."px;";
		}
		if(isset($_REQUEST['h']) && $_REQUEST['h'] != 'undefined' && isset($_REQUEST['size'])){
		$style .= " height:".$_REQUEST['h']."px;";
		}
		$style .="\"";
		
		echo "<img src=\"".$setting['website_url']."/symbiotic/images/products/".$prefix.$details['image']."\" title=\"\" ".$style." />";
		exit;
		case 'desc':
		echo nl2br($details['description']);
		exit;
		default:
		echo 'Invalid request<br />';
		exit;
	}
	}
	}
	}
	echo 'Invalid Product';

?>