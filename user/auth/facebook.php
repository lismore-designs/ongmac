<?php
require_once('../../symbiotic/cart-load.php');
if(isset($_REQUEST['ref'])){
$_SESSION['after_login'] = $_REQUEST['ref'];
}
if(isset($_SESSION['after_login'])){
$next = $_SESSION['after_login'];
}else{
$next = $setting['website_url'] . '/user/';
}
if(!$auth->is_loggedin()){
 $app_id = $setting['fb_app_id'];
 $app_secret = $setting['fb_app_secret'];
 $my_url = $setting['website_url'] . '/user/auth/facebook.php';
   if(isset($_REQUEST['error'])){
    echo("<script> top.location.href='" . $setting['website_url'] . "/user/sign-up.php?error=Access Denied'</script>");
   }
     $code = @$_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'] . "&scope=email";

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }
    if(isset($_SESSION['state']) && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $_SESSION['access_token'] = $params['access_token'];

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $fb_user = json_decode(file_get_contents($graph_url));
	 $_SESSION['fb_auth'] = $fb_user;
	 $email = $fb_user->email;
	 if($user->is_new_user($email)){
	 $pass = randomPassword();
	 $result= $user->add($email,$pass);
	 }else{
	 $pass = $user->get_pass($email);
	 }
	 if($auth->login($email,$pass)){
	  unset($_SESSION['after_login']);
			echo("<script> top.location.href='" . $next . "'</script>");
	}else{
	echo("Sorry :(.");
	}
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }
   }else{
   unset($_SESSION['after_login']);
   	echo("<script> top.location.href='" . $next . "'</script>");
   }
?>