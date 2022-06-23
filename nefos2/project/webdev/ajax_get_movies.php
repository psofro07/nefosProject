<?php
session_start();
$oath2token = $_SESSION["token"];

  if (isset($_GET['search-val']) || isset($_GET['parameter']) || isset($_GET['startdate']) || isset($_GET['enddate']) || isset($_GET['search-btn'])) {

    $search = $_GET['search-val'];
    $param = $_GET['parameter'];
    $startdate = $_GET['startdate'];
    $enddate = $_GET['enddate'];
    

    $api_curl = "http://nefosservice-proxy:3051/api/movie/search.php?search=".$search."&param=".$param."&startdate=".$startdate."&enddate=".$enddate."";

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
                      <input type="hidden" name="orstartdate" value="'.$doc['startdate'].'">
                      <input type="hidden" name="orenddate" value="'.$doc['enddate'].'">
                      <input type="hidden" name="addfavAction" value="addfav">
                      <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
                    </form>
                  </div>

                </div>';

        };
      }

      echo $output;

    }
    else {
      $output .= '<h1 class="browseHs"> No movies fit the search criteria!</h1>';
    }

  } 
  else {

    $api_curl = "http://nefosservice-proxy:3051/api/movie/get_all.php";

    $client = curl_init($api_curl);

    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($client, CURLOPT_HTTPHEADER, array(
      'X-Auth-Token: '.$oath2token.''
    ));
    
    $response = curl_exec($client);

    //curl_setopt($client, CURLOPT_URL, $api_curl);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  
    //var_dump($response);
    //var_dump(json_decode($response));
    //var_dump(json_last_error());
    //var_dump(json_last_error_msg());

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
                      <input type="hidden" name="orstartdate" value="'.$doc['startdate'].'">
                      <input type="hidden" name="orenddate" value="'.$doc['enddate'].'">
                      <input type="hidden" name="addfavAction" value="addfav">
                      <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
                    </form>
                  </div>

                </div>';

        };
      }

      echo $output;

    }
    else {
      $output .= '<h1 class="browseHs">No movies were found in the database!</h1>';
    }
  }
    
    

?>