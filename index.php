
<?php include "includes/header.php"; ?>  <!-- header include file -->
<div ng-app = "studentApp">
<div class="container">

     <div ng-view></div>    <!-- partial pages substituted here -->
  
</div>   <!-- end class= 'container' -->
</div>   <!-- end studentApp -->

<script>
var app = angular.module('studentApp', ['ngRoute']);

app.config(function($routeProvider) {
    $routeProvider 
      .when('/', {
          templateUrl : 'partials/all_students.html',    // route for the home page
          controller : 'allCtrl'
      })
      .when('/all_students', {
          templateUrl : 'partials/all_students.html',
          controller : 'allCtrl'
      })
      .when('/display_gpa', {
          templateUrl : 'partials/display_gpa.html',
          controller : 'gpaCtrl'
      })
      .when('/add_student', {
          templateUrl : 'partials/add_student.html',    // add a student to db
          controller : 'addCtrl'
      })
      .when('/edit_students', {
          templateUrl : 'partials/edit_students.html',    // edit a student record
          controller : 'editCtrl'
      })
      .otherwise({
          redirectTo: 'partials/all_students.html'        // any other URL goes to home
      });
});


          /*   a controller for each page  */
app.controller('allCtrl', function($scope, $http) {
    
   $http.get("getStudentData.php")          // get all the students table
     .then(function (response) {
	    $scope.students = response.data; 

     });
});

app.controller('gpaCtrl', function($scope, $http) {
    
   $http.get("getStudentData.php?sql=gpa")          // get gpa table
     .then(function (response) {
	    $scope.students = response.data;  
     });



});

app.controller('addCtrl', function($scope, $http) {

    $scope.addRecord = function() {       // add a record
        params = "sql=add";          // concatenate name-value pairs
        params += "&sid=" + $scope.sid;
        params += "&first=" + $scope.first_name;
        params += "&last=" + $scope.last_name;
        params += "&completed=" + $scope.hrs_completed;
        params += "&attempted=" + $scope.hrs_attempted;
        params += "&points=" + $scope.gpa_points;
        params += "&major=" + $scope.major;
        params += "&advisor=" + $scope.advisor_id;
        params += "&email=" + $scope.email;

        url = "getStudentData.php?" + params;     // concat GET request

        $http.get(url).then(function (response) {
             $scope.status = response.data;      //get response
        }); 
    };
});

app.controller('editCtrl', function($scope, $http) {  // edit or delete students
   
  
   $scope.getRecord = function() {
    params = "sql=getRecord";
    params += "&sid=" + $scope.sid;

	   url = "getStudentData.php?" + params;

   $http.get(url)
     .then(function (response) {
     	$scope.students = response.data;
        $scope.student = $scope.students[0];

	
     });
   
    }

   $scope.updateRecord = function() {
	   params = "sql=update";
	   
	    params += "&sid=" + $scope.student.student_id;
        params += "&first=" + $scope.student.first_name;
        params += "&last=" + $scope.student.last_name;
        params += "&completed=" + $scope.student.hrs_completed;
        params += "&attempted=" + $scope.student.hrs_attempted;
        params += "&points=" + $scope.student.gpa_points;
        params += "&major=" + $scope.student.major;
        params += "&advisor=" + $scope.student.advisor_id;
        params += "&email=" + $scope.student.email;
	   
	   url = "getStudentData.php?" + params;
	   $http.get(url)
          .then(function (response) {
			 $scope.status = response.data;			
      });
	   
   }
   
   $scope.deleteRecord = function() {
	   params = "sql=delete";
	   params += "&sid=" + $scope.student.student_id;

	   
	   url = "getStudentData.php?" + params;
	   $http.get(url)
          .then(function (response) {
			 $scope.status = response.data;
      });
	  
   };
});
</script>
 <?php include "includes/footer.php"; ?>   <!-- footer include file -->