<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/

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

session_name('SYMBIOTIC');
session_start();

require_once('config.php');
require_once('functions.php');
require_once('classes/load-classes.php');
require_once('mySql-injection-vaccine.php');


// Database Connection

@$db_connection = mysql_connect(DBHOST,DBUSER,DBPWD,DBNAME);

if(!$db_connection){
	die('<h1>Database Connection error</h1>');
}
$db_selection =mysql_select_db(DBNAME,$db_connection);

// Check if user is logged in else redirect to login page
if(!$auth->is_loggedin() && (basename($_SERVER["PHP_SELF"]) != 'login.php')){
	header("location:login.php");
	exit;
}
if($auth->is_loggedin()){
define('USER',$_SESSION['curr_user']);
$setting = $settings->get_all();
}
?>