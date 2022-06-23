<?php
  session_start();
  $oath2token = $_SESSION["token"];

  if(isset( $_POST['updtAction'] )){

    if($_POST['updtAction'] == 'updt'){

      $form_data = array(
        'title' => $_POST['title'],
        'cinemaname' => $_POST['cinemaname'],
        'category' => $_POST['category'],
        'startdate' => $_POST['startdate'],
        'enddate' => $_POST['enddate'],
        'oldtitle' => $_POST['oldtitle']
      );

      $message = json_encode($form_data);

      $api_url ="http://nefosservice-proxy:3051/api/movie/update.php";

      $client = curl_init($api_url);

      curl_setopt($client, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Auth-Token: '.$oath2token.'','Content-Length: ' . strlen($message)));
      curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($client, CURLOPT_POSTFIELDS,$message);
      curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($client);
      curl_close($client);
      $result = json_decode($response, true);

      foreach($result as $key) {
        if ($key == 'Movie Updated') {
          echo '<p class="success">Movie edited successfully!</p>';
        }
        else {
          echo '<p class="failed">Error!</p>';
        }
      }  

    }

  }

?>
