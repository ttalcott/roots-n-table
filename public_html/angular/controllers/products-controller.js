app.controller('productsController', ["$scope", "ProductsService", "cartService",  function($scope, ProductsService, cartService){
	$scope.products = [];
/*	$scope.sayProduct = function(){
		return("");
	};*/

	$scope.getProducts = function(){
		ProductsService.all()
			.then(function(result){
				if(result.data.status === 200){
					$scope.products = result.data.data;
				}else{
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};
	
	//link to cart
	$scope.addToCart = function(product, quantity){
		cartService.create(product,quantity)
			.then(function(result) {
				if(result.data.status === 200){
					$scope.alerts[0] = {type: "success", msg: result.data.message};
				}else{
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	if($scope.products.length === 0){
		$scope.products = $scope.getProducts();
	}
}]);