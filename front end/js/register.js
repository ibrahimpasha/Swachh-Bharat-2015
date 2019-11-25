angular.module("RegisterModule", ['PostsModule'])
.controller("registerController", ['$rootScope', '$scope', '$http', '$timeout', '$location', function($rootScope, $scope, $http, $timeout, $location){
	$scope.setDiv = function(arg){
		$rootScope.divValue=arg;
	}
	$scope.register=function(){
		var sendJson={email: $scope.email_id, uname:$scope.name, counter:0,
		password: $scope.password, phone: $scope.phone, gender:$scope.value, profile_pic:$scope.phone+"_profile.png"};
		
		
		//$http.post("http://swachhbharat.ibbu.in/back/register.php", {email: $scope.email_id, uname:$scope.name, counter:0,
		//password: $scope.password, phone: $scope.phone, gender:$scope.value, profile_pic:$scope.phone+"_profile.png"})
		$http({method:'POST', url:'http://ibbu.in/swachhbharat/back/register1.php', data: sendJson})
		.success(function(data, status){
			console.log(data);
			$timeout(afterTime, 1000);
			$rootScope.registerData = data;
			$rootScope.jsonData=data;
			
		})
		.error(function(data, status){
			console.log(data);
		});
		
		function afterTime(){
			if($rootScope.registerData[0].status==1){
			$rootScope.regLoaded = true;
			$location.path('/home');
		}
		else
			$rootScope.regLoaded = false;
			$rootScope.regCounter=2;
		}
		
	}
}]);