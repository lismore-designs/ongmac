<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Settings'; 
require_once('./include/admin-load.php');
require_once('../gateways.php');
if($user->is_admin(USER)){
$active = 'web';
if(isset($_REQUEST['save'])){
if($_REQUEST['save'] == 'web'){
	$newsettings = array();
	$newsettings['website_url'] = $_REQUEST['website_url'];
	$newsettings['web_email'] = $_REQUEST['web_email'];
	$newsettings['invoice_email'] = $_REQUEST['invoice_email'];
	$newsettings['mode'] = $_REQUEST['mode'];
	
	
	$result =$settings->update($newsettings);
	$active = 'web';
}
elseif($_REQUEST['save'] == 'payment'){
	$newsettings = array();
	$newsettings['tax'] = $_REQUEST['tax'];
	$newsettings['currency'] = $_REQUEST['currency'];
	$newsettings['currency_symbol'] = $_REQUEST['currency_symbol'];
//	$newsettings['currency_symbol_position'] = $_REQUEST['currency_symbol_position'];
	$result =$settings->update($newsettings);
$active = 'payment';
}		
elseif($_REQUEST['save'] == 'security'){
	$newsettings = array();
	$newsettings['secret'] = $_REQUEST['secret'];
	$result =$settings->update($newsettings);
$active = 'security';
}	
elseif($_REQUEST['save'] == 'social'){
	$newsettings = array();
	$newsettings['fb_app_id'] = $_REQUEST['fb_app_id'];
	$newsettings['fb_app_secret'] = $_REQUEST['fb_app_secret'];
	//$newsettings['t_app_key'] = $_REQUEST['t_app_key'];
	//$newsettings['t_app_secret'] = $_REQUEST['t_app_secret'];
	$result =$settings->update($newsettings);
$active = 'social';
}	
elseif($_REQUEST['save'] == 'captcha'){
	$newsettings = array();
	$newsettings['rc_public'] = $_REQUEST['rc_public'];
	$newsettings['rc_private'] = $_REQUEST['rc_private'];
	//$newsettings['t_app_key'] = $_REQUEST['t_app_key'];
	//$newsettings['t_app_secret'] = $_REQUEST['t_app_secret'];
	$result =$settings->update($newsettings);
$active = 'captcha';
}	
elseif($_REQUEST['save'] == 'discount'){
	$newsettings = array();
	$newsettings['fb_url'] = $_REQUEST['fb_url'];
	$newsettings['fb_dis'] = is_numeric($_REQUEST['fb_dis']) ? $_REQUEST['fb_dis'] : 0 ;
	$newsettings['g_url'] = $_REQUEST['g_url'];
	$newsettings['g_dis'] = is_numeric($_REQUEST['g_dis']) ? $_REQUEST['g_dis']: 0;
	$result =$settings->update($newsettings);
$active = 'viral';
}
}
if(isset($_REQUEST['get_exchange']) && isset($_REQUEST['exchange_from']) && isset($_REQUEST['exchange_to'])){
	echo currency($_REQUEST['exchange_from'],$_REQUEST['exchange_to'],'1');

	exit;
}	
}
$setting = $settings->get_all();
if(!empty($settings->msg)){
	$success = $settings->msg;
	}
	if(!empty($settings->error)){
	$error = $settings->error;
	}
	
require_once('./header.php');

