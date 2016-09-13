app.controller('categoryController', ["$scope", "CategoryService", function($scope, CategoryService) {
	$scope.categories = [];
	/**
	 * fulfills the promise from retrieving the categories from category API
	 **/
	$scope.getCategories = function() {
		CategoryService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.categories = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	// load the array on first view
	if($scope.categories.length === 0) {
		$scope.categories = $scope.getCategories();
	}

}]);