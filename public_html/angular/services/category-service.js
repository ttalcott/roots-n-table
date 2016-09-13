app.constant("CATEGORY_ENDPOINT", "php/apis/category/");
app.service("CategoryService", function($http, CATEGORY_ENDPOINT) {
	function getUrl() {
		return (CATEGORY_ENDPOINT);
	}

	function getUrlForId(categoryId) {
		return (getUrl() + categoryId);
	}

	this.all = function() {
		return ($http.get(getUrl()));
	};

	this.fetch = function(categoryId) {
		return ($http.get(getUrlForId(categoryId)));
	};
});