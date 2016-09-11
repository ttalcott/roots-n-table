app.controller('vendorController', function($scope){
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
		]
	}
})