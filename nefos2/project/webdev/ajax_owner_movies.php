<?php
  session_start();

  $username = $_SESSION['username'];
  $oath2token = $_SESSION["token"];

  $api_curl = "http://nefosservice-proxy:3051/api/movie/get_all_owner.php?username=".$username."";

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
        <div class="movie-border">

              <div class="movie-itemt">
                <h5 contenteditable="false" class="mtitle-textt letitle">'.$doc['title'].'</h5>
              </div>

              <div class="movie-item">
              <h5 contenteditable="false" class="mcinemaname-text lecinem">'.$doc['cinemaname'].'</h5>
              </div>

              <div class="movie-item">
              <h5 contenteditable="false" class="mcategory-text lecat">'.$doc['category'].'</h5>
              </div>

              <div class="movie-item">
              <h5 contenteditable="false" class="mstartdate-text lestart">'.$doc['startdate'].'</h5>
              </div>

              <div class="movie-item">
              <h5 contenteditable="false" class="menddate-text leend">'.$doc['enddate'].'</h5>
              </div>

              <div>

                <!--A form with two buttons that lets the owner edit or delete the movie-->
                <form action="ajax_ownerEdit.php" method="post" class="formfav">
                  <input type="hidden" name="userid" value="'.$_SESSION['username'].'">
                  <input type="hidden" name="movieid" value="'.$doc['title'].'">
                  <input type="hidden" name="cinemanameid" value="'.$doc['cinemaname'].'">
                  <input type="hidden" name="categoryid" value="'.$doc['category'].'">
                  <input type="hidden" name="startdateid" value="'.$doc['startdate'].'">
                  <input type="hidden" name="enddateid" value="'.$doc['enddate'].'">
                  <input type="hidden" name="updtAction" value="updt">
                  <button type="submit" name="update-btn" class="fav-btn btnedit"><i class="material-icons favicon">create</i></button>
                  <button type="submit" name="deleteMov-btn" class="fav-btn btndl"><i class="material-icons favicon">delete_forever</i></button>  
                </form>

              </div>

            </div>';
      }
    }

  }
  else {
    $output .=  '<h1 class="browseHs">No movies are at your ownership!</h1>';
  }
  echo $output;