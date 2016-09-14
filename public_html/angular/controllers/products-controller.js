app.controller('productsController', ["$scope", "ProductsService", "cartService", "ProfileService", function($scope, ProductsService, cartService, ProfileService) {
	$scope.alerts = [];
	$scope.products = [];
	$scope.profiles = [];

	$scope.getProducts = function() {
		ProductsService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.products = result.data.data;
					$scope.getAllVendors();
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	$scope.getAllVendors = function() {
		for (var product in $scope.products) {
			product = $scope.products[product];
			ProfileService.fetch(product.productProfileId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.profiles.push(result.data.data);
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.getProfileByProfileId = function(profileId) {
		for (var profile in $scope.profiles) {
			profile = $scope.profiles[profile];
			if (profile.profileId === profileId) {
				return profile;
			}
		}
	};

	//link to cart
	$scope.addToCart = function(product, quantity) {
		cartService.create(product.productId, quantity)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.alerts[0] = {type: "success", msg: result.data.message};
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	if($scope.products.length === 0) {
		$scope.products = $scope.getProducts();
	}
}]);