if($user->is_admin(USER)){
	 ?>
	 
<ul class="nav nav-tabs">
  <li <?php if($active=='web'){echo "class='active'";}?>><a href="#web" data-toggle="tab">Website Settings</a></li>
  <li <?php if($active=='viral'){echo "class='active'";}?>><a href="#viral" data-toggle="tab">Viral Coupons</a></li>
  <li <?php if($active=='payment'){echo "class='active'";}?>><a href="#payment" data-toggle="tab">Payments</a></li>
  <li <?php if($active=='social'){echo "class='active'";}?>><a href="#social" data-toggle="tab">Social Login</a></li>
  <li <?php if($active=='captcha'){echo "class='active'";}?>><a href="#captcha" data-toggle="tab">reCaptcha</a></li>
  <li><a href="shipping.php">Shipping</a></li>
  <li <?php if($active=='security'){echo "class='active'";}?>><a href="#security" data-toggle="tab">Security</a></li>
</ul>
	<div class="tab-content">
  <div class="tab-pane <?php if($active=='web'){echo 'active';}?>" id="web"> 
  <h3>Website Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="web-settings">
<input class="form-control"type="hidden" name="save" value="web">
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Website URL</label><div class="col-md-4">
<input class="form-control"type="text" name="website_url" value="<?php echo $setting['website_url'] ; ?>" id="website-url"><span class="form-tip">&nbsp;Dont add slash "/" at end of URL</span></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Your Email</label><div class="col-md-4">
<input class="form-control"type="text" name="web_email" value="<?php echo $setting['web_email'] ; ?>" id="web-email"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Invoice Email</label><div class="col-md-4">
<input class="form-control"type="text" name="invoice_email" value="<?php echo $setting['invoice_email'] ; ?>" id="invoice-email"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Mode</label><div class="col-md-4">
<select class="form-control" name="mode">
<option value="0" <?php if($setting['mode'] == '0'){echo "selected";}?>>Test</option>
<option value="1" <?php if($setting['mode'] == '1'){echo "selected";}?>>Live</option>
</select>

</div></div>

<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div>
</div>


</form></div>
  <div class="tab-pane <?php if($active=='viral'){echo 'active';}?>" id="viral"> 
  <h3>Viral Coupons Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="discount-settings">
<input class="form-control"type="hidden" name="save" value="discount">
<div class="form-group">

<label class="col-md-3 control-label text-right" for="">Google Plus</label><div class="col-md-4">
<input class="form-control"type="text" name="g_url" value="<?php echo $setting['g_url'] ; ?>" id="g-url"></div></div>

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Google Plus % Discount</label><div class="col-md-4">
<input class="form-control"type="text" name="g_dis" value="<?php echo $setting['g_dis'] ; ?>" id="g-dis"></div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Facebook</label><div class="col-md-4">
<input class="form-control"type="text" name="fb_url" value="<?php echo $setting['fb_url'] ; ?>" id="fb-url"></div></div>

<div class="form-group">

<label class="col-md-3 control-label text-right" for="">Facebook % Discount</label><div class="col-md-4">
<input class="form-control"type="text" name="fb_dis" value="<?php echo $setting['fb_dis'] ; ?>" id="fb-dis"></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>


</form></div>
  <div class="tab-pane <?php if($active=='payment'){echo 'active';}?>" id="payment"> <h3>Payment &amp; Gateway Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="payment-settings">
<input class="form-control"type="hidden" name="save" value="payment">

<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Tax</label><div class="col-md-4">
<input class="form-control"type="text" name="tax" value="<?php echo $setting['tax'] ; ?>" id="tax"> enter 0 for no tax</div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Currency</label><div class="col-md-4">
<input class="form-control"type="text" name="currency" value="<?php echo $setting['currency'] ; ?>" id="admin-curr"> </div></div>
<div class="form-group">
<label class="col-md-3 control-label text-right" for="">Currency Symbol</label><div class="col-md-4">
<input class="form-control"type="text" name="currency_symbol" value="<?php echo $setting['currency_symbol'] ; ?>" id="admin-sym"> </div></div>
<!--
<div class="form-group"><label class="col-md-3 control-label text-right" for="">Currency Symbol Position</label><div class="col-md-4">
<select class="form-control" name="currency_symbol_position" id="admin-sym-pos">
<option value="0" <?php if($setting['currency_symbol_position'] == 0){echo "selected";}?>>Before Amount</option>
<option value="1" <?php if($setting['currency_symbol_position'] == 1){echo "selected";}?>>After Amount</option>

</select>
</div></div> !-->

<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>


</form>
<h3>Payment Gateways</h3>
<p>To manage payment gateways edit <code><?php echo dirname(dirname(__FILE__)); ?>/gateways.php</code>.</p>
<table class="table table-bordered table-striped table-hover">
<?php
foreach($gateways as $gateway){ ?>
<tr><td>To configure <b><?php echo $gateway['name'];	?></b> edit "<?php echo dirname(dirname(dirname(__FILE__))) ."/gateways/". $gateway['file'];	?>"</td></tr>
<?php }
?>
</table>
</div>
  <div class="tab-pane <?php if($active=='social'){echo 'active';}?>" id="social"> 
  <h3>Social Login Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="social-settings">
<input class="form-control"type="hidden" name="save" value="social">


<div class="form-group"><label class="col-md-3 control-label text-right" for=""></label><div class="col-md-4">
<a href='https://developers.facebook.com/apps/' target='_blank'>Create New Facebook App</a></div></div>
<div class="form-group"><label class="col-md-3 control-label text-right" for="">Facebook App ID</label><div class="col-md-4">
<input class="form-control"type="text" name="fb_app_id" value="<?php echo $setting['fb_app_id'] ; ?>" id="appId"></div></div><div class="form-group">
<label class="col-md-3 control-label text-right" for="">Facebook App Secret</label><div class="col-md-4">
<input class="form-control"type="text" name="fb_app_secret" value="<?php echo $setting['fb_app_secret'] ; ?>" id="secret"></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>


</form></div>
  <div class="tab-pane <?php if($active=='captcha'){echo 'active';}?>" id="captcha"> 
  <h3>reCaptcha Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="captcha-settings">
<input class="form-control"type="hidden" name="save" value="captcha">


<div class="form-group"><label class="col-md-3 control-label text-right" for=""></label><div class="col-md-4">
<a href='http://www.google.com/recaptcha' target='_blank'>Create API keys</a></div></div>
<div class="form-group"><label class="col-md-3 control-label text-right" for="">Public Key</label><div class="col-md-4">
<input class="form-control"type="text" name="rc_public" value="<?php echo $setting['rc_public'] ; ?>"> </div></div><div class="form-group">
<label class="col-md-3 control-label text-right" for="">Private Key</label><div class="col-md-4">
<input class="form-control"type="text" name="rc_private" value="<?php echo $setting['rc_private'] ; ?>" ></div></div>
<div class="form-group"><div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>


</form></div>
  <div class="tab-pane <?php if($active=='security'){echo 'active';}?>" id="security"> 
  <h3>Security Settings</h3>
<form class="form-horizontal" action="settings.php" method="post" id="security-settings">
<input class="form-control"type="hidden" name="save" value="security">

<div class="form-group">

<label class="col-md-3 control-label text-right" for="">Secret Word</label><div class="col-md-4">
<input class="form-control"type="text" name="secret" value="<?php echo $setting['secret'] ; ?>" id="secret"></div></div><div class="form-group">
<div class="col-md-4 col-md-offset-3">
<button class="btn btn-primary">Update</button></div></div>


</form>
</div></div>
<?php } else {?>
<p><strong>You are not authorised to view this page.</strong></p>
<?php } 
require_once('./footer.php');

?>