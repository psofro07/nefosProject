<?php 
session_start();
$oath2token = $_SESSION["token"];

$username = $_POST['userid'];
$title = $_POST['movieid'];
$cinemaname = $_POST['cinemanameid'];
$id = $title.$cinemaname.$username;
$id = preg_replace('/\s+/', '', $id);

$api_curl = "http://nefosservice-proxy:3051/api/orion/delete_alert.php?username=".$username."&title=".$title."";

$client = curl_init($api_curl);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($client, CURLOPT_HTTPHEADER, array(
  'X-Auth-Token: '.$oath2token.''
));

$response = curl_exec($client);
curl_close($client);
$result = json_decode($response);


?>