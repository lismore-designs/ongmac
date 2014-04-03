<?php

require_once('../symbiotic/cart-load.php');
$Merchant_Id = '';
$WorkingKey = '';


$order =$_POST['order_id'];

function getchecksumCC($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey){
    	$str ="$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
    	$adler = 1;
    	$adler = adler32($adler,$str);
    	return $adler;
    }
    
function verifychecksumCC($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey)
    {
    	$str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
    	$adler = 1;
    	$adler = adler32($adler,$str);
    	
    	if($adler == $CheckSum)
    		return "true" ;
    	else
    		return "false" ;
    }
    
function adler32($adler , $str)
    {
    	$BASE =  65521 ;
    
    	$s1 = $adler & 0xffff ;
    	$s2 = ($adler >> 16) & 0xffff;
    	for($i = 0 ; $i < strlen($str) ; $i++)
    	{
    		$s1 = ($s1 + Ord($str[$i])) % $BASE ;
    		$s2 = ($s2 + $s1) % $BASE ;
    			//echo "s1 : $s1 <BR> s2 : $s2 <BR>";
    
    	}
    	return leftshift($s2 , 16) + $s1;
    }
    
function leftshift($str , $num)
    {
    
    	$str = DecBin($str);
    
    	for( $i = 0 ; $i < (64 - strlen($str)) ; $i++)
    		$str = "0".$str ;
    
    	for($i = 0 ; $i < $num ; $i++) 
    	{
    		$str = $str."0";
    		$str = substr($str , 1 ) ;
    		//echo "str : $str <BR>";
    	}
    	return cdec($str) ;
    }
    
function cdec($num)
    {
    $dec=0;
    	for ($n = 0 ; $n < strlen($num) ; $n++)
    	{
    	   $temp = $num[$n] ;
    	   $dec =  $dec + $temp*pow(2 , strlen($num) - $n - 1);
    	}
    
    	return $dec;
    }
    
  if(isset($_REQUEST['symbiotic'])){
    	$total = $_REQUEST['total'];
    $this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $Checksum = getchecksumCC($Merchant_Id,$total,$order,$this_script,$WorkingKey);	
    	?>
    	<html><head><title>Taking you to Gateway...</title></head>
   <body  onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed and you will be redirected to the Payment Gateway.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>
    	<form action="https://www.ccavenue.com/shopzone/cc_details.jsp"  name="payment_form" method="post" id="payment">
	<input type="hidden" name="Merchant_Id" value="<?php echo $Merchant_Id; ?>">
	<input type="hidden" name="Amount" value="<?php echo $total; ?>">
	<input type="hidden" name="Order_Id" value="<?php echo $order; ?>">
	<input type="hidden" name="Redirect_Url" value="<?php echo $this_script; ?>">
	<input type="hidden" name="Checksum" value="<?php echo $Checksum; ?>">
	 
</form></body></html>
   <?php 
    }else{
    	//print_r($_POST);
    if (isset($_REQUEST['Order_Id'])) {
            $order_id= $_REQUEST['Order_Id'];
		} else {
			$order_id = 0;
		}
		if(isset($_SESSION['basket']['order_id'])){
			
        	
            $Merchant_Id= $_REQUEST['Merchant_Id'];
	        $Amount= $_REQUEST['Amount'];
        	
        	$Merchant_Param= $_REQUEST['Merchant_Param'];
        	$Checksum= $_REQUEST['Checksum'];
        	$AuthDesc=$_REQUEST['AuthDesc'];
        		
            $Checksum = verifyChecksumCC($Merchant_Id, $Order_Id , $Amount,$AuthDesc,$Checksum,$WorkingKey);
			
            if($Checksum== true)
        	{
        		switch($AuthDesc){
        			case 'Y':
        				$status = '1';
        				break;
        			case 'N':
        				$status = '3';
        				break;
        			default:
        				$status = '3';
        				break;	
        			
        		}
        		$mychecksum = $_SESSION['basket']['security'];

				$mychecksum2 = $_SESSION['basket']['security2'];
				
				 ?>
      <html>
     <head><title>Processing your Payment...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>
	<form method="post" name="payment_form"  action="<?php echo $setting['website_url'];?>/receipt.php">
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" name="checksum" value="<?php echo $mychecksum; ?>">
	<input type="hidden" name="checksum2" value="<?php echo $mychecksum2; ?>">
	<input type="hidden" name="auth" value="<?php echo $status; ?>">
	</form></body></html>
      
      
      <?php
				
        	}
			
		
			
		}
		
		
    }

?>