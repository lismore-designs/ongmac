<?php
	require_once ("inc/config.php");

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

  <title>EPC Online Demo Site - Admin Page</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.7.min.js"></script>
    <!--[if lt IE 9]>
        <script src="js/libs/excanvas.js"></script>
    <![endif]-->  

  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="css/style.css?v=2">
  <link rel="stylesheet" href="css/honda.css?v=1">
  <link rel="stylesheet" href="css/admin-logs.css?v=1">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
</head>
<body>
	<div id="container">
	    <header>
	    <h1>Honda EPC Online Demo Site Admin Page - <?php echo $_dealer_name; ?></h1>
	
	    </header>
	    <div id="main" role="main">
			<div id="ModelAccessStatsContainer">
				<div id="StatsControls">
					<form id="statsFilterForm">
					<fieldset>
					<div>
						<label for="dateStart">Range Start Date</label>
						<input id="dateStart" class="datepicker" type="text">
					</div>
					<div>
						<label for="dateEnd">Range End Date</label>
						<input id="dateEnd" class="datepicker" type="text">
					</div>
					<div>
						<input type="submit" value="Filter">
					</div>
					</fieldset>	
					</form>
				</div>
	            <table id="StatsTable">
	                <thead>
	                    <tr>
	                    	<th>Product Name</th>
	                        <th>Model Name</th>
	                        <th>Assembly Name</th>
	                        <th>Year</th>
	                        <th>Timestamp</th>
	                        <th>User Ip Address</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
			</div>
	    </div> <!-- main -->
    <footer>
	<p>This sample site is copyright KnK Computech &copy;2011</p>
    </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

  <script src="js/libs/jquery.cookies.2.2.0.min.js"></script>
  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/stats.js"></script>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->



</body>
</html>