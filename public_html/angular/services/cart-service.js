app.constant("CART_ENDPOINT", "php/apis/cart");
app.service("cartService", function($http, CART_ENDPOINT){
	function getUrl() {
		return(CART_ENDPOINT);
	}

	this.fetch = function() {
		return($http.get(getUrl()));
	};

	this.create = function(productId, quantity) {
		return($http.post(getUrl(), {productId: productId, cartQuantity: quantity}));
	};

	this.destroy = function() {
		return($http.delete(getUrl()));
	};
});
