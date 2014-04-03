<?php
$title='Create New Account';
require_once('../symbiotic/cart-load.php');
$publickey = $setting['rc_public'];
$privatekey = $setting['rc_private'];
$resp = null;
$error = null;
if(isset($_REQUEST['error'])){
$user->error = $_REQUEST['error'];
}
if(!empty($publickey) && !empty($privatekey)){ 
require_once('../symbiotic/plugins/recaptchalib.php');

if (isset($_POST["recaptcha_response_field"])) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
            
			if($_POST && isset($_REQUEST['submit'])){
$email = $_POST['email'];
$npwd = $_POST['password'];
$npwd2 = $_POST['password2'];

if(!$validate->email($email)){
$user->error  = 'Please enter a valid email ID.';

}else{

if($user->is_new_user($email)){
if($npwd == $npwd2){
$result= $user->add($email,$npwd);
if($result == true){
				$result= $auth->login($email,$npwd);
				echo("<script> top.location.href='index.php'</script>");
				}
}else{
$user->error  = 'New Passwords does not match.';
}
}else{

$user->error  = 'User already exists.';

}
}




}
			
        } else {
               
                $error = $resp->error;
                $user->error = $resp->error;
        }
}

}else{
// reCaptcha Disabled
	if($_POST && isset($_REQUEST['submit'])){
$email = $_POST['email'];
$npwd = $_POST['password'];
$npwd2 = $_POST['password2'];

if(!$validate->email($email)){
$user->error  = 'Please enter a valid email ID.';

}else{

if($user->is_new_user($email)){
if($npwd == $npwd2){
$result= $user->add($email,$npwd);
if($result == true){
				$result= $auth->login($email,$npwd);
				echo("<script> top.location.href='index.php'</script>");
				}
}else{
$user->error  = 'New Passwords does not match.';
}
}else{

$user->error  = 'User already exists.';

}
}




}


}

require_once('header.inc.php');
?><div class="col-md-8">

<?php  if(!empty($publickey) && !empty($privatekey)){  ?>
<script type="text/javascript">
var RecaptchaOptions = {
theme: 'custom',
lang: 'en',
custom_theme_widget: 'recaptcha_widget'
};
 </script>
<?php } ?>
 <h1>Sign up new account</h1><br />

<h2>One account, many features</h2>
<h4>Shop from our site</h4>
<h4>Manage orders</h4>
<h4>Track your orders</h4>
<h4>Manage addresses</h4>
<?php if(!empty($setting['fb_app_secret']) && !empty($setting['fb_app_secret'])){ ?>
<br /><h2>Don't want to fill form?</h2>
<a class="btn btn-primary  btn-large" href='auth/facebook.php?ref=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>'>Sign up with Facebook</a><br />

<?php } ?>

<br /><h2>Already have an account?</h2>
 <a class="btn btn-success btn-large" href="sign-in.php">Sign in here</a>
 
 
</div>
<div class="col-md-4 login-box">

Already have accoount? <a href="sign-in.php" class="btn btn-danger">Sign in here</a>

<h3 class="text-center">Sign up</h3>
<form action="sign-up.php" method="post" id="new-user">

<?php 

if($user->msg){
				echo  "<div class=\"alert alert-success\" style=\"display:block;\">".$user->msg."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
if($user->error){
				echo  "<div class=\"alert alert-danger\" style=\"display:block;\">".$user->error."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}?>
				 <div class="form-group">
    <label  for="new-email">Email</label>
    <div >

<input class="form-control"   class="input-block-level" type="email" required name="email" value="" id="new-email">
</div></div>


 <div class="form-group">
    <label  for="new-pwd">Password</label>
    <div >
<input class="form-control"   class="input-block-level" type="password"  required name="password" value="" id="new-pwd"></div></div>

 <div class="form-group">
    <label  for="new-pwd2">Confirm password</label>
    <div >
<input class="form-control"   class="input-block-level" type="password"  required name="password2" value="" id="new-pwd2"></div></div>  
<?php  if(!empty($publickey) && !empty($privatekey)){  ?>
<div class="form-group">
    <label  for="recaptcha_response_field">Are you a human?</label>
    <div id="recaptcha_widget" style="display: none;">
<div id="recaptcha_image"></div>
<div class="recaptcha_only_if_incorrect_sol" style="color: red;">Incorrect please try again</div>
<span class="recaptcha_only_if_image">Enter the words above:</span>
<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
 <div ><input class="form-control" id="recaptcha_response_field" name="recaptcha_response_field" type="text" class="input-block-level" required></div>
<a href="javascript:Recaptcha.reload();"  class="btn btn-link"><i class="icon-refresh"></i> Get another CAPTCHA</a> 
<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"  class="btn btn-link"><i class="icon-bullhorn"></i> Get an audio CAPTCHA</a></div>
<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"  class="btn btn-link" ><i class="icon-picture"></i> Get an image CAPTCHA</a></div>

<!--div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div><br /> 
<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div><br /><br /> 
<div><a href="javascript:Recaptcha.showhelp()">Help</a><br />
</div-->

<script type="text/javascript" src="http://api.recaptcha.net/challenge?k=<?php echo $publickey;?>&lang=en"></script>

<noscript>
<iframe src="http://api.recaptcha.net/noscript?k=<?php echo $publickey;?>&lang=en" height="200" width="500" frameborder="0"></iframe>
<textarea  class="form-control" name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
<input class="form-control" type="'hidden'" name="'recaptcha_response_field'" value="'manual_challenge'">
</noscript>

</div>


</div> <?php }?>
<div class="form-group">
    
    <div >

Click Sign up if you accept terms and condition.
</div>
</div>
 <div class="form-group">
     <div >
<button type="submit" name="submit" class="btn btn-primary" >Sign up</button>
</div>
	</div></form>	
</div>

<?php
require_once('footer.inc.php');
?>