<?php

  include_once 'header.php';
  include 'includes/dbh_handler.php';

  $temp = 'CinemaOwner';
  //Chech if the user is logged in. Else redirect him to loggin page.
  if (!isset($_SESSION["id"])) {
    header("location: movies.php");
    exit();
  }
  //Check if the user is confirmed by the admin. Else redirect to the welcome page.
  if ($_SESSION["confirmed"] != 1) {
    header("location: welcome.php?error=notConfirmed");
    exit();
  }
  //Give access to this page only if the user has the role of "CinemaOwner". Else redirect him to the welcome page.
  $temp = 'CinemaOwner';
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: movies.php");
    exit();
  }

  $sessid = $_SESSION["id"];
  $sessuser = $_SESSION["username"];

?>


<div class="ownerbody">

  <!--A style div-->
  <section>
    <div class="owner-intro">
      <h1 class="add-introh1">Welcome to the owner interface!</h1>

      <!--BANNER-->
      <div class="banner">
        <img class="banner-image" src="images/lotr.jpg" alt="banner">
      </div>

    <!--A button that triggers a modal popup with js to create a new movie-->
    <button class="addmov-btn" style="vertical-align:middle"><span><a href="#" id="addmovid" class="create-mov">Add Film</a></span></button>
    </div>
  </section>

  <!--The div that contains the modal for the button above-->
  <div class="btn-modal">
    <div class="modal-content">
      <!--A fake button to close the modal with js-->
      <div class="close-tag">+</div>
        <img src="images/movie.svg" class="mov-img" alt="image">

        <!--A form with the new movies details-->
        <form action="includes/owneraddinc.php" method="POST" class="movform">

          <label class="mov-lab">Title</label>
          <input type="text" name="TITLE" class="modal-inputs" placeholder="Movie Title...">
          <label class="mov-lab">Category</label>
          <input type="text" name="CATEGORY" class="modal-inputs" placeholder="Category...">
          <label class="mov-lab">Cinema</label>
          <br>
          <!--A query that finds all the current owner's cinemas for him to choose to add his movie in-->
          <select name="CINEMANAME" id="" value="">

          <?php

            //Find the cinemas by searching the cinemas table for a username identical to the $_SESSION["username"]
            $aquery = "SELECT NAME FROM cinemas WHERE OWNER='$sessuser' ";
            $aquery_run = mysqli_query($conn, $aquery);

            //For every cinema found to be the current owner's create an input option with its name.
            while($arow = mysqli_fetch_assoc($aquery_run) ) {

              $cinename = $arow["NAME"];    

              ?>
              <option class="modal-inputs" value="<?php echo $cinename; ?>"><?php echo $cinename; ?></option>
              <?php
            }

          ?>

          </select>
          <label class="mov-lab">Premiere date</label>
          <input type="date" name="STARTDATE" class="modal-inputsdate" placeholder="Start date...">
          <label class="mov-lab">End date</label>
          <input type="date" name="ENDDATE" class="modal-inputsdate" placeholder="End date...">
          <button type="submit" name="submit" class="btn-addmov">Register Movie</button>

        </form>

    </div>
  </div>

  <br>

<?php

    //Get statements to inform the user if his actions where succesfull or had errors.
    if (isset($_GET["error"])){
      if ($_GET["error"]  == "updatefailed") {
        echo '<p class="failed">Failed to edit movie!</p>';
      }
      else if ($_GET["error"]  == "nonee") {
        echo '<p class="success">Movie edited succesfully!</p>';
      }
      else if ($_GET["error"]  == "deletefailed") {
        echo '<p class="failed">Movie failed to delete!</p>';
      }
      else if ($_GET["error"]  == "noned") {
        echo '<p class="success">Movie deleted!</p>';
      }
      else if ($_GET["error"]  == "emptyInput") {
        echo '<p class="failed">Error occured fill the form correctly!</p>';
      }
      else if ($_GET["error"]  == "nonec") {
        echo '<p class="success">Movie created succesfully!</p>';
      }
      else if ($_GET["error"]  == "stmt2failed") {
        echo '<p class="success">Error occured!</p>';
      }
    }

?>

<!--The main body to display the owner's movies--->
<div class="browse-body">
  <h1 class="browseH">My movies</h1>
  <hr class="hrlineo">

  <div class="movies-body">

  <?php
    //Find the current username with from his id.
    $query = "SELECT USERNAME FROM users WHERE ID='$sessid' ";
    $query_run = mysqli_query($conn, $query);

    //If he is found find his cinemas
    if (mysqli_num_rows($query_run) > 0) {

      $row1 = mysqli_fetch_assoc($query_run);
      $ownername = $row1["USERNAME"];

      //Show all the cinema names from the cinema table that belong to the user by checking the OWNER field with the username.
      $query1 = "SELECT NAME FROM cinemas WHERE OWNER='$ownername' ";
      $query_run1 = mysqli_query($conn, $query1);

      //If he finds cinemas that belong to him
      if (mysqli_num_rows($query_run1) > 0) {

        //For every cinema
        while($row2 = mysqli_fetch_assoc($query_run1) ) {

          $cineNm = $row2["NAME"];
          $query2 = "SELECT * FROM movies WHERE CINEMANAME='$cineNm' ";
          $query_r2 = mysqli_query($conn, $query2);

          //For every movie that has its CINEMANAME field the same as the query from above.
          while($row3 = mysqli_fetch_assoc($query_r2)) {

            ?>

            <!--For every movie found create a custom border displaying it's data-->
            <div class="movie-border">

              <div class="movie-itemt">
                <h5 class="mtitle-textt"><?php echo $row3["TITLE"];?></h5>
              </div>

              <div class="movie-item">
              <h5 class="mcinemaname-text"><?php echo $row3["CINEMANAME"];?></h5>
              </div>

              <div class="movie-item">
              <h5 class="mcategory-text"><?php echo $row3["CATEGORY"];?></h5>
              </div>

              <div class="movie-item">
              <h5 class="mstartdate-text"><?php echo $row3["STARTDATE"];?></h5>
              </div>

              <div class="movie-item">
              <h5 class="menddate-text"><?php echo $row3["ENDDATE"];?></h5>
              </div>

              <div>

                <!--A form with two buttons that let's the owner edit or delete the movie-->
                <form action="updatemovie.php" method="post" class="formfav">
                  <input type="hidden" name="movieid" value="<?php echo $row3["ID"]; ?>">
                  <button type="submit" name="update-btn" class="fav-btn"><i class="material-icons favicon">create</i></button>
                  <button type="submit" name="deleteMov-btn" formaction="includes/deleteMovinc.php" class="fav-btn"><i class="material-icons favicon">delete_forever</i></button>  
                </form>

              </div>

            </div>

            <?php
          }
        }
      }
      else {
        echo 'There are no movies in your cinema...';
      }
    }
    else {
      echo 'There are no cinemas in your name...';
    }
  ?>

<script src="js/createmovie.js"></script>
</div>

<?php
  include_once 'footer.php';
?>