app.controller('vendorController', ["$scope", "VendorService", function($scope, VendorService) {
	$scope.vendors = [];
	/**
	 * fulfills the promise from retrieving the vendors from profile API
	 **/
	$scope.getVendors = function() {
		VendorService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.categories = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	// load the array on first view
	if($scope.vendors.length === 0) {
		$scope.vendors = $scope.getVendors();
	}
}]);
/* app.controller('vendorController', function($scope){
	$scope.ButtonClick = function(){
		var counter = 0;
		$scope.vendor = {
			name:'John Deere',
			description: 'Green and yellow farm'
		};
		$scope.vendors = [
			{
				name:'John Deere',
				description: 'Green and yellow farm'
			},
			{
				name:'Fuzzy Dcat',
				description:'Fuzzy farms full of peaches'
			},
			{
				name:'Rob Engel',
				description:'Lyndex farms'
			}
		];
		$scope.addFarm = function(){
			counter++;
			$scope.vendor.push({
				name:'New vendor' + counter,
				description: counter + 'New farm description'
			});
		};
	};
});*/