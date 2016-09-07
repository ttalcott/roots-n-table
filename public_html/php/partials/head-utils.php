<!DOCTYPE html>
<html lang="en" ng-app="RootsntableApp">
	<head>

		<!-- The 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- set base for relative links - to enable pretty URLs -->
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/";?>">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!--		custom css-->
		<link href="css/style.css" rel="stylesheet" type="text/css"/>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

	<!--Angular JS Libraries-->
	<?php $ANGULAR_VERSION = "1.5.8";?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-animate.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>


		<!--Load our angular files-->
		<script src="angular/rootsntable-app.js"></script>
		<script src="angular/route-config.js"></script>
		<script src="angular/directives/bootstrap-breakpoint.js"></script>
		<script src="angular/controllers/home-controller.js"></script>
		<script src="angular/controllers/nav-controller.js"></script>
		<script src="angular/controllers/about-controller.js"></script>
		<script src="angular/controllers/cart-controller.js"></script>
		<script src="angular/controllers/contact-controller.js"></script>
		<script src="angular/controllers/products-controller.js"></script>
		<script src="angular/controllers/shop-controller.js"></script>
		<script src="angular/controllers/signup-controller.js"></script>

		<title>roots'n table</title>
	</head>
</html>