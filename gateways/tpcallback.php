<?php
//Initializing session
require_once('../symbiotic/cart-load.php');

//Storing $_REQUEST['msg'] in session.
$_SESSION['msg'] = $_REQUEST['msg'];

if($_REQUEST['msg'] != '') {
	
	$msg=trim($_REQUEST['msg']);
	$msg_array=explode("|",$msg);

//---Set Property file Path
$property_path="MerchantDetails.properties"; //Modify this url with the path of your property file.
	
//---Read Property file
		$property_data_array=readPropertyFileData($property_path);

		if(count($property_data_array)<5)
		{
			ShowError("Invald Proerty File");
			die();
		}

		$txtBillerId=$property_data_array[0];
		$txtResponseUrl=$property_data_array[1];
		$txtCRN=$property_data_array[2];
		$txtCheckSumKey=$property_data_array[3];
		$CheckSumGenUrl=trim($property_data_array[4]);
		$TPSLUrl=$property_data_array[5];


		$txtResponseKey = $msg_array[0] ."|".$msg_array[1] ."|".$msg_array[2] ."|".$msg_array[3] ."|".$msg_array[4] ."|".$msg_array[5] ."|".$msg_array[6] ."|".$msg_array[7] ."|".$msg_array[8] ."|".$msg_array[9] ."|".$msg_array[10] ."|".$msg_array[11] ."|".$msg_array[12] ."|".$msg_array[13] ."|".$msg_array[14] ."|".$msg_array[15] ."|".$msg_array[16] ."|".$msg_array[17] ."|".$msg_array[18] ."|".$msg_array[19] ."|".$msg_array[20] ."|".$msg_array[21] ."|".$msg_array[22] ."|".$msg_array[23] ."|".$msg_array[24] ."|".$txtCheckSumKey;	


//Contatinating values.
$txtResponseKey = "txtResponseKey=" . $txtResponseKey;


//-----Curl main Function Start

 define('POST', $CheckSumGenUrl);
 define('POSTVARS', $txtResponseKey);  // POST VARIABLES TO BE SENT
 
// INITIALIZE ALL VARS
 

 if($_SERVER['REQUEST_METHOD']==='POST') {  // REQUIRE POST OR DIE
 $ch = curl_init(POST);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
 curl_setopt($ch, CURLOPT_CAINFO, getcwd() . '/keystoretechp.pem'); //Setting certificate path
 curl_setopt ($ch, CURLOPT_SSLCERTPASSWD, 'changeit');
 curl_setopt($ch, CURLOPT_POST      ,1);
 //curl_setopt($ch, CURLOPT_TIMEOUT  ,10); // Not required. Don't use this.
 curl_setopt($ch, CURLOPT_REFERER  ,'http://www.yourdomain.com/tpcallback.php'); //Setting header URL
 curl_setopt($ch, CURLOPT_POSTFIELDS    ,POSTVARS);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1); // RETURN THE CONTENTS OF THE CALL
 
$Received_CheckSum_Data = curl_exec($ch);
curl_close($ch);

$session_val = $_SESSION['msg'];
$return_array = explode("|",$session_val);


	 //Validate Checksum
	
		if(trim($Received_CheckSum_Data) == trim($return_array[25])){

			
			if(trim($return_array[14])=='0300')
			{

				$payment = '1';

			}
			else
			{
				 
				$payment = '3';
			}
			$checksum = $_SESSION['basket']['security'];

			$checksum2 = $_SESSION['basket']['security2'];
?>
 <html>
     <head><title>Processing your Payment...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed.</h2></center>
	   <center><img src="../symbiotic/images/gateway.gif"></center>
	<form method="post" name="payment_form"  action="<?php echo $setting['website_url'];?>/receipt.php">
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" name="checksum" value="<?php echo $checksum; ?>">
	<input type="hidden" name="checksum2" value="<?php echo $checksum2; ?>">
	<input type="hidden" name="auth" value="<?php echo $payment; ?>">
	</form></body></html>


<?php
		}else{
			
			echo "Checksum verification failed. Fake transaction detected!";
			
		}

	 } else {
	echo "<PRE> Invalid Response !";
	}
}
function readPropertyFileData($s11) {
		
		$process_file_array=array();
		$fp = @fopen($s11, 'r');
		if ($fp) {
			$array = explode("\n", fread($fp, filesize($s11)));
		}
		$array_count=count($array);
		
		for($i=0;$i<$array_count;$i++) {
			$array_str=explode("=",$array[$i]);
			$process_file_array[]=$array_str[1];
		}
		return $process_file_array;
		
	}

function ShowError($error)
{
	?>
	 <head><title>Error</title></head>
	 <body>
	 <div style='margin-top:200px; text-align:center; font-family:sans-serif; font-size:12px;'><img src='/symbiotic/images/tp.png' /><br><br><strong>Error:</strong>  <?php echo $error; ?></div></body>
	 <?php
}

?>