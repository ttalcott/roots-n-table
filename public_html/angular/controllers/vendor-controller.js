app.controller("vendorController", ["$scope", "vendorController", function($scope, vendorService){
	$scope.vendor = null;
	$scope.sayVendor = function(){
		return("");
	};
	$scope.getVendorFromService = function(){
		vendorService.fetch()
			.then(function(result){
				if(result.data.status === 200){
					$scope.vendor = result.data.data;
				}else{
					$scope.vendor = ["service did not return data :("];
				}
			});
	};
	if($scope.vendor === null){
		$scope.getVendorFromService();
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