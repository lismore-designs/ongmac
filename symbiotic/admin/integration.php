<?php 
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/
$pagename = 'Integration'; 
require_once('./include/admin-load.php');
require_once('./header.php');
?>

<h3>Before you start with website, you need to integrate code as follow:</h3>
<p>Repeat these steps on every page where you want to place Buttons, Images, Descriptions etc..( That means any cart functionality ).</p>
<ol>
<li><b>Step 1:</b>Copy and paste following code to <code>&lt;HEAD&gt;</code> of your webpage.<br /><br />
<pre>
&lt;link href="<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>/symbiotic/style.css" rel="stylesheet"  type="text/css"&gt;
</pre></li>
<li><b>Step 2:</b>Copy and paste following code just  before closing <code>&lt;/BODY&gt;</code> of your webpage.<br /><br />
<pre>
&lt;script type="text/javascript" src="<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>/symbiotic/jquery.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>/symbiotic/bootstrap.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>/symbiotic/cart.js"&gt;&lt;/script&gt;
</pre>
<div class="alert alert-danger">Don't include <code>jquery.min.js</code> and <code>bootstrap.min.js</code> if you have already included these before on webpage.</div>
</li>
<li><b>Step3:</b><a href="create-html.php">Create HTML Codes</a> and paste to your page where you want to create Button, Images, Descriptions etc..
</li>
</ol>
<hr>
<h3>Advanced HTML Codes</h3>
		  <h4>1. Open Cart Dialogue</h4>
		<p> Button: <button class="btn btn-primary"><i class="icon-white icon-shopping-cart"></i> Show Cart</button>
		 </p> <p> <pre>&lt;button class="btn btn-primary showAjaxCart"&gt;&lt;i class="icon-white icon-shopping-cart"&gt;&lt;/i&gt; Show Cart&lt;/button&gt;</pre>
		</p> <p>Simple link: <a href="#">Show Cart</a>
		</p> <p> <pre>&lt;a href="#" class="showAjaxCart"&gt;Show Cart&lt;/a&gt;</pre>
	</p>
<p>
To make a Show Dialogue link simply add class <code>class="showAjaxCart"</code> to an anchor, button, image.
</p>	
	  <h4>2. View current items in cart</h4>
	<p>	<div class="symbiotic-items"></div>
	</p> <p>	  <pre>&lt;div class="symbiotic-items"&gt;&lt;/div&gt;</pre> 
		</p> <p>
To show current items of cart into a div simply add class <code>class="symbiotic-items"</code> to div.
</p>	
	  <h4>3. Count total items in cart</h4>
	<p>	<div class="symbiotic-count-items"></div>
	</p> <p>	  <pre>&lt;div class="symbiotic-count-items"&gt;&lt;/div&gt;</pre> 
		</p> <p>
To show number of items in cart into a div simply add class <code>class="symbiotic-count-items"</code> to div.
</p>	
<h4>4. View current total</h4>
		 <p><div class="symbiotic-total"></div><br />
		</p> <p>  <pre>&lt;div class="symbiotic-total"&gt;&lt;/div&gt;</pre> 
		</p> <p>
To show current items of cart into a div simply add class <code>class="symbiotic-total"</code> to div.
</p>	
<hr>
<h3>If you are seeing "Loading.." and nothing loads?</h3>
<p>Click this button to check for errors: <button id="diagnose" class="btn btn-default">Check for errors</button></p>
<div class="alert" id="diag_res" style="display:none;"></div>
<script type="text/javascript">
jQuery.noConflict();
(function($) {
$(document).ready(function(){
var actual_path = '<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>';
$("#diagnose").click(function(){
var config_path = $("#symbiotic-cart-path").html();
if(config_path == actual_path){
$("#diag_res").html('No errors found');
$("#diag_res").addClass('alert-success');
$("#diag_res").fadeIn();
}else{
$("#diag_res").html("Open <code>symbiotic/cart.js</code> and change value of <code>var cartpath = \""+config_path+"\";</code> to <code>var cartpath = \"<?php echo dirname(dirname(dirname($_SERVER['PHP_SELF']))); ?>\";</code> on line no 5.");
$("#diag_res").addClass('alert-danger');
$("#diag_res").fadeIn();
}
return false;
});
});
})(jQuery);
</script>
<hr>
<h3>If web pages are not working, jQuery items not working?</h3>
<p>The twitter Bootstrap javascript might be conflicting with jQuery. Try not including <code>bootstrap.js</code> on your pages or use jQuery.noConflict() .
e.g.of jQuery.noConflict():
<pre>
jQuery.noConflict();
(function($) {
$(document).ready(function(){
// Your jQuery code here
});
})(jQuery);
</pre>
</p>
<hr>
<p>Read Documentation <a target="_blank" href="http://superblab.com/symbiotic/how-to">here</a></p>
<?php

require_once('./footer.php');

?>