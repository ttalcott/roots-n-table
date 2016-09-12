app.controller("productController", ["$scope", "productController", function($scope, productService){
	$scope.product = null;
	$scope.sayProduct = function(){
		return("");
	};
	$scope.ButtonClick = function(){
	$scope.getProductFromService = function(){
		productService.fetch()
			.then(function(result){
				if(result.data.status === 200){
					$scope.product = result.data.data;
				}else{
					$scope.product = ["service did not return data :("];
				}
			});
	};
	};
	if($scope.product === null){
		$scope.getProductFromService();
	}
}]);