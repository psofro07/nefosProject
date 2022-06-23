<?php
  session_start();
  if($_SESSION['role'] == 'CinemaOwner'){

    $username = $_SESSION['username'];
    $oath2token = $_SESSION["token"];

    $api_curl = "http://nefosservice-proxy:3051/api/user/get_cinema.php?username=".$username."";

    $client = curl_init($api_curl);

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($client, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oath2token.''
    ));
      
    $response = curl_exec($client);

    curl_close($client);
    $result = json_decode($response, true);

    echo $result['CINEMANAME'];

  }