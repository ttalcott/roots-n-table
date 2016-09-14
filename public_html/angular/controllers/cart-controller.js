app.controller('cartController', ["$scope", "$window", "purchaseService", "cartService", function($scope, $window, purchaseService, cartService){
	$scope.alerts = [];
	$scope.cart = [];
	$scope.products = [];
	$scope.total = 0;
	$scope.handler = StripeCheckout.configure({
  key: 'pk_test_6pRNASCoBOKtIshFeQd4XMUh',
  locale: 'auto',
  token: function(token) {
    // Use the token to create the charge with a server-side script.
    // You can access the token ID with `token.id`
  }
});
$scope.purchase = function(){
	$scope.handler.open({
	  name: 'Roots \'n Table',
	  description: 'Purchase of Goods Provided',
	  amount: $scope.total
	});
};

$scope.getCart = function() {
	cartService.fetchWithProductArray()
		.then(function(result) {
			if(result.data.status === 200) {
				$scope.cart = result.data.data.cart;
				$scope.products = result.data.data.products;
				$scope.total = result.data.data.total;
			}
		});
};

$scope.getQuantityByProductId = function(productId) {
	return($scope.cart[productId]);
};

$scope.deleteProduct = function(productId) {
	cartService.create(productId, 0)
		.then(function(result) {
			if(result.data.status === 200) {
				$window.location.reload();
			}
		});
};

if($scope.cart.length === 0) {
	$scope.getCart();
}

}]);
