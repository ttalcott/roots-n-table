<div class="container">
	<div ng-repeat="alert in alerts" class="alert-{{alert.type}}">
		{{ alert.msg }}
	</div>
	<div class="row row-flex">

		<!-- ng repeat this -->
		<div class="col-sm-2 col-md-3"  ng-repeat="product in products">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="product selection">
				<div class="caption">
					<h2>{{ product.productName }}</h2>
					<h3>{{ getProfileByProfileId(product.productProfileId).profileFirstName}} {{ getProfileByProfileId(product.productProfileId).profileLastName}}</h3>
					<p>{{ product.productDescription }}</p>
					<p>{{ product.productPrice | currency }}</p>
				</div>
				<div>
					<p><button class="btn btn-success" role="button" ng-click="addToCart(product,1);">Add to Cart</button></p>
				</div>
			</div>
			<!-- end ng repeat -->

		</div>
	</div>
</div>

<!--<div class="container">
	<div class="row">
		<div class="col-md-4">
			<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<img src="images/mixed-fruit.jpeg" alt="Mixed fruit"/>
				<div class="caption">
					<h3>product1</h3>
					<p></p>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" placeholder="price" />
					</div>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>product2</h3>
					<p></p>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" placeholder="price" />
					</div>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Product3</h3>
					<p></p>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" placeholder="price" />
					</div>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Product4</h3>
					<p></p>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" placeholder="price" />
					</div>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
-->
