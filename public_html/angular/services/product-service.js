app.service("productService", function($http){
this.productURL = "category.php";
	this.fetch = function(){
		return($http.get(this.productURL));
	}
})
// all code below this line is incorrect
/*module.service('Product', ['$rootScope', function($rootScope){
	var service = {
		products: [
			{
				name: 'Corn',
				description: 'Yellow Corn'
			},
			{
				name: 'Apples',
				description: 'Red Apples'
			},
			{
				name: 'Kale',
				description: 'Green Kale'
			}
		],
			addProduct
		:
		function(product) {
			service.product.push(product);
			$rootScope.$broadcast('product.update')
		}
	};
	return service;
}]);*/
