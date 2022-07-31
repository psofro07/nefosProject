<?php
// applicationID: aeed9e7a-c4ee-48cb-b22a-a560ded02e1b roleUSERID: afe0b7c8-1431-451d-8a79-0d1ed201cc42  roleCinemaOwnerID: 55e55c74-cfc4-4175-98d3-e976ec349594
//base64() = aeed9e7a-c4ee-48cb-b22a-a560ded02e1b:852f7efa-f10d-435c-b968-0e7791e382da
// orgID: ba199274-a1ac-4b94-9ffb-8a554c096964
include_once 'includes/funcs.php';

//if (isset($_POST["signupAction"])) {

//  if ($_POST['signupAction'] == 'signup'){
  
    /*$form_data = array(
      'username' => $_POST['USERNAME'],
      'pwd' => $_POST['PASSWORD'],
      'email' => $_POST['EMAIL'],
      'role' => $_POST['ROLE']     
    );*/

    /*$username = $_POST['USERNAME'];
    $password = $_POST['PASSWORD'];
    $email = $_POST['EMAIL'];
    $role = $_POST['ROLE'];*/

    $username = "testuser";
    $password = "123";
    $email = "testuser@mail.com";
    $role = "User";

    /*****************ACQUIRE X-Auth-Token*****************/

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

    /********************** Create User *********************/

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/users");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"user\": {
        \"username\": \"".$username."\",
        \"email\": \"".$email."\",
        \"password\": \"".$password."\"
      }
    }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Auth-token: ".$xtoken.""
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    /******************** Find the created user's ID**********************/

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

        if($doc['username'] == $username && $doc['email'] == $email){
          $userid = $doc['id'];
        }

      }
    }

    /************************* ASSIGN ORGANIZATION ROLE IN ORGANIZATION SitesUsers***********************/

    $appID = "aeed9e7a-c4ee-48cb-b22a-a560ded02e1b";
    $orgID = "ba199274-a1ac-4b94-9ffb-8a554c096964";
    $roleUserID = "afe0b7c8-1431-451d-8a79-0d1ed201cc42";
    $roleCinemaOwnerID = "55e55c74-cfc4-4175-98d3-e976ec349594";

    if($role == "User"){

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, "http://keyrock:3005/v1/applications/".$appID."/users/721a1db3-61cc-46fa-b10a-096345bec15e/roles");
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
          echo $doc['role_id'];
        }
      }

    }
    else {

      

    }

    

    







    /*$message = json_encode($form_data);

    $api_url ="http://nefosservice/api/user/create.php";

    $client = curl_init($api_url);

    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, $message);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

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
    }*/
 // }
//}
