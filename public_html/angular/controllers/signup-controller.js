app.controller("signupController", ["$scope", "signupService", function($scope, signupService) {
	$scope.signupData = {
		"profileFirstName": null,
		"profileLastName": null,
		"profileUserName": null,
		"profileEmail": null,
		"password": null,
		"confirmPassword": null,
		"profileType":"u",
		"profileAddressLineOne": null,
		"profileAddressCity": null,
		"profileAddressState": null,
		"profileCountry": null,
		"profileAddressZip": null,
		"profilePhone": null,
		"profileDobDay": "01",
		"profileDobMonth": "01",
		"profileDobYear": "1900",
		"profileBusinessOrIndividual": "b",
		"profileBankAccountNumber": null,
		"profileBankRoutingNumber": null
	};
	$scope.alerts = [];

	$scope.toggleProfileType = function(){
		if ($scope.signupData.profileType === "u"){
			$scope.signupData.profileType = "f";
		}else{
			$scope.signupData.profileType = "u";
		}
	};
	//Method that uses the sign up service to activate an account
	$scope.submit = function(signupData, validated) {
		if(validated === true) {
			signupService.signup(signupData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						location.url("/signup");
					} else {
						console.log(result.data.message);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);