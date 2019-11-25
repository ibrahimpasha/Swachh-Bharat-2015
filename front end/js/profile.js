angular.module("ProfileModule", [])
.controller("profileController", ['$scope', '$rootScope', '$http','$timeout',function($scope, $rootScope, $http, $timeout){
		// change password
		$rootScope.pchanged=false;
		$scope.changePassword = function(){
			var url="http://ibbu.in/swachhbharat/back/change_password.php";
		sendProfileJson = {"email":$rootScope.jsonData[0].email, "old_password":$scope.old_password, "new_password":$scope.new_password };
		$http.post(url, sendProfileJson)
		.success(function(data){
			$rootScope.changeData=data;
			$timeout(passwordTime, 1000);
			console.log(data);	
		})
		.error(function(data, status){
			
		});
		}
		
		function passwordTime(){
			if($rootScope.changeData[0].status==1){
				$rootScope.pchanged=true;
			}
			else
			 	$rootScope.pchanged=false;
		}
}]);