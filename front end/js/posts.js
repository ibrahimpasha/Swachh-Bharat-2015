angular.module('PostsModule',["google-maps"])
.controller('postsController', ['$scope', '$rootScope', '$http', '$timeout',function($scope, $rootScope, $http, $timeout){
	var sendJson={"latitude":"0.0", "longitude":"0.0", "phone":$rootScope.jsonData[0].phone};
	$scope.loaded1 = true;
	$rootScope.userJoined=false;
	$rootScope.eventCreated = false;
	$rootScope.eventData;
	$http({method: 'POST', url:'http://ibbu.in/swachhbharat/back/send_desc.php', data:sendJson}).success(function(data){
		$scope.loaded1 = true;
		console.log(data);
		$timeout( timeOutOne, 1000);
		
	})
	.error(function(data, status){
		$scope.status = status;
		$scope.loaded1 = false;
	});
	
	function timeOutOne(){
	if($scope.loaded1){
		//$timeout(1000);
		url = "http://ibbu.in/swachhbharat/back/json/"+$rootScope.jsonData[0].phone+".json";
		$http.post(url)
		.success(function(data){
			$scope.posts = data;
			console.log(data);
		})
		.error(function(data, status){
			console.log("Not loaded");
		});
		
	}
	else
	{
		console.log("Unable to load");
	}
	}
	//Create Event function
	$scope.createEventFunction = function(event_name, event_date, event_budget, ename, eemail, etitle){
		var sendEventJson={"event_name":event_name, "event_date":event_date, "event_budget":event_budget, "event_created_by":ename, "email":eemail, "title":etitle};
		
		$http({method: 'POST', url:'http://ibbu.in/swachhbharat/back/create_event.php', data:sendEventJson})
		.success(function(data){
		$rootScope.eventData = data;
		$timeout(eventTime, 1000);
		console.log(data);
		
	})
	.error(function(data, status){
		$scope.status = status;
	});
	}
	function eventTime(){
		if($rootScope.eventData[0].status==1){
			$rootScope.eventCreated = true;
		}
		else
		{
			$rootScope.eventCreated = false;
		}
	}
	//join event function
	$scope.joinEventFunction = function(jename, jeby, jname, jphone, jemail){
		var sendJoinJson={"name":jname, "phone":jphone, "email_id":jemail, "event_name":jename, "event_by":jeby};
		$http({method: 'POST', url:'http://ibbu.in/swachhbharat/back/join_event.php', data:sendJoinJson})
		.success(function(data){
		$rootScope.joinedData = data;
		$timeout(joinerTimeout, 1000);
		console.log(data);
		
	})
	.error(function(data, status){
		$scope.status = status;
	});
	
	function joinerTimeout(){
		if($rootScope.joinedData[0].status==1){
			$rootScope.userJoined=true;
		}
		else
			$rootScope.userJoined=false;
	}
	}
}])