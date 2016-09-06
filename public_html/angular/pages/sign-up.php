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
			<p class="lead">
				I know it seems like we need more of your personal information to sell vegetables than if you where applying for a car loan, but don't worry we DO NOT store any of your personal information in our database.
			</p>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-10">
		<form>
			<div class="form-group">
				<label for="address"></label>
				<input type="text" class="form-control" id="address" placeholder="Address" />
			</div>
			<div class="form-group">
				<label for="country"></label>
				<input type="text" class="form-control" id="country" placeholder="Country" />
			</div>
			<div class="form-group">
				<label for="DOB"></label>
				<input type="text" class="form-control" id="DOB" placeholder="Date of birth" />
			</div>
			<div class="form-group">
				<label for="InputEmail"></label>
				<input type="email" class="form-control" id="InputEmail" placeholder="Email" />
			</div>
			<div class="form-group">
				<label for="firstName"></label>
				<input type="text" class="form-control" id="firstName" placeholder="Firstname" />
			</div>
			<div class="form-group">
				<label for="LastName"></label>
				<input type="text" class="form-control" id="LastName" placeholder="Lastname" />
			</div>
			<div class="form-group">
				<label for="PhoneNumber"></label>
				<input type="text" class="form-control" id="PhoneNumber" placeholder="Phone Number" />
			</div>
			<div class="form-group">
				<label for="SSN"></label>
				<input type="text" class="form-control" id="SSN" placeholder="Social Security Number" />
			</div>
			<div class="form-group">
				<label for="UserName"></label>
				<input type="text" class="form-control" id="UserName" placeholder="User Name" />
			</div>
		</form>
		</div>
		<div class="col-md-1"></div>
	</body>
	</html>