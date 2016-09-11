var vendorDir = angular.module("vendorDir", []);

app.directive('vendor', function(){
	return{
		restrict:'EA',
		scope:{
			title:'@'
		},
		replace:true,
		templateURL:'shop.php',
		controller: vendorController,
		link: function($scope, element, attrs){}
	}
});
