<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$frame = $_REQUEST['page'];
switch($frame){
case 'about':
$pagename = 'About Symbiotic Cart'; 
$link = 'http://superblab.com/symbiotic'; 
break;
case 'help':
$pagename = 'Help'; 
$link = 'http://superblab.com/symbiotic/how-to'; 
break;
case 'updates':
$pagename = 'Updates'; 
$link = 'http://superblab.com/symbiotic/update-history'; 
break;
case 'support':
$pagename = 'Support'; 
$link = 'http://superblab.com/support';
break;
default:
$pagename = 'About Symbiotic Cart'; 
$link = 'http://superblab.com/symbiotic'; 
}

require_once('./include/admin-load.php');
require_once('./header.php');

?>
<iframe src="<?php echo $link; ?>?screen=horizontal" style="width:99%;height:750px;border:none;"></iframe>
<?php

require_once('./footer.php');

?>