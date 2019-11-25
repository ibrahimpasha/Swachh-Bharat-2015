angular.module("LoginModule", ['PostsModule'])
.controller('loginController', ['$scope', '$rootScope', '$http', '$location','$timeout',function($scope, $rootScope, $http, $location, $timeout){
	
		$scope.setDiv = function(arg){
			$rootScope.divValue=arg;
		}
		$scope.sendLogin= function(){
		//var sendJson=JSON.stringify({email_id:$scope.username, password:$scope.pass});
		var sendJson={"email_id":$scope.email_id, "password":$scope.password};
		$http({method: 'POST', url:'http://ibbu.in/swachhbharat/back/login.php', data:sendJson}).success(function(data){
		$rootScope.jsonData = data;
		console.log(data);
		$timeout(loginTime, 1000);
		
		
	})
	.error(function(data, status){
		$scope.status = status;
		
	});
	}
	function loginTime(){
		if($rootScope.jsonData[0].status==1){
			$rootScope.loginLoaded = true;
			$rootScope.loginCounter=1;
			$location.path('/home');
		}
		else{
			$rootScope.loginLoaded = false;
			$rootScope.loginCounter=2;
		}
	}
}]);