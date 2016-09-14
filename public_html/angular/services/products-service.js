app.constant("PRODUCT_ENDPOINT", "php/apis/product");
app.service("ProductsService", function($http, PRODUCT_ENDPOINT) {
	function getUrl() {
		return(PRODUCT_ENDPOINT);
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

/*app.service("productssService", function($http){
this.productsURL = "";
	this.fetch = function(){
		return($http.get(this.productsURL));
	};
});*/
// all code below this line is incorrect
/*module.service('product', ['$rootScope', function($rootScope){
	var service = {
		productss: [
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
			addproducts
		:
		function(productss) {
			service.productss.push(productss);
			$rootScope.$broadcast('productss.update')
		}
	};
	return service;
}]);*/
