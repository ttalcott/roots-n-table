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
			templateUrl: 'angular/pages/products.php'
		})

		// route for the sign up/in page
		.when('/signup', {
			controller: 'signupController',
			templateUrl: 'angular/pages/signup.php'
		})

		// route for the vendors page
		.when('/vendor', {
			controller: 'vendorController',
			templateUrl: 'angular/pages/vendor.php'
		})

		// route for the category page
		.when('/category', {
			controller: 'categoryController',
			templateUrl: 'angular/pages/vendor.php'
		})

		// route for the product page
		.when('/product', {
			controller: 'productsController',
			templateUrl: 'angular/pages/products.php'
		})

		// route for the cart
		.when('/cart', {
			controller: 'cartController',
			templateUrl: 'angular/pages/cart.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});
