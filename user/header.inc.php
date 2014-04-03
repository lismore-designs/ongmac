<?php
require_once('../symbiotic/cart-load.php');
if(!$auth->is_loggedin() && (basename($_SERVER["PHP_SELF"]) != 'sign-in.php') && (basename($_SERVER["PHP_SELF"]) != 'sign-up.php')&& (basename($_SERVER["PHP_SELF"]) != 'recover.php') ){
	header("location:sign-in.php");
	exit;
}
if($auth->is_loggedin()){
define('USER',$_SESSION['curr_user']);
$setting = $settings->get_all();
}
if(basename($_SERVER["PHP_SELF"]) == 'sign-in.php'){

if(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 'signout'){
	$auth->signout();
	}
}
if(isset($_REQUEST['login'])){
		if(empty($_REQUEST['email']) || empty($_REQUEST['pwd'])){
			$error = 'Please enter Email and Password';
		}
		else{
		$email=trim($_REQUEST['email']);
		$password=trim($_REQUEST['pwd']);
	if(!$auth->login($email,$password)){

		$error = $auth->error;
	}
	}
}
if(isset($_REQUEST['reset'])){
		if(empty($_REQUEST['email'])){
			$error = 'Please enter Email';
		}
		else{
		$email=trim($_REQUEST['email']);
		if($user->is_user($email)){
		$pass = $user->get_pass($email);
		mail($email,'Symbiotic Cart Password',$pass);
			$success = 'Done, check your inbox';
		}
		else{
			$error = "User doesn't exists";
		}
	}
}
if($auth->is_loggedin())
{
	header("location:index.php");	
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php echo $title; ?></title><!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references --><link rel="icon" type="image/vnd.microsoft.icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" /><link rel="shortcut icon" type="image/x-icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
<link href="../symbiotic/style.css" rel="stylesheet"  type="text/css">
</head>
<body>
<div class="container">
<div class="row"><div class="col-md-12 page-header">
<img src="../symbiotic/images/logo.png" />
</div>
</div>
<div class="row" >