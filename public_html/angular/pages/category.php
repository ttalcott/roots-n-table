<div class="container">
	<div class="row">

		<!-- ng repeat this -->
		<div class="col-xs-6 col-sm-4 col-md-3" ng-repeat="category in categories">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="category selection">
				<div class="caption">
					<h3>{{ category.categoryName }}</h3>
					<p><a href="#" class="btn btn-default" role="button">Select</a></p>
				</div>
			</div>
			<!-- end ng repeat -->

		</div>
	</div>
</div>