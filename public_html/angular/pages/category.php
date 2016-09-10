		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<img src="images/rootsntable-1.png" alt="logo for roots n table" class="img-circle"/>
				</div>
				<div class="col-md-8">
					<h1>Products</h1>
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
							<product>
								<div ng-repeat="product in products">
									<ul>
										<li>
											{{product.name}}: {{product.description}}
										</li>
									</ul>
								</div>
							</product>
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