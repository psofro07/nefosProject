

<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CinemaFrontier</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <!-- NAVBAR -->
  <ul class="Navbar">

    <div class="logo">

      <?php
      //If the user clicks the logo redirect him according to his logged in status.
      if (!isset($_SESSION["id"])) {
        echo '<a href="index.php">CinemaFrontier</a>';
      }
      else {
        echo '<a href="welcome.php">CinemaFrontier</a>';
      }
      ?>

    </div>
    
    <!-- Unordered List of items. The navbar changes depending on the logged in status. If he is logged in show the dropdown menu with the services -->
    <div class="navbar">
    <?php
      if (isset($_SESSION["id"])) {
        echo '<div class=dropdown>
                <button class="dropbtn">Services
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                  <a href="administration.php">Admin Database</a>
                  <a href="owner.php">Movies</a>
                  <a href="favorites.php">Favorites</a>
                </div>
              </div>';

        echo '<li><a href="#">About</a></li>';
        echo '<li><a href="includes/signoutinc.php">Sign Out</a></li>';
        echo '<li class="loggedUser">' . $_SESSION["email"] . " (" . $_SESSION["role"] . ")" . '<i class="material-icons md-18 userIcon" >account_circle</i></li>';
      }
      else {
        echo '<li class="nonav"><a href="signup.php">Sign up</a></li>';
        echo '<li class="nonav"><a href="index.php">Sign In</a></li>';
        echo '<li class="nonav"><a href="#">About</a></li>';
      }
    ?>
    </div>
  </ul>

<div class="wrapper">