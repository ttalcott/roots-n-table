<header ng-controller="navController">

	<!-- bootstrap breakpoint directive to control collapse behavior -->
	<bootstrap-breakpoint></bootstrap-breakpoint>

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
</header>