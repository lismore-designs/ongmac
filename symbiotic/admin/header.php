<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Ongmac Motorcycles | <?php echo $pagename; ?></title>

<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
<link rel="icon" type="image/vnd.microsoft.icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
<link rel="shortcut icon" type="image/x-icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />

<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.printElement.js"></script>
<script type="text/javascript" src="js/symbiotic.js"></script>
<script type="text/javascript" src="../cart.js"></script>
<script type="text/javascript">
jQuery.noConflict();
(function($) {
$(document).ready(function(){
$("#sidebar .nav-tabs .sidebar-header").siblings().hide();
$("#sidebar .nav-tabs .sidebar-header").prepend("<span class='glyphicon glyphicon-chevron-down'></span>&nbsp;");
$("#sidebar .nav-tabs .sidebar-header").click(function(){
var shown = $(this).attr('data-shown');
if(shown != 'true'){
$(this).addClass('active-head');
$(this).parent().children('li').slideDown();
$(this).children('span').removeClass('glyphicon-chevron-down');
$(this).children('span').addClass('glyphicon-chevron-up');
$(this).attr('data-shown','true');
}else{
$(this).siblings().slideUp();
$(this).removeClass('active-head');
$(this).children('span').removeClass('glyphicon-chevron-up');
$(this).children('span').addClass('glyphicon-chevron-down');
$(this).attr('data-shown','false');
}
});

var thisdoc = "<?php echo basename($_SERVER['PHP_SELF']);?>";
$("#sidebar .nav-tabs a").each(function(){
var target = $(this).attr('href');
if(target == thisdoc){
$(this).parent().addClass("active");
$(this).parent().parent().children('li').show();
$(this).parent().parent().children('.sidebar-header').addClass('active-head');
$(this).parent().parent().children('.sidebar-header').children('span').removeClass('glyphicon-chevron-down');
$(this).parent().parent().children('.sidebar-header').children('span').addClass('glyphicon-chevron-up');
$(this).parent().parent().children('.sidebar-header').attr('data-shown','true');
}
})

});
})(jQuery);
</script>
</head>
<body>
<?php $orders_new = $order->all('seen','no');
$num_new = count($orders_new);
?>
<div class="container">
<div class="row">
<div class="col-md-2" id='sidebar'>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Dashboard</li>
<li><a href="index.php" >Home</a></li>
</ul>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Orders</li>
<li><a href="orders.php" >All Orders</a></li>
<li><a href="orders-new.php" >New Orders <?php if($num_new > 0){echo "<span class=\"badge\">".$num_new."</span>";}?></a></li>
<li><a href="order-details.php" >Search</a></li>
<li><a href="orders-monthly.php" >Monthly Orders</a></li>
<li><a href="create-invoice.php" >Create Invoices</a></li>
</ul>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Products</li>
<li><a href="products.php" >All Products</a></li>
<?php /*?><li><a href="product-add.php" >Add New</a></li><?php */?>
<li><a href="products-out.php" >Out of Stock</a></li>
</ul>

<?php if($user->is_admin(USER)){ ?>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Coupons</li>
<li><a href="coupons.php" >All Coupon</a></li>
<li><a href="coupon-add.php" >Add New</a></li>
<li><a href="coupons-deleted.php" >Deleted</a></li>
</ul>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Shipping</li>
<li><a href="shipping.php" >Shipping Settings</a></li>
<li><a href="shipping-regions.php" >Shipping Regions</a></li>
<li><a href="shipping-region-add.php" >Add Shipping Region</a></li>
</ul>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Customers</li>
<li><a href="customers.php" >All Customers</a></li>
</ul>
<ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Settings</li>
<li><a href="settings.php" >Settings</a></li>
<li><a href="settings-admins.php" >Manage Admin Users</a></li>
</ul>
<?php } ?>
<?php /*?><ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Integration</li>
<li><a href="create-html.php" >Create HTML Code</a></li>
<li><a href="integration.php" >Integration</a></li>
</ul><?php */?>
<?php /*?><ul class="nav nav-tabs nav-stacked ">
<li class="sidebar-header">Help</li>
<li><a href="symbiotic.php?page=about" >About Symbiotic</a></li>
<li><a href="symbiotic.php?page=help" >Help</a></li>
<li><a href="symbiotic.php?page=updates" >Updates</a></li>
<li><a href="symbiotic.php?page=support" >Support</a></li>
</ul><?php */?>

</div>
<div class="col-md-10 main-body">
<div class="page-header"><h1><?php echo $pagename; ?></h1></div>
<div class="alert alert-success" id="message" style="display:none;"></div>


<?php
if(isset($error)){
echo "<div class='alert alert-danger'>$error</div>";
}
if(isset($success)){
echo "<div class='alert alert-success'>$success</div>";
}
if($setting['mode'] == '0'){
?>

<div class="alert alert-success">
<h3>Looks like you just installed Ajax Cart</h3>
<p>Before you  go live you need to follow these easy steps:</p>
<ol>
<li>Delete <code>install.php</code>.</li>
<li>Open <code>symbiotic/cart.js</code> and change value of <code>var cartpath = "";</code> to <code>var cartpath = "<?php echo dirname(dirname(dirname($_SERVER['REQUEST_URI']))); ?>";</code> on line no 5.</li>
<li><a href="integration.php">Integrate</a> Ajax Cart into your webpages.</li>
<li>Go to <code>Settings -> Website Settings</code> and Change mode to <code>Live</code>.</li>
<li>Enjoy.</li>
</ol>
<p>You can always contact us for  free support at our <a target="_blank" href="http://digitalimagination.in/support">Support Site</a></p>
</div>
<?php }?>
