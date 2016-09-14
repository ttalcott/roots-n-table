app.constant("UNIT_ENDPOINT", "php/apis/unit");
app.service("UnitService", function($http, UNIT_ENDPOINT) {
	function getUrl() {
		return(UNIT_ENDPOINT);
	}

	function getUrlForId(unitId) {
		return(getUrl() + unitId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(unitId) {
		return($http.get(getUrlForId(unitId)));
	};

	this.create = function(unit) {
		return($http.post(getUrl(), unit));
	};
	
});