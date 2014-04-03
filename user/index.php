<?php
$title='User Home';
require_once('header.inc.php');
require_once('nav.inc.php');

?>
<h1>Welcome <?php echo $_SESSION['curr_user_name'] ;?></h1><hr>
<h2>What do you want to do now?</h2>
<h3>View <a href="#" class="showAjaxCart" >Cart</a></h3>
<h3>See my <a href="orders.php">orders</a></h3>
<h3>Track my <a href="order-status.php">orders</a></h3>
<h3>Manage my shipping <a href="addresses.php">addresses</a></h3>
<h3>Change <a href="account.php">password</a></h3>
</div>
<?php
require_once('footer.inc.php');
?>