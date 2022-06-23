<?php

  include_once 'header.php';

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
  //Give access to this page only if the user has the role of "User". Else redirect him to the welcome page.
  $temp = 'User';
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: welcome.php?error=notUserOwner");
    exit();
  }
  
  include_once 'includes/dbh_handler.php';

  //If the user didn't accessed this site by the searching form.
  if( (!isset($_POST['search-btn'])) ) {

    ?>
    
    <!--BANNER-->
    <div class="banner">
    <img class="banner-image" src="images/potter.jpg" alt="banner">
    </div>

    <br>
    <br>

    <?php

    //Get statements to inform the user if his actions where succesfull or had errors.
    if (isset($_GET["error"])){

      if ($_GET["error"]  == "alreadyFav") {
        echo '<p class="failed">Movie already included in favorites!</p>';
      }
      else if ($_GET["error"]  == "none") {
        echo '<p class="success">Added to favorites!</p>';
      }

    }

    ?>

    <!--Browse Styling div-->
    <div class="browse-body">
      <div class="browdiv">
        <h1 class="browseHs">Browse movies</h1>
        <hr class="brline">
      </div>
    </div>

    <!--A form for the search bar menu to search movies-->
    <div class="outerbox">
      <div class="insidebox">

        <form action="movies.php" method="POST">
          <input type="search" name="search-val" placeholder="&#xf002 Search for a movie then hit enter..." class="srf" >
          <select name="parameter" id="" class="param">
            <optgroup label="Search by:">
              <option value="Title">Title</option>
              <option value="Category">Category</option>
              <option value="CinemaOwner">Cinema Owner</option>
              <option value="Date">Date</option>
            </optgroup>
          </select>
          <label for="datestart" class="datelabl">Start date:</label>
          <input type="date" name="datestart" class="dateinp">
          <label for="dateend" class="datelabl">End date:</label>
          <input type="date" name="dateend" class="dateinp">
          <button type="submit" name="search-btn" class="srch"></button>
        </form>

      </div>
    </div>

    <div class="movies-body">

      <?php

        //Find all the movies in the movies table
        $query = "SELECT * FROM movies";
        $query_run = mysqli_query($conn, $query);

        //If the are movies
        if (mysqli_num_rows($query_run) > 0) {

          //For every movie in movies
          while($row = mysqli_fetch_assoc($query_run) ){

          ?>

            <!--Display the movie in its own custom border-->
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
                <!--A form that has button to let the user add the movie to his favourite list-->
                <form action="includes/addfavinc.php" method="post" class="formfav">
                  <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
                  <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
                  <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
                </form>
              </div>

            </div>

          <?php

          }
        }
        else {
          echo 'Movies table is empty';
        }
  ?>

</div>

<?php

}
//If the user accessed this page from the search button
else {

  //Retrieve the search parameters
  $search= $_POST['search-val'];
  $param = $_POST['parameter'];
  $datestart = $_POST['datestart'];
  $dateend = $_POST['dateend'];

  ?>
  <div class="banner">
    <img class="banner-image" src="images/potter.jpg" alt="banner">
  </div>

  <!--Same code as before-->
  <div class="browse-body">
    <div class="browdiv">
      <h1 class="browseHs">Browse movies</h1>
      <hr class="brline">
    </div>
  </div>

  <!--Search form-->
  <div class="outerbox">
    <div class="insidebox">
      <form action="movies.php" method="POST">
        <input type="search" name="search-val" placeholder="&#xf002 Search for a movie then hit enter..." class="srf" >
        <select name="parameter" id="" class="param">
          <optgroup label="Search by:">
            <option value="Title">Title</option>
            <option value="Category">Category</option>
            <option value="CinemaOwner">Cinema Owner</option>
            <option value="Date">Date</option>
          </optgroup>
        </select>
        <label for="datestart" class="datelabl">Start date:</label>
        <input type="date" name="datestart" class="dateinp">
        <label for="dateend" class="datelabl">End date:</label>
        <input type="date" name="dateend" class="dateinp">
        <button type="submit" name="search-btn" class="srch"></button>
      </form>
    </div>
  </div>
  

  <div class="movies-body">

  <?php

    //If he did not enter any search parameters display all the movies
    if (empty($search) && $param != 'Date'){
      header("Location: movies.php?nosearch");
    }
    //Search by title
    elseif (!empty($search) && $param == 'Title') {

      $query = "SELECT * FROM movies WHERE TITLE LIKE '%{$search}%' ";
      $query_run = mysqli_query($conn, $query);

      if (mysqli_num_rows($query_run) > 0) {

        while($row = mysqli_fetch_assoc($query_run) ){

          ?>

        <div class="movie-border">
          <div class="movie-item">
            <h5 class="mtitle-text"><?php echo $row["TITLE"];?></h5>
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
            <form action="includes/addfavinc.php" method="post" class="formfav">
              <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
              <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
              <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
            </form>
        </div>
        </div>

          <?php

        }
      }
      else {
        echo 'No movies found with those parameters!';
      }
    
    }
    //Search by category
    elseif (!empty($search) && $param == 'Category'){

      $query = "SELECT * FROM movies WHERE CATEGORY LIKE '%{$search}%' ";
      $query_run = mysqli_query($conn, $query);

      if (mysqli_num_rows($query_run) > 0) {

        while($row = mysqli_fetch_assoc($query_run) ){

          ?>

        <div class="movie-border">
          <div class="movie-item">
            <h5 class="mtitle-text"><?php echo $row["TITLE"];?></h5>
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
            <form action="includes/addfavinc.php" method="post" class="formfav">
              <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
              <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
              <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
            </form>
        </div>
        </div>

          <?php

        }
      }
      else {
        echo 'No movies found with those parameters!';
      }

    }
    //Search by cinema owner like owner.php
    elseif (!empty($search) && $param == 'CinemaOwner'){

      $query = "SELECT NAME FROM cinemas WHERE OWNER LIKE '%{$search}%' ";
      $query_run1 = mysqli_query($conn, $query);

      if (mysqli_num_rows($query_run1) > 0) {

        while($row2 = mysqli_fetch_assoc($query_run1) ) {

          $cineNm = $row2["NAME"];
          $query2 = "SELECT * FROM movies WHERE CINEMANAME='$cineNm' ";
          $query_r2 = mysqli_query($conn, $query2);

          while($row3 = mysqli_fetch_assoc($query_r2)) {

            ?>

            <div class="movie-border">
              <div class="movie-item">
                <h5 class="mtitle-text"><?php echo $row3["TITLE"];?></h5>
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
              <form action="includes/addfavinc.php" method="post" class="formfav">
                      <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
                      <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
                      <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
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
    //Search by date
    elseif ($param == 'Date') {

      $query = "SELECT * FROM movies WHERE STARTDATE = '$datestart' OR ENDDATE = '$dateend'";
      $query_run = mysqli_query($conn, $query);

      if (mysqli_num_rows($query_run) > 0) {

        while($row = mysqli_fetch_assoc($query_run) ){

          ?>

          <div class="movie-border">
            <div class="movie-item">
              <h5 class="mtitle-text"><?php echo $row["TITLE"];?></h5>
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
              <form action="includes/addfavinc.php" method="post" class="formfav">
                <input type="hidden" name="userid" value="<?php echo $_SESSION["id"]; ?>">
                <input type="hidden" name="movieid" value="<?php echo $row["ID"]; ?>">
                <button type="submit" name="addfav-btn" class="fav-btn"><i class="material-icons favicon">favorite_border</i></button>
              </form>
            </div>
          </div>

          <?php

        }
      }
      else {
        echo 'No movies found with those parameters!';
      }
    
    }
    ?>
  

</div>

<!---------------------------------------------------END BODY----------------------------------------------------------- -->
  <?php
}
?>

<?php
include_once 'footer.php';
?>
