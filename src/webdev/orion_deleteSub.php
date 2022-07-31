<?php
session_start();
$oath2token = $_SESSION["token"];


$username = $_POST['userid'];
$title = urlencode($_POST['movieid']);
$cinemaname = $_POST['cinemanameid'];
//$id = $title.$cinemaname.$username;
//$id = preg_replace('/\s+/', '', $id);

$api_curl = "http://nefosservice-proxy:3051/api/favorite/get_single.php?username=".$username."&title=".$title."&cinemaname=".$cinemaname."";

$client = curl_init($api_curl);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($client, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oath2token.''
));

$response = curl_exec($client);
curl_close($client);
$result = json_decode($response, true);

foreach($result as $key){
  $subID = $key;
//echo $subID;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://orion-proxy:1027/v2/subscriptions/".$subID."",
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