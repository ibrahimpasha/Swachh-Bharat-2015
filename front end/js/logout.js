angular.module("LogoutModule", [])
.controller("logoutController", ['$rootScope', '$scope',function($rootScope, $scope){
	$rootScope.loginLoaded = false;
	$rootScope.regLoaded=false;
}]);