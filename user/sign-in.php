<?php
$title='User Sign in';
require_once('../symbiotic/cart-load.php');
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "recover")){

		if(isset($_REQUEST['email']) && empty($_REQUEST['email'])){
			$reseterror= 'Please enter email';
		}
		elseif(isset($_REQUEST['email'])){
		$email=trim($_REQUEST['email']);
		if(!$user->is_new_user($email)){
		$pass = $user->get_pass($email);
		
			$headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=utf-8\n";
    $headers .= "From:Symbiotic Cart <no-reply@".$_SERVER['HTTP_HOST']."> \n";
	$subject = "Account Sign in Information";
	$message = "<h2>Hello, ".$email ."</h2><br />";
	$message .= "You requested password at ".$_SERVER['HTTP_HOST']." with this email id. <br />";
	$message .= "Your password is <b>".$pass."</b> .<br />";
	$message .= "&copy; ".$_SERVER['HTTP_HOST'];
	mail($email,$subject,$message,$headers);

			$success = 'Done, check your inbox';
			}else{
			$reseterror= 'User does not exists';
			}
	}
}



require_once('header.inc.php');
?>
<div class="col-md-8">
<h1>Login to your account</h1><br />

<h2>One account, many features</h2>
<h4>Shop from our site</h4>
<h4>Manage orders</h4>
<h4>Track your orders</h4>
<h4>Manage addresses</h4>
<br /><h2>Don't have an account yet?</h2>
 <a class="btn btn-success" href="sign-up.php">Sign up</a>
</div>
<div class="col-md-4 login-box">

<?php
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "recover")){
?>

<h3 class="text-center">Reset Password</h3>
<form action="sign-in.php" method="post" class="form">
<?php if(isset($reseterror)){
		echo  "<div class=\"alert alert-danger\" style=\"display:block;\">".$reseterror."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
		 }elseif(isset($success)){
		echo  "<div class=\"alert alert-success\" style=\"display:block;\">".$success."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
		 }
		 ?>
		 	 <div class="form-group">
    <label for="email">Email</label>
    <div >
<input class="form-control" type="email" required name="email" value="" id="email">
<input class="form-control" type="hidden" name="action" value="recover">

</div></div>
<div class="form-group">
    <div>
<button type="submit" name="submit" class="btn btn-primary" ><i class="icon-white icon-envelope"></i> Send password</button>
</div>
</div>
</form>

Rememer password? <a href="sign-in.php" class="btn btn-default">Sign in here</a>

<?php
}
else{
?>

<h3 class="text-center">Sign in</h3>
<?php
if(isset($error)){
				echo  "<div class=\"alert alert-danger\" style=\"display:block;\">".$error."<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
				}
	?>			
<form class="form" action="sign-in.php" method="post" >

  <div class="form-group">
    <label  for="inputEmail">Email</label>
    <div>
      <input class="form-control"  class="input-block-level"  required type="email" required id="inputEmail" placeholder="Email" name="email">
    </div>
  </div>
  <div class="form-group">
    <labelfor="inputPassword" >Password</label>
    <div>
      <input class="form-control"  class="input-block-level"  required type="password" id="inputPassword" name="pwd" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div>
      <input class="form-control" type="hidden" name="login">
      <button type="submit" class="btn btn-primary">Sign in</button> <?php if(!empty($setting['fb_app_secret']) && !empty($setting['fb_app_secret'])){ ?><a href='auth/facebook.php?ref=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>' class="btn btn-default">Sign in with Facebook</a><?php } ?>
    </div>
  </div>  
  <div class="form-group">
    <div>
         <a class="btn btn-link" href="sign-up.php">Sign up</a> <a class="btn btn-link" href="sign-in.php?action=recover">Forgot Password</a>
    </div>
  </div>
</form>



<?php
}
?>
</div>
<?php
require_once('footer.inc.php');
?>