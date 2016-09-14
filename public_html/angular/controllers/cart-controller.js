app.controller('cartController', ["$scope", "purchaseService", "cartService", function($scope, purchaseService, cartService){
	$scope.alerts = [];
	$scope.cart = null;
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
	  amount: $scope.cart.total
	});
};

$scope.getCart = function() {
	cartService.fetchWithProductArray()
		.then(function(result) {
			if(result.data.status === 200) {
				$scope.cart = result.data.data;
			}
		});
};

if($scope.cart === null) {
	$scope.getCart();
}

}]);
