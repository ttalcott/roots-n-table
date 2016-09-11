module.service('Product', ['$scope', function($scope){
	var service = {
			products: [
				{
					name: 'Corn',
					description:'Yellow Corn'
				},
				{
					name:'Apples',
					description:'Red Apples'
				},
				{
					name:'Kale',
					description:'Green Kale'
				}
			],
	};
}]);