<?php
  session_start();

  $username = $_SESSION['username'];
  $oath2token = $_SESSION["token"];

  $api_curl = "http://nefosservice-proxy:3051/api/favorite/get_all.php?username=".$username."";

  $client = curl_init($api_curl);

  curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($client, CURLOPT_HTTPHEADER, array(
    'X-Auth-Token: '.$oath2token.''
  ));
    
  $response = curl_exec($client);

  curl_close($client);
  $result = json_decode($response, true);
  $output="";

  if (count($result) > 0) {
      
      
    foreach($result as $key) {
      foreach($key as $doc){
      
        $output .='
          <!--Display the movie in its own custom border-->
          <div class="movie-border">

            <div class="movie-itemt">
              <h5 class="mtitle-textt">'.$doc['title'].'</h5>
            </div>

            <div class="movie-item">
            <h5 class="mcinemaname-text">'.$doc['cinemaname'].'</h5>
            </div>

            <div class="movie-item">
            <h5 class="mcategory-text">'.$doc['category'].'</h5>
            </div>

            <div class="movie-item">
            <h5 class="mstartdate-text">'.$doc['startdate'].'</h5>
            </div>

            <div class="movie-item">
            <h5 class="menddate-text">'.$doc['enddate'].'</h5>
            </div>

            <div>
              <!--A form that has button to let the user add the movie to his favourite list-->
              <form action="ajaxMovieFav.php" method="post" class="formfav">
                <input type="hidden" name="userid" value="'.$_SESSION['username'].'">
                <input type="hidden" name="movieid" value="'.$doc['title'].'">
                <input type="hidden" name="cinemanameid" value="'.$doc['cinemaname'].'">
                <input type="hidden" name="remfavAction" value="remfav">
                <button id="btn<?= $i ?>" type="submit" name="removfav-btn" class="fav-btn"><i class="material-icons favicon">remove_circle</i></button>
              </form>
            </div>

          </div>';
      }
    }

  }
  else {
    $output .=  '<h1 class="browseHs">No favorites were found in the database!</h1>';
  }

  echo $output;

