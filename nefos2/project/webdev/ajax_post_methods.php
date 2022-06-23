<?php
  session_start();
  $oath2token = $_SESSION["token"];

  // SIGNUP CURL REQUEST
  if (isset($_POST["signupAction"])) {

    if ($_POST['signupAction'] == 'signup'){
    
      $form_data = array(
        'name' => $_POST['NAME'],
        'surname' => $_POST['SURNAME'],
        'username' => $_POST['USERNAME'],
        'pwd' => $_POST['PASSWORD'],
        'email' => $_POST['EMAIL'],
        'role' => $_POST['ROLE']     
      );

      $message = json_encode($form_data);

      $api_url ="http://nefosservice-proxy:3051/api/user/create.php";

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

      foreach($result as $keys => $values){

        if ($result[$keys]['message' == 'User Created']) {
          echo 'created';
        }
        else{
          echo 'error';
        }
      }
    }
  }

  // LOGIN CURL REQUEST

  if (isset($_POST["loginAction"])) {

    if ($_POST['loginAction'] == 'login'){
    
      $form_data = array(
        'username' => $_POST['USERNAME'],
        'pwd' => $_POST['PASSWORD'] 
      );

      $message = json_encode($form_data);

      $api_url ="http://nefosservice-proxy:3051/api/user/authenticate.php";

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

      if ($result['message'] == 'User Exists') {

        session_start();
        $_SESSION["id"] = $result['username'];
        $_SESSION["name"] = $result['name'];
        $_SESSION["surname"] = $result['surname'];
        $_SESSION["username"] = $result['username'];
        $_SESSION["role"] = $result['role'];
        $_SESSION["confirmed"] = $result['confirmed'];

        echo 'Log In';
      }
      else{
        echo 'error';
      }
    }
  }

  // ADD MOVIE TO FAVORITES
  if (isset($_POST["addfavAction"])) {

    if ($_POST['addfavAction'] == 'addfav'){

    
      $form_data = array(
        'username' => $_POST['userid'],
        'title' => $_POST['movieid'],
        'cinemaname' => $_POST['cinemanameid'],
        'startdate' => $_POST['orstartdate'],
        'enddate' => $_POST['orenddate']
      );

      $message = json_encode($form_data);

      $api_url ="http://nefosservice-proxy:3051/api/favorite/create.php";

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

      foreach($result as $key) {
        
        if ($key == 'Favorite Created') {
          echo '<p class="success">Added to favorites!</p>';
        }
        elseif ($key == 'Favorite Exists'){
          echo  '<p class="failed">Movie already included in favorites!</p>';
        }
        else {
          echo '<p class="failed">Error!</p>';
        }
      }

    }
  }

  // CREATE MOVIE
  if (isset($_POST["createmovAction"])) {

    if ($_POST['createmovAction'] == 'createmov'){
    
      $form_data = array(
        'title' => $_POST['TITLE'],
        'cinemaname' => $_POST['CINEMANAME'],
        'category' => $_POST['CATEGORY'],
        'startdate' => $_POST['STARTDATE'],
        'enddate' => $_POST['ENDDATE']
      );

      $message = json_encode($form_data);

      $api_url ="http://nefosservice-proxy:3051/api/movie/create.php";

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

      foreach($result as $key){

        if ($key == 'Movie Created') {
          echo 'created';
        }
        else{
          echo 'error';
        }
      }
    }
  }



?>