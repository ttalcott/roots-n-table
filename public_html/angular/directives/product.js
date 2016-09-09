/*Directive for product.js*/
var farmApp = angular.module("farmApp", []);

farmApp.directive('product', function(){
	return{
		restrict: 'AE',
		replace: true,
		templateURL:'',
	}
})
