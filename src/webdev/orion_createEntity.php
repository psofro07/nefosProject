<?php
session_start();
$oath2token = $_SESSION["token"];

$title = $_POST['movieid'];
$cinemaname = $_POST['cinemanameid'];
$startdate = $_POST['orstartdate'];
$enddate = $_POST['orenddate'];
$username = $_POST['userid'];
$id = $title.$cinemaname.$username;
$id = preg_replace('/\s+/', '', $id);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://orion-proxy:1027/v2/entities',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "id": "'.$id.'",
    "type": "Movie",
    "movie": {
        "value": "'.$title.'",
        "type": "text"
    },
    "startdate": {
        "value": "'.$startdate.'",
        "type": "Date"
    },
    "enddate": {
        "value": "'.$enddate.'",
        "type": "Date"
    },
    "user": {
        "value": "'.$username.'",
        "type": "text"
    }  
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
