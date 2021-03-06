<div class="container">
	<div class="row">

	</div>
</div>
<div class="container shop">
	<div class="row">
		<div class="col-md-4">
			<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
		</div>
		<div class="col-md-8">
			<h1>Our mission</h1>
			<p class="lead">
				Our mission is to provide local communities with the best connection within every party involved in the local food system. We will develop the mechanisms required for everyone to have the best of experiences when it comes to purchasing or selling food.
			</p>
		</div>
	</div>
</div>
<div class="container">
	<h2>Categories</h2>
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/mixed-fruit.jpeg" alt="Mixed fruit"/>
				<div class="caption">
					<h3>Category1</h3>
					<p></p>
					<product>
						<div ng-repeat="product in products">
							<p>
								{{product.name}}: {{product.description}}
							</p>
						</div>
					</product>
					<p><a href="category" class="btn btn-danger" role="button" ng-click="ButtonClick()">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegatables"/>
				<div class="caption">
					<h3>Category2</h3>
					<p></p>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/mixed-fruit.jpeg" alt="Mixed fruit"/>
				<div class="caption">
					<h3>Category3</h3>
					<p></p>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<h2>Vendor</h2>
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Vendor1</h3>
					<p></p>
					<p><a href="#" class="btn btn-danger" role="button" ng-click="ButtonClick()">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Vendor2</h3>
					<p></p>
					<vendor>
						<div ng-repeat="vendor in vendors">
							<p>
								{{vendor.name}}: {{vendor.description}}
							</p>
						</div>
					</vendor>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Vendor3</h3>
					<p></p>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
