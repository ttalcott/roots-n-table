<header ng-controller= "navController">

	<!-- bootstrap breakpoint directive to control collapse behavior -->
	<bootstrap-breakpoint></bootstrap-breakpoint>

	<nav class="navbar navbar-default">
		<div class="container-fluid">

			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
					<span class="glyphicon glyphicon-menu-hamburger"></span>
				</button>
				<a class="navbar-brand" href="home">Roots-'n-Table</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="mainNavBar">
								<form class="navbar-form navbar-left">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</form>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="about">About</a></li>
					<li><a href="about">Shop</a></li>
					<li><a href="signup">Sign in/Sign up</a></li>
					<li><a href="contact">Contact</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>