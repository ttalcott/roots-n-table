<div class="container">
	<div class="row">
			<table class="table table-striped table-responsive">
				<tr>
					<th>
						Product Name
					</th>
					<th>
						Quantity
					</th>
					<th>
						Price
					</th>
					<th>
						Delete Item
					</th>
				</tr>
				<tr ng-repeat="product in products">
					<td>
						{{ product.productName }}
					</td>
					<td>
						{{ getQuantityByProductId(product.productId); }}
					</td>
					<td>
						${{ product.productPrice | number:2 }}
					</td>
					<td>
						<button type="button" name="talcott" class="btn btn-danger" ng-click="deleteProduct(product.productId);"><i class="fa fa-trash" aria-hidden="true" ></i> Delete</button>
					</td>
				</tr>

			</table>
			<p>
				Total: ${{ total / 100 | number:2 }}
			</p>
			<button type="button" class="btn btn-primary" name="coughUp" ng-click="purchase();">Check Out</button>


	</div>
</div>
