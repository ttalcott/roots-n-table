<div class="container">
	<div class="row">
		<div class="col-md-4">
			<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
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
					<p><a href="#" class="btn btn-danger" role="button" ng-click="ButtonClick()">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegatables"/>
				<div class="caption">
					<h3>Category2</h3>
					<p></p>
					<product>
						<div ng-repeat="product in products">
							<p>
								{{product.name}}: {{product.description}}
							</p>
						</div>
					</product>
					<p><a href="" class="btn btn-danger" role="button" ng-click="ButtonClick()">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/mixed-fruit.jpeg" alt="Mixed fruit"/>
				<div class="caption">
					<h3>Category3</h3>
					<p></p>
					<product>
						<div ng-repeat="product in products">
							<p>
								{{product.name}}: {{product.description}}
							</p>
						</div>
					</product>
					<p><a href="#" class="btn btn-danger" role="button" ng-click="ButtonClick()">Want some?</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<h2>Vendor on a bender</h2>
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/vegetables.jpeg" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Vendor1</h3>
					<p></p>
					<p><a href="#" class="btn btn-danger" role="button">Want some?</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="images/drunk-cat.gif" alt="picture of vegetables"/>
				<div class="caption">
					<h3>Vendor2</h3>
					<p></p>
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
