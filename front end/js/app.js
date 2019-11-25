var app=angular.module("MainModule", ['ngRoute','LoginModule', 'RegisterModule', 'PostsModule', 'RoutingModule', 'ProfileModule', 'UploadModule']);
app.controller("mainController", ['$rootScope',function($rootScope){
	$rootScope.divValue=1;
	$rootScope.loginLoaded=false;
	$rootScope.regLoaded=false;
	$rootScope.loginCounter=0;
	$rootScope.regCounter=0;
	
	
}]);
app.directive("loginDirective", function(){
	return{
		restrict: 'E',
		templateUrl:'pages/login-directive.html'
	}	
});
app.directive("registerDirective", function(){
	return{
		restrict: 'E',
		templateUrl:'pages/register-directive.html'
	}	
});