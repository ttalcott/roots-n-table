app.controller("signupController", ["$scope", "$window", "signupService", function($scope, $window, SignupService) {
	$scope.signupData = {"firstname": [], "lastname": [], "username": [], "email": [],"password": null, "confirmPassword": null};
	$scope.alerts = [];

	//Method that uses the sign up service to activate an account

	$scope.submit = function(signupData, validated) {
		if(validated === true) {
			SignupService.signupData(SignupData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						location.url("/signin");
					} else {
						console.log(result.data.message);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);