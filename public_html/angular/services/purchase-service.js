app.constant("PURCHASE_ENDPOINT", "php/apis/purchase/");
app.service("purchaseService", function($http, PURCHASE_ENDPOINT){
	function getUrl() {
		return(PURCHASE_ENDPOINT);
	}

	function getUrlForId(purchaseId) {
		return(getUrl() + purchaseId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(purchaseId) {
		return($http.get(getUrlForId(purchaseId)));
	};

	this.create = function(purchase) {
		$http.post(getUrl(), purchase);
	};
});
