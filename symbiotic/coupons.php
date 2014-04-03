<?php
require_once('cart-load.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Ongmac Motorcycles Centre | Checkout</title>
<script type="text/javascript" src="jquery.js"></script>
<link href="style.css" rel="stylesheet"  type="text/css">
</head>
<body>
	<?php 
	if(!empty($setting['fb_url'])|| !empty($setting['g_url'])){
	?>
	<div id="sym-like">Like us on Facebook and get an instant Loyalty Discount
	<?php 
	if(!empty($setting['fb_url'])){
		?>
		<div>
<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId  : '<?php echo $setting['fb_app_id']; ?>',
status : true, // check login status
cookie : true, // enable cookies to allow the server to access the session
xfbml  : true, // parse XFBML
channelUrl : '<?php echo $setting['website_url']; ?>/symbiotic/channel.html', // channel.html file
oauth  : true // enable OAuth 2.0
});
</script>
</div>


<script>
   FB.Event.subscribe('edge.create', function(href, widget) {
		$.ajax({
			type:"POST",
			url:"../cart.php",
			data:"<?php echo md5(session_id()); ?>=FACEBOOK&action=viral&ajax=true",
			success: function(html){
		alert('Click Update Cart Button');	
		}
		});
   });
</script>
<span><div id="fb-root"></div></span><script src="https://connect.facebook.net/en_US/all.js#appId=<?php echo $setting['fb_app_id']; ?>&amp;xfbml=1"></script><fb:like href="<?php echo $setting['fb_url']; ?>" send="false" width="100" show_faces="false" action="like" font=""></fb:like>
		
		<?php 
	}if(!empty($setting['g_url'])){
		?>
<script>
var originalCallback = function(o) {
    if(o.state =='on'){
    	$.ajax({
			type:"POST",
			url:"../cart.php",
			data:"<?php echo md5(session_id()); ?>=GPLUS&action=viral&ajax=true",
			success: function(html){
			
alert('Click Update Cart Button');			
			
			}
			});
        }
};
// on DOM ready

</script>    
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<span><g:plusone annotation="inline" href="<?php echo $setting['g_url']; ?>" callback="originalCallback"></g:plusone></span>
		<?php 
	} }
	?>	
</body>
</html>
