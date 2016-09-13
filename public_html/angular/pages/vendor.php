<div class="container">
	<div class="row">

		<!-- ng repeat this -->
		<div class="col-xs-6 col-sm-4 col-md-3" ng-repeat="vendor in vendors">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="vendor selection">
				<div class="caption">
					<h3>{{ vendor.profileName }}</h3>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
			<!-- end ng repeat -->

		</div>
	</div>
</div>