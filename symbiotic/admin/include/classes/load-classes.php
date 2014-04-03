<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/

$path = dirname(__FILE__);

foreach (glob($path ."/class.*.php") as $file) {

    $filename = basename($file);

    require_once($filename);

	$len = strlen($filename) - 10;

	$classname= substr($filename,6,$len);

	$class = ucfirst($classname);

	$$classname = new $class;

}


?>