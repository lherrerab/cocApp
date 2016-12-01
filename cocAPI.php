<?php
  $username = "your_name";
  $password = "your_password";
  $hostname = "localhost";

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  @$service = $request->service;

  if(!empty($service)){
	  if($service == "getClanInfo"){
      getClanInfo();
    }
    if($service == "getClanMembers"){
      getClanMembers();
    }
    if($service == "getClanTable"){
      getClanTable();
    }
    if($service == "updateMembers"){
      updateMembers();
    }
   if($service == "saveWarMembers"){
     saveWarMembers();
   }
   if($service == "getWarMembers"){
     getWarMembers();
   }
   if($service == "changeColor"){
     changeColor();
   }
  }

  updateMembers();
  function updateMembers(){
    $clanMembers = callAPIClanMembers()['items'];

    $link = mysqli_connect('localhost', 'root', '', 'coc')
        or die('No se pudo conectar: ' . mysql_error());

    foreach ($clanMembers as $key => $clanMember) {
      $th = getMemberInfo(substr($clanMembers[$key]["tag"],1));
      $clanMembers[$key]["th"] = $th;

      $query = "INSERT INTO players(Tag, Name, Role, Town_Hall, Donations,Donations_Received, Joined_On) VALUES ('".$clanMembers[$key]['tag']."','".str_replace("'","",$clanMembers[$key]['name'])."','".$clanMembers[$key]['role']."',".$clanMembers[$key]['th'].",".$clanMembers[$key]['donations'].",".$clanMembers[$key]['donationsReceived'].",NOW())";
      $result = mysqli_query($link, $query);

      if(!$result) {
        echo $clanMembers[$key]["name"].' --- '.$clanMembers[$key]["tag"].' --- OLD - <br>';
        $query = "UPDATE players SET Town_Hall=".$clanMembers[$key]['th'].",Donations_Received= ".$clanMember['donationsReceived'].",Donations = ".$clanMember['donations'].", Left_On = NULL WHERE Tag='".$clanMember['tag']."'";
        mysqli_query($link, $query);
      }
      else {
        echo $clanMembers[$key]["name"].' --- '.$clanMembers[$key]["tag"].' --- NEW - <br>';
      }
    }

    $query = "SELECT * FROM players WHERE Left_On IS NULL";
    $playersDB = mysqli_query($link, $query);

    while($i =  mysqli_fetch_array($playersDB)){
      $flag = false;

      foreach ($clanMembers as $key => $clanMember) {
        if(strcmp($clanMember['tag'], $i['Tag']) === 0){
          $flag = true;
          break;
        }
      }

      if(!$flag){
        echo $i["Name"].' --- '.$i["Tag"].' --- LEFT - <br>';
        $query = "UPDATE players SET Left_On = NOW() WHERE Tag='".$i['Tag']."'";
        mysqli_query($link, $query);
      }

    }

    mysqli_close($link);
  }

  function getClanMembers(){
    $response = callAPIClanMembers();
		deliver_response(200, "Done", $response['items']);
  }

  function changeColor(){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$params = $request->params;
    @$color = $request->color;

    $link = mysqli_connect('localhost', 'root', '', 'coc')
        or die('No se pudo conectar: ' . mysql_error());

    foreach ($params as $key => $param) {
      $query = "UPDATE players SET Color_Flag = '".$color."' WHERE Tag ='".$param."'";
      mysqli_query($link, $query);
    }

    getClanTable();

  }

  function saveWarMembers(){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$params = $request->params;

    $link = mysqli_connect('localhost', 'root', '', 'coc')
        or die('No se pudo conectar: ' . mysql_error());

    $query = "UPDATE players SET War_Flag=FALSE";
    mysqli_query($link, $query);

    foreach ($params as $key => $param) {
      $query = "UPDATE players SET War_Flag = TRUE WHERE Tag ='".$param->tag."'";
      $playersDB = mysqli_query($link, $query);
    }

    exit(json_encode("DONE"));
  }

  function getWarMembers(){
    $link = mysqli_connect('localhost', 'root', '', 'coc')
        or die('No se pudo conectar: ' . mysql_error());

    $query = "SELECT * FROM players WHERE War_Flag=TRUE && Left_On IS NULL";
    $playersDB = mysqli_query($link, $query);
    $return_arr = array();

    while ($row = mysqli_fetch_array($playersDB)) {
      $row_array['tag'] = $row['Tag'];
      $row_array['name'] = $row['Name'];
      $row_array['th'] = $row['Town_Hall'];
      array_push($return_arr,$row_array);
    }

    mysqli_close($link);
    header('Content-type:application/json;charset=utf-8');
    exit(json_encode($return_arr));
  }

  function callAPIClanMembers(){
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImExZWEzNWY5LTczYTMtNDY3YS05YjQ3LThhYjMyODFlY2RhOSIsImlhdCI6MTQ4MDM0NDU1Mywic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2IiwiMjAwLjEyMi4yMDMuMyIsIjE4NS4yNy4xMzQuMjI5IiwiMTg1LjI3LjEzNC42NCJdLCJ0eXBlIjoiY2xpZW50In1dfQ.SXrAMIfcgLr5gAvxCiEmtfOYQKNolfGxNJqtW9Kb-7T5isPDyZn2WS--X660bIaK7p31sRCYM1c-jHXtC4tAGA';
    //$api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImZkMGUwMjMxLTM5OWEtNDc2YS04YzA0LTg5ZWIxNThjNWM3ZiIsImlhdCI6MTQ3OTk1MDM3OCwic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2Il0sInR5cGUiOiJjbGllbnQifV19.G0OM2-cs8D-MfzF5riiteDuS5HhMw-S9RBLLpKB7K1u1rxdCxAHnYpAjHGOxvL3iNych617q8bsURVHagjfOGQ';
    $url = 'https://api.clashofclans.com/v1/clans/%23GYCRYVYL/members';
    $var_cntr = 0;
    $var_s_no = 1;
    $headers = array(
      "Accept: application/json",
      "Authorization: Bearer " . $api_key
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $result = curl_exec($ch);
    $response = json_decode($result,true);

    curl_close($ch);

    return $response;
  }

  function getMemberInfo($tagMember){
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImExZWEzNWY5LTczYTMtNDY3YS05YjQ3LThhYjMyODFlY2RhOSIsImlhdCI6MTQ4MDM0NDU1Mywic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2IiwiMjAwLjEyMi4yMDMuMyIsIjE4NS4yNy4xMzQuMjI5IiwiMTg1LjI3LjEzNC42NCJdLCJ0eXBlIjoiY2xpZW50In1dfQ.SXrAMIfcgLr5gAvxCiEmtfOYQKNolfGxNJqtW9Kb-7T5isPDyZn2WS--X660bIaK7p31sRCYM1c-jHXtC4tAGA';
    $url = "https://api.clashofclans.com/v1/players/%23".$tagMember;
    $var_cntr = 0;
    $var_s_no = 1;
    $headers = array(
      "Accept: application/json",
      "Authorization: Bearer " . $api_key
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $result = curl_exec($ch);
    $response = json_decode($result,true);

    curl_close($ch);

		return $response["townHallLevel"];
  }

	function getClanInfo(){
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImExZWEzNWY5LTczYTMtNDY3YS05YjQ3LThhYjMyODFlY2RhOSIsImlhdCI6MTQ4MDM0NDU1Mywic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2IiwiMjAwLjEyMi4yMDMuMyIsIjE4NS4yNy4xMzQuMjI5IiwiMTg1LjI3LjEzNC42NCJdLCJ0eXBlIjoiY2xpZW50In1dfQ.SXrAMIfcgLr5gAvxCiEmtfOYQKNolfGxNJqtW9Kb-7T5isPDyZn2WS--X660bIaK7p31sRCYM1c-jHXtC4tAGA';
    $url = 'https://api.clashofclans.com/v1/clans?name=%23GYCRYVYL';
    $var_cntr = 0;
    $var_s_no = 1;
    $headers = array(
      "Accept: application/json",
      "Authorization: Bearer " . $api_key
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    $result = curl_exec($ch);
    $response = json_decode($result,true);

    curl_close($ch);

		deliver_response(200, "Done", $response['items']);
	}

  function getClanTable(){
    $link = mysqli_connect('localhost', 'root', '', 'coc')
        or die('No se pudo conectar: ' . mysql_error());

    $query = "SELECT * FROM players WHERE Left_On IS NULL";
    $playersDB = mysqli_query($link, $query);

    $return_arr = array();

    while ($row = mysqli_fetch_array($playersDB)) {
      $row_array['tag'] = $row['Tag'];
      $row_array['name'] = $row['Name'];
      $row_array['th'] = $row['Town_Hall'];
      $row_array['role'] = $row['Role'];
      $row_array['donations'] = $row['Donations'];
      $row_array['donationsReceived'] = $row['Donations_Received'];
      $row_array['joinedOn'] = $row['Joined_On'];
      $row_array['color'] = $row['Color_Flag'];
      array_push($return_arr,$row_array);
    }

    mysqli_close($link);
    header('Content-type:application/json;charset=utf-8');
    exit(json_encode($return_arr));
  }

	function deliver_response($status, $status_message, $data){

		header("HTTP/1.1 $status $status_message");

		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data']= $data;

		$json_response = json_encode($response);
		echo $json_response;
	}
?>
