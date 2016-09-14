app.constant("PRODUCTS_ENDPOINT", "php/apis/products");
app.service("ProductsService", function($http, PRODUCTS_ENDPOINT) {
	function getUrl() {
		return(PRODUCTS_ENDPOINT);
	}

	function getUrlForId(productsId) {
		return(getUrl() + productsId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(productsId) {
		return($http.get(getUrlForId(productsId)));
	};

	this.create = function(products) {
		return($http.post(getUrl(), products));
	};

	this.update = function(productsId, products) {
		return($http.put(getUrlForId(productsId), products));
	};

	this.destroy = function(productsId) {
		return($http.delete(getUrlForId(productsId)));
	};
});

/*app.service("productssService", function($http){
this.productsURL = "";
	this.fetch = function(){
		return($http.get(this.productsURL));
	};
});*/
// all code below this line is incorrect
/*module.service('products', ['$rootScope', function($rootScope){
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
