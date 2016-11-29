<?php
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$params = $request->jwt;

$link = mysqli_connect('localhost', 'root', '', 'coc')
    or die('No se pudo conectar: ' . mysql_error());

foreach ($params as $key => $param) {
  $query = "UPDATE players SET War_Flag = TRUE WHERE Tag ='".$param->tag."'";
  $playersDB = mysqli_query($link, $query);
}

exit(json_encode("DONE"));

/*$api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImZkMGUwMjMxLTM5OWEtNDc2YS04YzA0LTg5ZWIxNThjNWM3ZiIsImlhdCI6MTQ3OTk1MDM3OCwic3ViIjoiZGV2ZWxvcGVyLzZiNzkxNDJlLTViZGMtZTVmNi0wNjJlLTM4NDhjOTlhMWJjOCIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjIwMS4yMzMuMTQ4LjI2Il0sInR5cGUiOiJjbGllbnQifV19.G0OM2-cs8D-MfzF5riiteDuS5HhMw-S9RBLLpKB7K1u1rxdCxAHnYpAjHGOxvL3iNych617q8bsURVHagjfOGQ';
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

exit $response;*/
 ?>
