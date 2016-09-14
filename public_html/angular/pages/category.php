<div class="container">
	<div class="row">
		<div class="col-md-12">
			<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">

		<!-- ng repeat this -->
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2" ng-repeat="category in categories">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="category selection">
				<div class="caption">
					<h3>{{ category.categoryName }}</h3>
					<p><button class="btn btn-danger" role="button" ng-click="products">Want Some?</button></p>
<!--					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>-->
				</div>
			</div>
			<!-- end ng repeat -->

		</div>
	</div>
</div>