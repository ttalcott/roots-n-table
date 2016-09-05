// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller: 'homeController',
			templateUrl: 'angular/views/home.php'
		})

		// route for the about page
		.when('/about', {
			controller: 'aboutController',
			templateUrl: 'angular/views/about.php'
		})

		// route for the contact page
		.when('/contact', {
			controller: 'contactController',
			templateUrl: 'angular/views/contact.php'
		})

		// route for the education page
		.when('/education', {
			controller: 'educationController',
			templateUrl: 'angular/views/education.php'
		})

		// route for the solutions page
		.when('/solutions', {
			controller: 'solutionsController',
			templateUrl: 'angular/views/solutions.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});