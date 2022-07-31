<?php

session_start();
$oath2token = $_SESSION["token"];

$title = $_POST['oldtitle'];
$cinemaname = $_POST['cinemaname'];
$id = $title.$cinemaname;
$id = preg_replace('/\s+/', '', $id);

$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

$form_data = array(
  'title' => $title,
  'cinemaname' => $cinemaname
);

$message = json_encode($form_data);

$api_url ="http://nefosservice-proxy:3051/api/orion/get_subs.php";

$client = curl_init($api_url);

curl_setopt($client, CURLOPT_POST, true);
curl_setopt($client, CURLOPT_POSTFIELDS, $message);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
curl_setopt($client, CURLOPT_HTTPHEADER, array(
  'X-Auth-Token: '.$oath2token.''
));

$response = curl_exec($client);
curl_close($client);
$result = json_decode($response, true);

if(!array_key_exists('message', $result)){

  foreach($result as $key){

    foreach($key as $doc){

      //echo $doc['username'].$doc['subID'];
      $id = $title.$cinemaname.$doc['username'];
      $id = preg_replace('/\s+/', '', $id);

      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://orion-proxy:1027/v2/entities/".$id."/attrs",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'PATCH',
      CURLOPT_POSTFIELDS =>'{
        "enddate": {
          "type": "Date",
          "value": "'.$enddate.'"  
        },
        "movie": {
            "type": "text",
            "value": "'.$title.'"           
        },
        "startdate": {
          "type": "Date",
          "value": "'.$startdate.'"        
        }
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'X-Auth-Token: '.$oath2token.''
      ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo $response;


    }

  }
}



?>