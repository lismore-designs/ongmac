<?php
require_once('../symbiotic/cart-load.php');
$paypal_email = 'sales@ongmacmotorcycles.com.au'; // Set Your Paypal Email HERE

if(isset($_REQUEST['symbiotic'])){
$order_id= $_REQUEST['order_id'];
$amount = $_REQUEST['total'];
$curr = $_REQUEST['curr'];
}
class paypal_class {
    
   var $last_error;                 
   
   var $ipn_log;                    
   
   var $ipn_log_file;               
   var $ipn_response;               
   var $ipn_data = array();         
   
   var $fields = array();           

   
   function paypal_class() {
       
     
      $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
      
      $this->last_error = '';
      
      $this->ipn_log_file = '.ipn_results.log';
      $this->ipn_log = true; 
      $this->ipn_response = '';
      
    

      $this->add_field('rm','2');           
      $this->add_field('cmd','_xclick'); 
      
   }
   
   function add_field($field, $value) {
      
   $this->fields["$field"] = $value;
   }

   function submit_paypal_post() {
 
     

      echo "<html>\n";
      echo "<head><title>Processing Order...</title></head>\n";
      echo "<body onLoad=\"document.forms['paypal_form'].submit();\">\n";
      echo "<center><h2>Please wait, your order is being processed and you";
      echo " will be redirected to the paypal website.</h2></center>\n";
	  echo " <center><img src=\"../symbiotic/images/gateway.gif\"></center>\n";
      echo "<form method=\"post\" name=\"paypal_form\" ";
      echo "action=\"".$this->paypal_url."\">\n";

      foreach ($this->fields as $name => $value) {
         echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
      }
      echo "<center><br/><br/>If you are not automatically redirected to ";
      echo "paypal within 5 seconds...<br/><br/>\n";
      echo "<input type=\"submit\" value=\"Click Here\"></center>\n";
      
      echo "</form>\n";
      echo "</body></html>\n";
    
   }
   
   function validate_ipn() {

      
      $url_parsed=parse_url($this->paypal_url);        

     
      $post_string = '';    
      foreach ($_POST as $field=>$value) { 
         $this->ipn_data["$field"] = $value;
         $post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command

      // open the connection to paypal
      $fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30); 
      if(!$fp) {
          
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
         $this->last_error = "fsockopen error no. $errnum: $errstr";
         $this->log_ipn_results(false);       
         return false;
         
      } else { 
 
         // Post the data back to paypal
         fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
         fputs($fp, "Host: $url_parsed[host]\r\n"); 
         fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
         fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
         fputs($fp, "Connection: close\r\n\r\n"); 
         fputs($fp, $post_string . "\r\n\r\n"); 

         // loop through the response from the server and append to variable
         while(!feof($fp)) { 
            $this->ipn_response .= fgets($fp, 1024); 
         } 

         fclose($fp); // close connection

      }
      
      if (eregi("VERIFIED",$this->ipn_response)) {
  
         // Valid IPN transaction.
         $this->log_ipn_results(true);
         return true;       
         
      } else {
  
         // Invalid IPN transaction.  Check the log for details.
         $this->last_error = 'IPN Validation Failed.';
         $this->log_ipn_results(false);   
         return false;
         
      }
      
   }
   
   function log_ipn_results($success) {
       
      if (!$this->ipn_log) return;  // is logging turned off?
      
      // Timestamp
      $text = '['.date('m/d/Y g:i A').'] - '; 
      
      // Success or failure being logged?
      if ($success) $text .= "SUCCESS!\n";
      else $text .= 'FAIL: '.$this->last_error."\n";
      
      // Log the POST variables
      $text .= "IPN POST Vars from Paypal:\n";
      foreach ($this->ipn_data as $key=>$value) {
         $text .= "$key=$value, ";
      }
 
      // Log the response from the paypal server
      $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
      
      // Write to log
      $fp=fopen($this->ipn_log_file,'a');
      fwrite($fp, $text . "\n\n"); 

      fclose($fp);  // close file
   }

   function dump_fields() {
 
      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.
      
      echo "<h3>paypal_class->dump_fields() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>"; 
      
      ksort($this->fields);
      foreach ($this->fields as $key => $value) {
         echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
      }
 
      echo "</table><br>"; 
   }
}         

$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url

$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      
      
      $p->add_field('business', $paypal_email);
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
     // $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'Order No ' . $order_id . ' in shoping cart');
      $p->add_field('amount', $amount);

      $p->submit_paypal_post(); // submit the fields to paypal
     
      break;
      
   case 'success':      // Order was successful...
   
   
 
if(isset($_SESSION['basket']['order_id'])){
$order_id = $_SESSION['basket']['order_id'];
}else{
$order_id = 0;
$_SESSION['basket']['order_id'] = $order_id;
}


$checksum = $_SESSION['basket']['security'];

$checksum2 = $_SESSION['basket']['security2'];

switch ($_POST['payment_status']){
	case 'Completed':
	$payment = '1';
	break;
	case 'Pending':
	$payment = '2';
	break;
	case 'Failed':
	$payment = '3';
	break;
	default:
	$payment = '3';	
}
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
      
      break;
      
   case 'cancel':       // Order was canceled...

      if(isset($_SESSION['basket']['order_id'])){
$order_id = $_SESSION['basket']['order_id'];
}else{
$order_id = 0;
$_SESSION['basket']['order_id'] = $order_id;
}


$checksum = $_SESSION['basket']['security'];

$checksum2 = $_SESSION['basket']['security2'];
      ?>
      <html>
     <head><title>Processing your Payment...</title></head>
   <body onLoad="document.forms['payment_form'].submit();">
     <center><h2>Please wait, your order is being processed.</h2></center>
	   <center><img src="/symbiotic/images/gateway.gif"></center>
	<form method="post" name="payment_form"  action="<?php echo $setting['website_url'];?>/receipt.php">
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" name="checksum" value="<?php echo $checksum; ?>">
	<input type="hidden" name="checksum2" value="<?php echo $checksum2; ?>">
	<input type="hidden" name="auth" value="3">
	</form></body></html>
      
      
      <?php
      break;
      
 }     
//  Convert
/*
 function currency($from_Currency,$to_Currency,$amount) {
$amount = urlencode($amount);
$from_Currency = urlencode($from_Currency);
$to_Currency = urlencode($to_Currency);
$url = "http://www.google.com/ig/calculator?hl=en&q=$amount$from_Currency=?$to_Currency";
$ch = curl_init();
$timeout = 0;
 curl_setopt ($ch, CURLOPT_URL, $url);
 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$rawdata = curl_exec($ch);
 curl_close($ch);
$data = explode('"', $rawdata);
$data = explode(' ', $data['3']);
$var = $data['0'];
return $var; //number_format($var, 2, '.', '');
}*/
?>