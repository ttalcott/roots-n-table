app.controller("vendorController", ["$scope", "vendorController", function($scope, vendorService){
	$scope.vendor = null;
	$scope.sayVendor = function(){
		return("");
	};
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