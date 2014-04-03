<?php  
require_once('../symbiotic/cart-load.php');
set_time_limit(900);	//-----set maximum script execution time in seconds
$_POST['txtTranID'] = $_REQUEST['order_id'];
$_POST['txtMarketCode'] = $_REQUEST['order_id'];
$_POST['txtAcctNo'] = $_REQUEST['order_id'];
$_POST['txtTxnAmount'] = $_REQUEST['total'];
$_POST['txtBankCode'] = '50';
//---Set Property file Path
$property_path="MerchantDetails.properties";  //Modify this url with the path of your property file.

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


//---Create String using property data 
		$txtBillerIdStr="txtBillerid=".trim($txtBillerId)."&";
		$txtResponseUrl="txtResponseUrl=".trim($txtResponseUrl)."&";
		$txtCRN="txtCRN=".trim($txtCRN)."&";
		$txtCheckSumKey="txtCheckSumKey=".trim($txtCheckSumKey);
				
		$Proper_string=$txtBillerIdStr.$txtResponseUrl.$txtCRN.$txtCheckSumKey;


//Encrypting values
$transaction = $_POST['txtTranID'];
$market = $_POST['txtMarketCode'];
$account = $_POST['txtAcctNo'];
$transaction_amount = $_POST['txtTxnAmount'];
$bankcode = $_POST['txtBankCode'];

$txtVals = trim($transaction) . trim($market) . trim($account) . trim($transaction_amount) . trim($bankcode);
$txt_encrypt = base64_encode($txtVals);
$txt_encrypt = md5(base64_encode($txtVals));


$txtKey = $property_data_array[3];
$txtForEncode = trim($txt_encrypt) . trim($property_data_array[3]);
$txtPostid = md5($txtForEncode);

// Creating string for $Postid.
$txtPostid="txtPostid=".$txtPostid;


//---Read form data 

$pp=array();
foreach( $_POST as $key => $value){
	if(trim($value)=="")
	{
		 ShowError("Invalid Input");
		 die();
	}
	$v="$key=".trim($value);
	array_push($pp,$v);
}

//---create string using form data

$UserDataString=implode("&",$pp);

//print_r($UserDataString);

//print_r($UserDataString);


$PostData=trim($UserDataString).trim("&").trim($Proper_string).trim("&").trim($txtPostid);

//die();


//-----Curl main Function Start


 define('POST', $CheckSumGenUrl);
 define('POSTVARS', $PostData);  // POST VARIABLES TO BE SENT
 
 // INITIALIZE ALL VARS
 

 if($_SERVER['REQUEST_METHOD']==='POST') {  // REQUIRE POST OR DIE
 $ch = curl_init(POST);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
 curl_setopt($ch, CURLOPT_CAINFO, getcwd() . '/keystoretechp.pem'); //Setting certificate path
 curl_setopt ($ch, CURLOPT_SSLCERTPASSWD, 'changeit');
 curl_setopt($ch, CURLOPT_POST      ,1);
 //curl_setopt($ch, CURLOPT_TIMEOUT  ,10); // Not required. Don't use this.
 curl_setopt($ch, CURLOPT_REFERER  ,'http://www.yourdomain.com/t.php'); //Setting header URL: 
 curl_setopt($ch, CURLOPT_POSTFIELDS    ,POSTVARS);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1); 
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1); // RETURN THE CONTENTS OF THE CALL
 
$Received_CheckSum_Data = curl_exec($ch);
curl_close($ch);

//echo "<br>CheckSum=".$Received_CheckSum_Data;

//if(!is_numeric($Received_CheckSum_Data)){ // Validating whether the Receieved value is numeric.

//	echo "<br>" .  $Received_CheckSum_Data;
//	exit;

//}

//re-defining the variables without & and variables.

$txtBillerIdStr=$txtBillerId;
$txtResponseUrl=$property_data_array[1];
$txtCRN=$property_data_array[2];
$txtCheckSumKey=$property_data_array[5];

if(strlen(trim($Received_CheckSum_Data))>0)
	 {
	//################# read post data to variable ###############

		$txtTranID=$_POST['txtTranID'];
		$txtMarketCode=$_POST['txtMarketCode'];
		$txtAcctNo=$_POST['txtAcctNo'];
		$txtTxnAmount=$_POST['txtTxnAmount'];
		$txtBankCode=$_POST['txtBankCode'];

		//################# read post data end ###############



	//###########  Create msg String ###########################
	  $ParamString=trim($txtBillerId)."|".trim($txtTranID)."|NA|NA|".trim($txtTxnAmount)."|".trim($txtBankCode)."|NA|NA|".trim($txtCRN)."|NA|NA|NA|NA|NA|NA|NA|".trim($txtMarketCode)."|".trim($txtAcctNo)."|NA|NA|NA|NA|NA|".trim($txtResponseUrl);

	 $finalUrlParam=$ParamString."|".$Received_CheckSum_Data;

	 

	 //----Create dyanamic form and submit to payment gatway

	echo " <html><head><title>Taking you to Gateway...</title></head>
   <body  onLoad=\"document.forms['payment_form'].submit();\">
     <center><h2>Please wait, your order is being processed and you will be redirected to the Payment Gateway.</h2></center>
	   <center><img src=\"../symbiotic/images/gateway.gif\"></center>
		  <form id='subFrm' name='payment_form' method='post' action='".$TPSLUrl."'>
			  <input type='hidden' name='msg' value='".$finalUrlParam."'>
			  </form>
		  <script>
		document.subFrm.submit();
		 </script>
		 </body></html>
	  ";	
	  }
	  else
	  {
        ShowError("Failed to retrieve Key!! Try Again !!");
		 die();
	 }
 
} else die('<br><br>###################  Hacking attempt Logged!');
 
function readPropertyFileData($s11) {
		//echo $s11;
		$process_file_array=array();
		$fp = @fopen($s11, 'r');
		if ($fp) {
			$array = explode("\n", fread($fp, filesize($s11)));
		}
		$array_count=count($array);
		//echo "<pre>";
		//print_r($array);
		//exit;
		for($i=0;$i<$array_count;$i++) {
			$array_str=explode("=",$array[$i]);
			//echo $array_str[1];
			//exit;
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