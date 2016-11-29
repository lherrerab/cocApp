angular.module('cocApp')
.controller('mainCtrl', function($scope, $http){

  $scope.warMembers = [];
  $scope.boxUpdates = [];

  $scope.addWarMember = function(tag,player,th){
    var warMember = {'tag':tag,'name':player,'th':th};
    $scope.warMembers.push(warMember);
  }

  $scope.removeWarMember = function(index){
      $scope.warMembers.splice(index,1);
  }

  $scope.getWarMembers = function() {
    var url = 'http://localhost/CoC/cocAPI.php';
    var data = { service:'getWarMembers'};
    var config = {headers: {
     'Content-Type': 'application/x-www-form-urlencoded'
     }};

    $http.post(url,data,config)
    .then(function(response) {
      $scope.warMembers = response.data;
    },
    function(error) {
      console.log(error);
    });
  }

  $scope.saveWar = function(){
    console.log($scope.warMembers);
    var url = 'http://localhost/CoC/cocAPI.php';
    var data = { service:'saveWarMembers',params: $scope.warMembers };
    var config = {headers: {
     'Content-Type': 'application/x-www-form-urlencoded'
     }};

    $http.post(url,data,config)
      .then(function(response) {
        console.log(response);
      },
      function(error) {
        console.log(error);
      });
  }

  $scope.createWar = function(){
    if(confirm("Do you want to create a war?")) {
      console.log("Created");
    }
  }

  $scope.cancelWar = function(){
    if(confirm("Do you want to delete candidates?")) {
      $scope.warMembers = [];
    }
  }

  $scope.updateFlags = function(value){
    //console.log($scope.updateSelected);
    console.log(value);
    /*if ($scope.updateSelected=="3") {

    }*/
  }

  $scope.updateMembers = function() {
    var url = 'http://localhost/CoC/cocAPI.php';
    var data = { service:'updateMembers'};
    var config = {headers: {
     'Content-Type': 'application/x-www-form-urlencoded'
     }};

    $http.post(url,data,config)
        .then(
          function(response) {
            console.log(response);
          },
          function(error) {
            console.log(error);
          }
        );
  }

  $scope.receiveClanTable = function () {
    var url = 'http://localhost/CoC/cocAPI.php';
    var data = { service:'getClanTable'};
    var config = {headers: {
     'Content-Type': 'application/x-www-form-urlencoded'
     }};

    $http.post(url,data,config)
        .then(
          function(response) {
            console.log(response.data);
            $scope.members = response.data;
          },
          function(error) {
            console.log(error);
          }
        );
  }

  $scope.receiveClanTable();
  $scope.getWarMembers();

});
