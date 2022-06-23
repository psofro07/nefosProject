<?php

session_start();
$oath2token = $_SESSION["token"];

$username = $_POST['userid'];
$title = $_POST['movieid'];
$cinemaname = $_POST['cinemanameid'];
$startdate = $_POST['orstartdate'];
$enddate = $_POST['orenddate'];
$id = $title.$cinemaname.$username;
$id = preg_replace('/\s+/', '', $id);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://orion-proxy:1027/v2/subscriptions/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "description": "Update user on changes made for this movie",
  "subject": {
      "entities": [
          {
              "id": "'.$id.'",
              "type": "Movie"
          }
      ],
      "condition": {
          "attrs": [
              "startdate",
              "enddate"
          ]
      }
  },
  "notification": {
      "http": {
          "url": "http://nefosservice-proxy:3051/api/orion/create.php"
      },
      "attrs": []
  },
  "expires": "2040-01-01T14:00:00.00Z",
  "throttling": 3
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'X-Auth-Token: '.$oath2token.'',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


?>