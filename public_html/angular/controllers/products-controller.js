app.controller("productsController", ["$scope", "ProductsService", function($scope, ProductsService){
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

	if($scope.products.length === 0){
		$scope.products = $scope.getProducts();
	}
}]);