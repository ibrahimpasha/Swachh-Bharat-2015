angular.module("UploadModule", ["google-maps"])
.controller("uploadController", ['$rootScope', '$scope','$http','$timeout', function($rootScope, $scope, $http, $timeout){
		$scope.scopephone=$rootScope.jsonData[0].phone;
		$scope.scopecounter=$rootScope.jsonData[0].counter;
	$scope.uploadDesc = function(title, desc, lat, lon, vol, budget){
		var image_name=$rootScope.jsonData[0].phone+"_image_"+$rootScope.jsonData[0].counter+".jpg";
		
		var uploadDescJson={"title":title, "description":desc, "latitude":lat, "longitude":lon, "vol":vol, "funds":budget, "name":$rootScope.jsonData[0].name,
			"email":$rootScope.jsonData[0].email, "image_name":image_name};
		console.log(uploadDescJson);
		$http.post("http://ibbu.in/swachhbharat/back/description.php", uploadDescJson)
		.success(function(data){
			console.log(data);
			$rootScope.uploadJsonData=data;
		})
		.error(function(status){
			console.log(status);
		})
	}

}])