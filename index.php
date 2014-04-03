<?php
/*Copyright (C) 2011 by K & K Computech

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

// Make call to Dealer Admin site to check subscription
	require_once ("inc/config.php");

// Dealer Key first, then product key
$access_url = "http://adminapi.epconline.com.au/Subscription/AccessKey/{$_dealer_key}/{$_product_key_honda}/";
//print($access_url);
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$access_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$buffer = curl_exec($ch);
curl_close($ch);

$accessKey = str_replace('"', '',$buffer);

setcookie("accesskey[honda]", $accessKey);

setcookie("epcconfig[honda]", $_configured_product_types);


?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Ongmac | Honda Parts Catalogue</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">



  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="icon" type="image/vnd.microsoft.icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="http://www.ongmacmotorcycles.com.au/img/favicon.ico" />
    <!-- Link to web font -->
  <link href='http://fonts.googleapis.com/css?family=Chivo:400,900' rel='stylesheet' type='text/css'>



	
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.7.min.js"></script>
    <!--[if lt IE 9]>
        <script src="js/libs/excanvas.js"></script>
    <![endif]-->  

  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="css/style.css?v=2">
  <link rel="stylesheet" href="css/honda.css?v=1">
  <link rel="stylesheet" href="colorbox.css" type="text/css">
  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
</head>
<body>
	<div id="container">
	    <header>
	        <h1>&nbsp;</h1>
            <div id="logo"></div>
            <div class="contentTop">
                <h2>Honda Parts Search</h2>
            </div>
	    </header>

	    <div id="main" role="main">
        <style type="text/css">
        .cart_div{color: #000;position: absolute;margin-top: -58px;font-size: 16px;right: 35px;
		background-image: url(img/cart-77-24.png);background-repeat: no-repeat;width: 85px;}
		.cart_div a{color:#000; text-decoration:none;}
		.span_tag{margin-left:30px;}
        </style>
        <div id="cattotal" class="cart_div"><a href="/cart.php"><span class="span_tag" id="cart_count_front">Cart (0)</span></a></div>
        
			<div id="top">
			    <div id="imageWrap">
			    </div>
			    <div id="FilterPanel">
			        <div id="TypeSelection">
			            <div>
			                <select id="TypeSelect" name="TypeSelect">
			                </select>
			            </div>
			            <div id="YearSelection">
			                <select id="YearSelect" name="YearSelect"></select>
			            </div>
			            <div id="ModelSelection">
			                <select id="ModelSelect" name="ModelSelect"></select>
			            </div>
				        <div id="AssemblySelection">
				            <select id="AssemblySelect" name="AssemblySelect"></select>
				        </div>
				        <div id="AccessorySelection">
				            <select id="AccessorySelect" name="AccessorySelect"></select>
				        </div>
				        <div id="AdrAssemblySelection">
				            <select id="AdrAssemblySelect" name="AdrAssemblySelect"></select>
				        </div>
			        </div>

			    </div>
			</div>
			    <div id="AssemblyContainer">
                    <div id="Diagram">
                        <canvas id="imageCanvas" width="928" height="400">
                            Your browser doesn't support the canvas element. Please get a new browser
                        </canvas>
                        <div id="DiagramControls">
                            <input id="zoomIn" type="button" value="+" />
                            <input id="zoomOut" type="button" value="-" />
                        </div>
                    </div>
			       <div id="PartsListContainer">
			            <table id="PartsList">
			                <thead>
			                    <tr>
			                        <th>Ref No.</th>
			                        <th>Desc</th>
			                        <th>Number</th>
			                        <th>Qty per Assembly</th>
			                        <th>Qty to Order</th>
			                        <th>Price</th>
			                        <th>Action</th>
			                    </tr>
			                </thead>
			                <tbody>
			                </tbody>
			            </table>
			        </div>


			        <div id="status"><textarea id="statuslog" rows="20" cols="20"></textarea></div>
			    </div>

	    </div> <!-- main -->
    <div id="footer">

	<div id="tmfooterlinks"><div class="footerlinks_block"><h4>Your Account</h4><ul><li><a href="http://parts.ongmacmotorcycles.com.au/user/index.php">Your Account</a></li><li><a href="http://parts.ongmacmotorcycles.com.au/user/account.php">Personal information</a></li><li><a href="http://parts.ongmacmotorcycles.com.au/user/addresses.php">Addresses</a></li><li><a href="http://www.ongmacmotorcycles.com.au/discount.php">Discount</a></li><li><a href="http://parts.ongmacmotorcycles.com.au/user/orders.php">Order history</a></li></ul></div><div class="footerlinks_block"><h4>Our offers</h4><ul><li><a href="http://www.ongmacmotorcycles.com.au/new-products.php">New products</a></li><li><a href="http://www.ongmacmotorcycles.com.au/best-sales.php">Top sellers</a></li><li><a href="http://www.ongmacmotorcycles.com.au/prices-drop.php">Specials</a></li><li><a href="http://www.ongmacmotorcycles.com.au/manufacturer.php">Manufacturers</a></li><li><a href="http://www.ongmacmotorcycles.com.au/supplier.php">Suppliers</a></li></ul></div><div class="footerlinks_block"><h4>Information</h4><ul><li><a href="http://www.ongmacmotorcycles.com.au/cms.php?id_cms=1">Delivery</a></li><li><a href="http://www.ongmacmotorcycles.com.au/cms.php?id_cms=2">Legal Notice</a></li><li><a href="http://www.ongmacmotorcycles.com.au/cms.php?id_cms=3">Terms and conditions</a></li><li><a href="http://www.ongmacmotorcycles.com.au/cms.php?id_cms=4">About us</a></li><li> <a href="http://www.lismore-designs.com.au" target="_blank">Lismore Designs &amp; Hosting</a></li></ul></div><div class="footerlinks_block"><h4>Our stores</h4><ul> <a href="http://www.ongmacmotorcycles.com.au/stores" title="Lismore Store"><img src="http://www.ongmacmotorcycles.com.au/modules/blockstore/210925_171954766221075_100002196577011_339062_609117506_o.jpg" alt="Our stores" height="140" width="200"></a><br> <a href="http://www.ongmacmotorcycles.com.au/stores" title="Our stores"></a></ul></div><div class="clearblock"></div></div>
	
	
    </div>
  </div> <!-- end of #container -->




  <input type="hidden" id="selectedType" value="<?php echo $_POST['TypeSelect'] ?>" />
  <input type="hidden" id="selectedYear" value="<?php echo $_POST['YearSelect'] ?>" />
  <input type="hidden" id="selectedModelId" value="<?php echo $_POST['ModelSelect'] ?>" />
  <input type="hidden" id="selectedAssemblyId"  value="<?php echo $_POST['AssemblySelect'] ?>"/>


    <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='js/libs/jquery-1.10.2.min.js'>\x3C/script>")</script>






  <script src="js/libs/jquery.cookies.2.2.0.min.js"></script>
  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/hondaepc.js"></script>
  <script src="js/jquery.colorbox.js"></script>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->
  
<div id="add_to_cart_done" style="display:none;width: 100%;text-align: center;margin-top: 65px;font-family: verdana;font-weight: bold;font-size: 15px;">
Item added to cart successfully
</div>




</body>
</html>