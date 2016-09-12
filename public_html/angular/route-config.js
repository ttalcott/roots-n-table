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

		// route for the contact page
		.when('/contact', {
			controller: 'contactController',
			templateUrl: 'angular/pages/contact.php'
		})

		// route for the shop page
		.when('/shop', {
			controller: 'productsController',
			templateUrl: 'angular/pages/shop.php'
		})

		// route for the sign up/in page
		.when('/signup', {
			controller: 'signupController',
			templateUrl: 'angular/pages/signup.php'
		})

		// route for the vendors page
		.when('/products/vendor/:vendorName', {
			controller: 'productsController',
			templateUrl: 'angular/pages/category.php'
		})

		// route for the category page
		.when('/products/category/:categoryName', {
			controller: 'productsController',
			templateUrl: 'angular/pages/category.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});