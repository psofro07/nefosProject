<?php

include_once 'includes/funcs.php';

if (isset($_POST["loginAction"])) {

  if ($_POST['loginAction'] == 'login'){

    $email = $_POST['USERNAME'];
    $password = $_POST['PASSWORD'];

    /***************************ACQUIRE X-AUTH-TOKEN WITH ADMIN DATA***************************/

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 1);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"name\": \"admin@test.com\",
      \"password\": \"1234\"
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json"
    ));

    $response = curl_exec($ch);  
     
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $data = http_parse_headers($header);
    $xtoken = $data['X-Subject-Token'];

    /**********************************AUTHENTICATE USER AND GENERATE TOKEN****************************/

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://keyrock:3005/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'grant_type=password&username='.$email.'&password='.$password.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic YWVlZDllN2EtYzRlZS00OGNiLWIyMmEtYTU2MGRlZDAyZTFiOjg1MmY3ZWZhLWYxMGQtNDM1Yy1iOTY4LTBlNzc5MWUzODJkYQ=='
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result1 = json_decode($response);

    if ( $result1 != "Invalid grant: user credentials are invalid") {

      /************************ACQUIRE USERNAME********************************/

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://keyrock:3005/v1/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          "X-Auth-Token: ".$xtoken.""
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      //echo $response;
      $result = json_decode($response, true);

      foreach($result as $key){
        foreach($key as $doc){

          if($doc['email'] == $email){
            $userid = $doc['id'];
            $username = $doc['username'];
          }

        }
      }

      /***************************ACQUIRE ROLE ***************************/

      $appID = "aeed9e7a-c4ee-48cb-b22a-a560ded02e1b";
      $roleUserID = "afe0b7c8-1431-451d-8a79-0d1ed201cc42";
      $roleCinemaOwnerID = "55e55c74-cfc4-4175-98d3-e976ec349594";

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/".$appID."/users/".$userid."/roles");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);

      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-token: ".$xtoken.""
      ));

      $response = curl_exec($ch);
      curl_close($ch);
      $result = json_decode($response, true);
      
      foreach($result as $key){
        foreach($key as $doc){
          $role = $doc['role_id'];
        }
      }

      if ($role == $roleUserID) {
        $role = "User";
      }
      elseif ($role == $roleCinemaOwnerID) {
        $role = "CinemaOwner";
      }

      session_start();
      $_SESSION["token"] = $result1->access_token;
      $_SESSION["id"] = $username;
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;
      $_SESSION["role"] = $role;
     
      echo 'Log In';
    }
    else {
      echo 'error';
    }

  }
}