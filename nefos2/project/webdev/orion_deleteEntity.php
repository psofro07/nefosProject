<?php

session_start();
$oath2token = $_SESSION["token"];

$username = $_POST['userid'];
$title = $_POST['movieid'];
$cinemaname = $_POST['cinemanameid'];
$id = $title.$cinemaname.$username;
$id = preg_replace('/\s+/', '', $id);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://orion-proxy:1027/v2/entities/".$id."?type=Movie",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'DELETE',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'X-Auth-Token: '.$oath2token.''
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>