<?php 
  session_start();
  $oath2token = $_SESSION["token"];

  if(isset($_SESSION['username'])){

    $username = $_SESSION['username'];

    $api_curl = "http://nefosservice-proxy:3051/api/orion/get_subAlert.php?username=".$username."";

    $client = curl_init($api_curl);

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($client, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oath2token.''
    ));
    
    $response = curl_exec($client);

    curl_close($client);
    $result = json_decode($response, true);
    $output="";

    if(array_key_exists("data",$result)){

      foreach($result as $key){
        foreach($key as $doc){

          $output.='<tr><td class="movieAlert"><span class="dot"></span>Time window for '.$doc['title'].' has been changed to:<span class="alertDates">&emsp;Stard Date &#8594; '.$doc['startdate'].' &ensp;|&ensp; End Date &#8594; '.$doc['enddate'].'</span></td></tr>';

        }
      }

    }
    else {
      $output='';
    }

    echo $output;


  }


?>