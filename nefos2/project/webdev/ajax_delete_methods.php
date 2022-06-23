<?php
  session_start();
  $oath2token = $_SESSION["token"];

  if(isset($_POST['remfavAction'])) {
    
    if($_POST['remfavAction'] == 'remfav'){

      $username = urlencode($_POST['userid']);
      $title = urlencode($_POST['movieid']);
      $cinemaname = urlencode($_POST['cinemanameid']);
      
      $api_curl = "http://nefosservice-proxy:3051/api/favorite/delete.php?username=".$username."&title=".$title."&cinemaname=".$cinemaname."";

      $client = curl_init($api_curl);

      curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($client, CURLOPT_HTTPHEADER, array(
        'X-Auth-Token: '.$oath2token.''
      ));
    
      $response = curl_exec($client);
      curl_close($client);
      $result = json_decode($response);

      foreach($result as $key) {
       
        if ($key == 'Favorite Deleted') {
          echo '<p class="success">Deleted from favorites!</p>';
        }
        else {
          echo '<p class="failed">Error!</p>';
        }
      }  

    }

  }

  if(isset($_POST['btndlt'])) {

    $form_data = array(
      'title' => $_POST['title'],
      'cinemaname' => $_POST['cinemaname']
    );

    $message = json_encode($form_data);
    
    $api_curl = "http://nefosservice-proxy:3051/api/movie/delete.php";

    $client = curl_init($api_curl);

    curl_setopt($client, CURLOPT_POSTFIELDS,$message);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($client, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oath2token.''
    ));
  
    $response = curl_exec($client);
    curl_close($client);
    $result = json_decode($response, true);

    foreach($result as $key) {
      if ($key == 'Movie Deleted') {
        echo '<p class="success">Movie Deleted!</p>';
      }
      else {
        echo '<p class="failed">Deletion failed!</p>';
      }
    }  
    
  }