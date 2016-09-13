app.controller('cartController', ["$scope", "purchaseService", function($scope, purchaseService){
	$scope.alerts = [];
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
	  amount: 2000
	});
};

}]);
