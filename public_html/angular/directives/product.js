/*Directive for product.js*/
var farmDir = angular.module("farmDir", []);

app.directive('product', function(){
	return{
		restrict: 'EA',
		scope:{
			title:'@'
		},
		replace:true,
		templateURL:'shop.php',
		controller: shopController,
		link: function ($scope, element, attrs){}
	}
});
