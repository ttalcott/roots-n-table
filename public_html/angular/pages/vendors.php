<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Roots-'n-table</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!--		custom css-->
		<link href="css/style.css" rel="stylesheet" type="text/css"/>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
						<span class="glyphicon glyphicon-menu-hamburger"></span>
					</button>
					<a class="navbar-brand" href="#">Roots-'n-Table</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="mainNavBar">
					<ul class="nav navbar-nav">
						<li class="nav-item"><a href="#">Home</a></li>
					</ul>
					<form class="navbar-form navbar-left">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-default">Search</button>
					</form>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Sign in/Sign up</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								aria-expanded="false">Shop<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Fruit</a></li>
								<li><a href="#">Vegetables</a></li>
								<li><a href="#">About us</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">Contact</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<img src="../../images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
				</div>
				<div class="col-md-8">
					<h1>Our mission</h1>
					<p class="lead">
						In graecis laboramus mei, pro ea everti alienum.
						Vix ferri vivendum efficiendi at, et atqui discere mnesarchum mei,et eum altera equidem
						vituperatoribus. Ei qui wisi tibique placerat.Ne mea sumo consequuntur, sale accusam electram ei usu.
						Dolore eruditireprimique his te.
					</p>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<div class="thumbnail">
						<img src="../../images/mixed-fruit.jpeg" alt="Mixed fruit"/>
						<div class="caption">
							<h3>Fruit</h3>
							<p></p>
							<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="thumbnail">
						<img src="../../images/vegetables.jpeg" alt="picture of vegatables"/>
						<div class="caption">
							<h3>Vegetables</h3>
							<p></p>
							<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>