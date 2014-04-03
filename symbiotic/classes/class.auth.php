<?php
class Auth{
	var $error = '';
	public function is_loggedin(){
		
		if(isset($_SESSION['customerauth']) && isset($_SESSION['curr_user']) && isset($_SESSION['token'])){
		$checksum = md5($_SESSION['curr_user'] . 'symbiotic' . date('ymd'));
			if($checksum == $_SESSION['token']){
			return true;
			}
			return false;
		}
		return false;	
	}
public function login($email,$password){
global $crypt;
$password = base64_encode($password);
	$result = mysql_query("SELECT * FROM  " . PFX . "customers WHERE active = 1 AND email = '$email' AND password = '$password' ");
	while($rows = mysql_fetch_assoc($result)){	
	
	
		$curr_name = '';
		$result_address = mysql_query("SELECT * FROM  " . PFX . "address WHERE customer = ".$rows['id']."");
		while($rows_address = mysql_fetch_assoc($result_address)){
			$curr_name = $rows_address['firstname'].' '.$rows_address['lastname'];
		}
		if($curr_name == '')
		{
			$_SESSION['curr_user_name'] = $rows['email'];
		}
		else
		{
			$_SESSION['curr_user_name'] = $curr_name;
		}
	
		
		$_SESSION['curr_user'] = $rows['email'];
		$_SESSION['uid'] = $crypt->encrypt($rows['id']);
		$_SESSION['token'] = md5($rows['email'] . 'symbiotic' . date('ymd'));
		$_SESSION['customerauth'] = true;
		$this->msg = 'Login Successfull';
		return true;
	}
	$this->error = 'Invalid Username / Password';
	return false;
}
public function signout(){
	unset($_SESSION['curr_user']);
	unset($_SESSION['basket']);
	unset($_SESSION['curr_user_name']);
	//session_start(); // Used Till V1.1
	header("location:index.php");
	exit;
}	
}

?>