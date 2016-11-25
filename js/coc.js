angular.module('cocApp', [])
.factory('callService',function($http, $q){
  return {
    getData: function(url) {
      return new Promise(function(resolve, reject) {
        var xmlRequest = new XMLHttpRequest();
        xmlRequest.open('GET', url);
        xmlRequest.onload = function() {
          if(xmlRequest.status == 200) {
            resolve(xmlRequest.response);
          }
          else {
            reject(Error(xmlRequest.statusText));
          }
        };
        xmlRequest.onerror = function() {
          reject(Error("Network Error"));
        };
        xmlRequest.send();
      });
    }
  }
})
.controller('mainCtrl', function($scope, callService){

  $scope.var = "Hello!";
  $scope.members = [{name:'Leo'}];

  $scope.receiveClanTable = function () {
    $scope.members = [{name:'Dante'}];
    var params = "service=getClanTable";
    console.log('receiving...');
    var url = 'http://localhost/CoC/cocAPI.php?'+params;
    callService.getData(url).then(function(response) {
      $scope.members =(JSON.parse(response)).data;
      console.log($scope.members);
    },function(error) {
      console.log(error);
    });
  }

  $scope.receiveClanTable();

});


/*function sendRequest(conf) {
    return new Promise(function(resolve, reject) {
      var xmlRequest = new XMLHttpRequest();
      xmlRequest.open('GET', conf.url);

      xmlRequest.onload = function() {
        if(xmlRequest.status == 200) {
          resolve(xmlRequest.response);
        }
        else {
          reject(Error(xmlRequest.statusText));
        }
      };

      xmlRequest.onerror = function() {
        reject(Error("Network Error"));
      };

      xmlRequest.send();
    });
}

function showMembers(){
  console.log(members);
  var allMembers = members.data;
  for(i = 0; i < allMembers.length; i++) {
    tr = document.createElement("tr");
    //for(j = 0; j < allMembers[i].length; j++) {
      td = document.createElement("td");
      text = document.createTextNode(allMembers[i].tag);
      td.appendChild(text);
      tr.appendChild(td);
    }
    table.appendChild(tr);
  }
  divTable.appendChild(table);
}

function receiveClanInfo() {
  var params = "service=getClanInfo";
  sendRequest({url:'http://localhost/CoC/cocAPI.php?'+params}).then(function(response) {
    var jSONResponse =JSON.parse(members);
    console.log(jSONResponse);
  },function(error) {
    console.log(error);
  });
}

function receiveClanMembers() {
  var params = "service=getClanMembers";
  sendRequest({url:'http://localhost/CoC/cocAPI.php?'+params}).then(function(response) {
    var jSONResponse =JSON.parse(response);
    console.log(jSONResponse);
  },function(error) {
    console.log(error);
  });
}

function receiveClanTable() {
  var params = "service=getClanTable";
  console.log('receiving...');
  sendRequest({url:'http://localhost/CoC/cocAPI.php?'+params}).then(function(response) {
    members =JSON.parse(response);
    showMembers();
  },function(error) {
    console.log(error);
  });
}

receiveClanTable();*/
