<!DOCTYPE html>
<html lang="en" ng-app="RootsntableApp">
	<head>

		<!-- The 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- set base for relative links - to enable pretty URLs -->
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/";?>">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!--		custom css-->
		<link href="css/style.css" rel="stylesheet" type="text/css"/>

		<!-- Stripe.js to do nothing witrh -->
		<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

				<script type="text/javascript" src="https://checkout.stripe.com/checkout.js">	</script>
	<!--Angular JS Libraries-->
	<?php $ANGULAR_VERSION = "1.5.8";?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-animate.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-stripe/4.2.12/angular-stripe.min.js"></script> -->
		<!--Script for file uploads-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.2.8/ng-file-upload.min.js"></script>

		<!--Load our angular files-->
		<script src="angular/rootsntable-app.js"></script>
		<script src="angular/route-config.js"></script>
		<script src="angular/directives/bootstrap-breakpoint.js"></script>

		<!--services-->
		<script src="angular/services/signup-service.js"></script>
		<script src="angular/services/cart-service.js"></script>
		<script src="angular/services/category-service.js"></script>
		<script src="angular/services/vendor-service.js"></script>
		<script src="angular/services/purchase-service.js"></script>
		<script src="angular/services/products-service.js"></script>
<!--		<script src="angular/services/upload-service.js"></script>-->

		<!--controllers-->
		<script src="angular/controllers/category-controller.js"></script>
		<script src="angular/controllers/vendor-controller.js"></script>
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
