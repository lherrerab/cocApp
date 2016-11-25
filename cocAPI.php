<?php
    header("Content-Type:application/json");

    if(!empty($_GET['service'])){
    	$service = 	$_GET['service'];

		if($service == "getClanInfo"){
			getClanInfo();
		}

    if($service == "getClanMembers"){
      getClanMembers();
    }

    if($service == "getClanTable"){
      getClanTable();
    }
	}

  function getClanMembers(){
    $response = callAPIClanMembers();
		deliver_response(200, "Done", $response['items']);
  }

  function callAPIClanMembers(){
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImZkMGUwMjMxLTM5OWEtNDc2YS04YzA0LTg5ZWIxNThjNWM3ZiIsImlhdCI6MTQ3OTk1MDM3OCwic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2Il0sInR5cGUiOiJjbGllbnQifV19.G0OM2-cs8D-MfzF5riiteDuS5HhMw-S9RBLLpKB7K1u1rxdCxAHnYpAjHGOxvL3iNych617q8bsURVHagjfOGQ';
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
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImZkMGUwMjMxLTM5OWEtNDc2YS04YzA0LTg5ZWIxNThjNWM3ZiIsImlhdCI6MTQ3OTk1MDM3OCwic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2Il0sInR5cGUiOiJjbGllbnQifV19.G0OM2-cs8D-MfzF5riiteDuS5HhMw-S9RBLLpKB7K1u1rxdCxAHnYpAjHGOxvL3iNych617q8bsURVHagjfOGQ';
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
    $api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImZkMGUwMjMxLTM5OWEtNDc2YS04YzA0LTg5ZWIxNThjNWM3ZiIsImlhdCI6MTQ3OTk1MDM3OCwic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2Il0sInR5cGUiOiJjbGllbnQifV19.G0OM2-cs8D-MfzF5riiteDuS5HhMw-S9RBLLpKB7K1u1rxdCxAHnYpAjHGOxvL3iNych617q8bsURVHagjfOGQ';
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
    $clanMembers = callAPIClanMembers()['items'];
    foreach ($clanMembers as $key => $clanMember) {
      $th = getMemberInfo(substr($clanMembers[$key]["tag"],1));
      $clanMembers[$key]["th"] = $th;
    }
    deliver_response(200, "Done", $clanMembers);
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
