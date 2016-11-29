<?php
$link = mysqli_connect('localhost', 'root', '', 'coc')
    or die('No se pudo conectar: ' . mysql_error());

$query = "SELECT * FROM players WHERE Left_On IS NULL";
$playersDB = mysqli_query($link, $query);

$return_arr = array();

while ($row = mysqli_fetch_array($playersDB)) {
  $row_array['tag'] = $row['Tag'];
  $row_array['name'] = $row['Name'];
  $row_array['th'] = $row['Town_Hall'];
  $row_array['donations'] = $row['Donations'];
  $row_array['donationsReceived'] = $row['Donations_Received'];
  $row_array['joinedOn'] = $row['Joined_On'];
  array_push($return_arr,$row_array);
}

mysqli_close($link);
/*$clanMembers = callAPIClanMembers()['items'];
foreach ($clanMembers as $key => $clanMember) {
  $th = getMemberInfo(substr($clanMembers[$key]["tag"],1));
  $clanMembers[$key]["th"] = $th;
}*/
header('Content-type:application/json;charset=utf-8');
exit(json_encode($return_arr));
?>
