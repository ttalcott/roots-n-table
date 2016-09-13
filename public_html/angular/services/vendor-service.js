app.constant("VENDOR_ENDPOINT", "api/vendor/");
app.service("VendorService", function($http, VENDOR_ENDPOINT) {
	function getUrl() {
		return(VENDOR_ENDPOINT);
	}

	function getUrlForId(vendorId) {
		return(getUrl() + vendorId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(vendorId) {
		return($http.get(getUrlForId(vendorId)));
	};

	this.create = function(vendor) {
		return($http.post(getUrl(), vendor));
	};

	this.update = function(vendorId, vendor) {
		return($http.put(getUrlForId(vendorId), vendor));
	};

	this.destroy = function(vendorId) {
		return($http.delete(getUrlForId(vendorId)));
	};
});