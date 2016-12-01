angular.module('cocApp',[])
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

  $scope.updateCheckBoxes = function(value){
    var flag = false;

    for (var i = 0; i < $scope.boxUpdates.length; i++) {
      if($scope.boxUpdates[i] == value){
        flag = true;
        break;
      }
    }

    if(!flag){
      $scope.boxUpdates.push(value);
    }
    else{
      $scope.boxUpdates.splice(i,1);
    }
  }

  $scope.updateFlags = function(){
    if ($scope.updateSelected ==="#FF4F46" || $scope.updateSelected ==="#F1FF23" || $scope.updateSelected ==="#FFFFFF") {
      var url = 'http://localhost/CoC/cocAPI.php';
      var data = { service:'changeColor',params: $scope.boxUpdates, color: $scope.updateSelected};
      var config = {headers: {
       'Content-Type': 'application/x-www-form-urlencoded'
       }};

      $http.post(url,data,config)
        .then(function(response) {
          $scope.members = response.data;
          $scope.boxUpdates = [];
        },
        function(error) {
          console.log(error);
        });
    }
  }

  $scope.updateFlag = function(tag,color){
    $scope.updateSelected = color;
    $scope.boxUpdates.push(tag);
    console.log($scope.boxUpdates);
    $scope.updateFlags();
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
