<?php

  include_once 'header.php';
  $temp = 'User';

  //Chech if the user is logged in. Else redirect him to loggin page.
  if (!isset($_SESSION["id"])) {
    header("location: index.php?error=notloggedin");
    exit();
  }
  //Check if the user is confirmed by the admin. Else redirect to the welcome page.
  if ($_SESSION["confirmed"] != 1) {
    header("location: welcome.php?error=notConfirmed");
    exit();
  }
  //Give access to this page only if the user has the role of "user". Else redirect him to the welcome page.
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: welcome.php?error=notUserOwner");
    exit();
  }
  include 'includes/dbh_handler.php';
  $sessid = $_SESSION["id"];

?>

<!--Banner-->
<div class="banner">
  <img class="banner-image" src="images/inception.jpg" alt="banner">
</div>

<!--Browse headline--> 
<div class="browse-body">
  <h1 class="browseH">Browse favorites</h1>
  <hr class="brlineh">
</div>

<!--Body displaying all the movies-->
<div class="movies-body">

  <?php

    //Find all the movies that are added in favorite by the current user by searching the favorite table with the $_SESSION("id") in USERID field.
    $query = "SELECT MOVIEID FROM favorites WHERE USERID='$sessid' ";
    $query_run = mysqli_query($conn, $query);

    //If the user has favorite movies display them
    if (mysqli_num_rows($query_run) > 0) {

      //A loop for every favorite movie found for the current user.
      while($rowF = mysqli_fetch_assoc($query_run) ){

        //Access the movie's information by searching the movie based on the Id of the movie.
        $movID = $rowF["MOVIEID"];
        $query = "SELECT * FROM movies WHERE ID='$movID' ";
        $query_r = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($query_r);

        ?>

        <!--Display every movie with its own border in a big div-->
        <div class="movie-border">

          <div class="movie-itemt">
            <h5 class="mtitle-textt"><?php echo $row["TITLE"];?></h5>
          </div>

          <div class="movie-item">
          <h5 class="mcinemaname-text"><?php echo $row["CINEMANAME"];?></h5>
          </div>

          <div class="movie-item">
          <h5 class="mcategory-text"><?php echo $row["CATEGORY"];?></h5>
          </div>

          <div class="movie-item">
          <h5 class="mstartdate-text"><?php echo $row["STARTDATE"];?></h5>
          </div>

          <div class="movie-item">
          <h5 class="menddate-text"><?php echo $row["ENDDATE"];?></h5>
          </div>

          <div>
            <!--Create a div that contains a form with a button to delete the movie from favorites-->
            <form action="includes/removfavinc.php" method="post" class="formfav">
              <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
              <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
              <button type="submit" name="removfav-btn" class="fav-btn"><i class="material-icons favicon">remove_circle</i></button>
            </form>
          </div>

        </div>

        <?php

      }
    }
    else {
      echo '<br>Movies favorites table is empty';
    }

  ?>

</div>

<?php
  include_once 'footer.php';
?>