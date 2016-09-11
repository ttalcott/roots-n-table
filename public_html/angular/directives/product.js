/*Directive for product.js*/
var farmDir = angular.module("farmDir", []);

app.directive('product', function(){
	return{
		restrict: 'EA',
		scope:{
			// @ reads the attribute value = provides two way binding
			title:'@'
		},
		replace:true,
		templateURL:'shop.php',
		controller: shopController,
		link: function ($scope, element, attrs){}
	}
});
