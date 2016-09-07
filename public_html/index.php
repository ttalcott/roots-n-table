<!--	<body>
		<div class="container container-table">
			<div class="row vertical-center-row">
				<div class="text-center col-md-4 col-md-offset-4 test">
					<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<button type="button" class="btn btn-danger btn-lg buttn">SHOP</button>
				<button type="button" class="btn btn-danger btn-lg pull-right buttn">JOIN US</button>
			</div>
		</div>
	</body>
</html>-->
<?php require_once("php/partials/head-utils.php");?>
<body class="sfooter">
<?php require_once ("php/partials/logo.php");?>
	<div class="sfooter-content">

		<!--begin header-->
		<?php require_once("php/partials/header.php"); ?>

		<!--begin main content -->
		<main>
			<div class="container-fluid">

				<div ng-view></div>

			</div>
		</main>
	</div>
	<?php require_once("php/partials/footer.php");?>
</body>

