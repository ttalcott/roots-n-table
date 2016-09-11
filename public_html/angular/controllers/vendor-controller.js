app.controller('vendorController', function($scope){
	$scope.ButtonClick = function(){
		var counter = 0;
		$scope.vendor = {
			name:'John Deere',
			description: 'Green and yellow farm'
		};
	}
})