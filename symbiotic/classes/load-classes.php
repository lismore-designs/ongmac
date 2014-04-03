<?php
require_once('class.address.php');
require_once('class.auth.php');
require_once('class.cart.php');
require_once('class.coupon.php');
require_once('class.encryption.php');
require_once('class.order.php');
require_once('class.product.php');
require_once('class.settings.php');
require_once('class.shipping.php');
require_once('class.userpanel.php');
require_once('class.validate.php');

$address = new Address;
$auth = new Auth;
$cart = new Cart;
$coupon = new Coupon;
$crypt = new encryption_class;
$order = new Order;
$product = new Product;
$settings = new Settings;
$shipping = new Shipping;
$user = new User;
$validate = new Validate;
?>