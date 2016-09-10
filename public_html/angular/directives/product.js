/*Directive for product.js*/
var farmApp = angular.module("farmApp", []);

farmApp.directive('product', function(){
	return{
		restrict: 'EA',
		scope:{
			title:'@'
		},
		treplace:true,
		templateURL:'shop.php',
		controller: shopController,
		link: function ($scope, element, attrs){}
	}
});
