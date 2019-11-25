angular.module('RoutingModule', [])
.config(function($routeProvider){
	$routeProvider
	.when('/home', {
		templateUrl: 'pages/posts.html',
		controller:'postsController'
	})
	.when('/about', {
		templateUrl: 'pages/about.html'
	})
	.when('/profile', {
		templateUrl: 'pages/profile.html'
	})
	.when('/upload', {
		templateUrl: 'pages/upload.html'
	})
})