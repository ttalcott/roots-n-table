// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller: 'homeController',
			templateUrl: 'angular/pages/home.php'
		})

		// route for the about page
		.when('/about', {
			controller: 'aboutController',
			templateUrl: 'angular/pages/about.php'
		})

		// route for the cart page
		.when('/cart', {
			controller: 'cartController',
			templateUrl: 'angular/pages/cart.php'
		})

		// route for the categories page
		.when('/categories', {
			controller: 'categoriesController',
			templateUrl: 'angular/pages/categories.php'
		})

		// route for the categoryfoo page
		.when('/category-foo', {
			controller: 'categoryfooController',
			templateUrl: 'angular/pages/category-foo.php'
		})

		// route for the shop page
		.when('/shop', {
			controller: 'shopController',
			templateUrl: 'angular/pages/shop.php'
		})

		// route for the sign up/in page
		.when('/signup', {
			controller: 'signupController',
			templateUrl: 'angular/pages/signup.php'
		})

		// route for the vendor foo page
		.when('/vendorfoo', {
			controller: 'vendorfooController',
			templateUrl: 'angular/pages/vendor-foo.php'
		})

		// route for the vendors page
		.when('/vendors', {
			controller: 'vendorsController',
			templateUrl: 'angular/pages/vendors.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});