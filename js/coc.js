angular.module('cocApp', [])
.controller('mainCtrl', function($scope, $http){

  $scope.warMembers = [];

  $scope.addWarMember = function(player,th){
    var warMember = {'name':player,'th':th};
    $scope.warMembers.push(warMember);
  }

  $scope.removeWarMember = function(index){
    $scope.warMembers.splice(index,1);
  }

  $scope.receiveClanTable = function () {
    var params = "service=getClanTable";
    var url = 'http://localhost/CoC/cocAPI.php?'+params;
    /*$scope.members = [
        {
          clanRank: 1,
          donations: 1713,
          donationsReceived: 606,
          name: "JuanDa",
          role: "leader",
          th: 9
        },
        {
          clanRank: 2,
          donations: 586,
          donationsReceived: 60,
          name: "king frankie",
          role: "member",
          th: 9
        },
        {
          clanRank:3,
          donations:961,
          donationsReceived:459,
          name:"Dreymax",
          role:"coLeader",
          th:7
        },
        {
          clanRank:4,
          donations:218,
          donationsReceived:41,
          name:"⏪Blade⏩",
          role:"admin",
          th:9
        },
        {
          clanRank:5,
          donations:24,
          donationsReceived:191,
          name:"THE PRINCE",
          role:"member",
          th:8
        },
        {
          clanRank:6,
          donations:22,
          donationsReceived:50,
          name:"Zekrom",
          role:"member",
          th:8
        },
        {
          clanRank:7,
          donations:130,
          donationsReceived:147,
          name:"Abejorge",
          role:"member",
          th:9
        },
        {
          clanRank:8,
          donations:488,
          donationsReceived:499,
          name:"theking",
          role:"admin",
          th:8
        }];*/
    $http.get(url)
        .then(
          function(response) {
            console.log(response);
            $scope.members = response.data.data;
          },
          function(error) {
            console.log(error);
          }
        );
  }

  $scope.receiveClanTable();

});
