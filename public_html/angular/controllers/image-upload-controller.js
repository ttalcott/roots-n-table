//inject directives and services.
var app = angular.module('imageUpload', ['ngImageUpload']);

app.controller('MyCtrl', ['$scope', 'Upload', function ($scope, Upload) {
	// upload later on form submit or something similar
	$scope.submit = function() {
		if($scope.form.image.$valid && $scope.image) {
			$scope.upload($scope.image);
		}
	};

	// upload on image select or drop
	$scope.upload = function(image) {
		Upload.upload({
			url: 'upload/url',
			data: {image: image, 'username': $scope.username}
		}).then(function(resp) {
			console.log('Success ' + resp.config.data.image.name + 'uploaded. Response: ' + resp.data);
		}, function(resp) {
			console.log('Error status: ' + resp.status);
		}, function(evt) {
			var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
			console.log('progress: ' + progressPercentage + '% ' + evt.config.data.image.name);
		});
	};
}]);