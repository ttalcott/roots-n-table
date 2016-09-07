<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>contact</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<link href="../../css/style.css" rel="stylesheet" type="text/css"/>

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
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<img src="../../images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>

		<!--		contact form-->
		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<form class="form-horizontal">
						<div class="form-group">
							<label for="textInput"></label>
							<input type="text" class="form-control" id="textInput" placeholder="Firstname"/>
						</div>
						<div class="form-group">
							<label for="textInput"></label>
							<input type="text" class="form-control" id="textInput" placeholder="Lastname"/>
						</div>
						<div class="form-group">
							<label for="emailInput"></label>
							<input type="email" class="form-control" id="emailInput" placeholder="Email"/>
						</div>
						<div class="form-group">
							<label for="textInput"></label>
							<textarea class="form-control" rows="3" placeholder="Leave a message"></textarea>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-6">
								<button type="button" class="btn btn-danger">Contact</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		<footer class="foot">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
						&copy; 2016 Roots-'n-table
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>