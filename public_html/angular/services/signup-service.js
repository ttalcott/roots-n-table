app.constant("SIGNUP_ENDPOINT", "php/apis/signup/");
app.service("signupService", function($http, SIGNUP_ENDPOINT) {
	function getUrl() {
		return(SIGNUP_ENDPOINT);
	}
	this.signup = function(signup) {
		return($http.post(getUrl(), signup));
	};
});