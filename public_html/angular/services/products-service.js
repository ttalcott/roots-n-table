app.constant("PRODUCTS_ENDPOINT", "php/apis/product");
app.service("ProductsService", function($http, PRODUCTS_ENDPOINT) {
	function getUrl() {
		return(PRODUCTS_ENDPOINT);
	}

	function getUrlForId(productId) {
		return(getUrl() + productId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(productId) {
		return($http.get(getUrlForId(productId)));
	};

	this.create = function(product) {
		return($http.post(getUrl(), product));
	};

	this.update = function(productId, product) {
		return($http.put(getUrlForId(productId), product));
	};

	this.destroy = function(productId) {
		return($http.delete(getUrlForId(productId)));
	};
});

/*app.service("productsService", function($http){
this.productURL = "";
	this.fetch = function(){
		return($http.get(this.productURL));
	};
});*/
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
