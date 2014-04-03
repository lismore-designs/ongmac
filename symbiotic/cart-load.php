<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
function sanitize_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
        '/[^\S ]+\</s', //strip whitespaces before tags, except space
        '/(\s)+/s'  // shorten multiple whitespace sequences
        );
    $replace = array(
        '>',
        '<',
        '\\1'
        );
    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}

ob_start("sanitize_output");


session_name('SYMCART');
session_start();

$path = dirname(__FILE__);
foreach (glob($path ."/languages/lang.*.php") as $file) {
    $filename = basename($file);
    require_once('languages/'.$filename);
	$len = strlen($filename) - 9;
	$langname= substr($filename,5,$len);
	$lang[$langname] = $translation;
	unset($translation);
}

require_once('admin/include/config.php');
require_once('functions.php');
require_once('classes/load-classes.php');
require_once('mySql-injection-vaccine.php');
// Database Connection

$db_connection = mysql_connect(DBHOST,DBUSER,DBPWD,DBNAME);

if(!$db_connection){
	die('<h1>Database Connection error</h1>');
}
$db_selection =mysql_select_db(DBNAME,$db_connection);
$setting = $settings->get_all();

if(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 'signout'){
	$auth->signout();
	}
}

DEFINE('MODE',$setting['mode']);
DEFINE('LANG','english');
DEFINE('CURRENCY',$setting['currency']);
DEFINE('CS',$setting['currency_symbol']);
DEFINE('MINITEMS',$setting['shipping_min_items']);
DEFINE('MAX',$setting['max_order_total']);
DEFINE('SHIPPINGMODE',$setting['shipping_mode']);
DEFINE('BASE',$setting['website_url']);
DEFINE('FREESHIPPING',$setting['free_shipping']);


?>