app.controller('shopController', function($scope){
var counter = 0;
	$scope.product = {
		name: 'Corn',
		description:'Yellow Corn'
	};
	$scope.products = [
		{
			name: 'Corn',
			description:'Yellow Corn'
		},
		{
			name:'Apples',
			description:'Red Apples'
		},
		{
			name:'Kale',
			description:'Green Kale'
		}
	];
	$scope.addProduct = function(){
		counter++;
		$scope.products.push({
			name:'New product' + counter,
			description: counter + "New product description"
		});
	};
});

