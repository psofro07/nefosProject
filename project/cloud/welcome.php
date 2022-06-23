<?php
  include_once 'header.php';
  //Allow access only if logged in.
  if (!isset($_SESSION["id"])) {
    header("location: index.php?error=notloggedin");
    exit();
  }

?>

  <!-- BANNER -->
  <div class="banner">
    <img class="banner-image" src="images/blade.jpg" alt="banner">
  </div>

  <!-- SERVICES -->
  <div class="Heading">Cinema Frontier</div>

  <?php
    //Get statements to inform the user if his actions where succesfull or had errors.
    if (isset($_GET["error"])){

      if ($_GET["error"]  == "notConfirmed") {
        echo '<p class="failed">You are not confirmed by admin to use the services!</p>';
      }
      else if ($_GET["error"]  == "notUserOwner") {
        echo '<p class="failed">You are not a user or an owner to access this service!</p>';
      }
      else if ($_GET["error"]  == "notAdmin") {
        echo '<p class="failed">Only the admin has access to the admin table!</p>';
      }

    }

  ?>

  <!-- Some divs with some information and links for the webpages of the site. Introductory information. -->
  <div align="center" class="services">

    <div class="service1">
      <h1>Browse movies</h1>
      <a href="movies.php"><img class="image-serv" src="images/browse.png" alt="Movies"></a>
      <p>As a user, browse all the newly released and upcoming movies that are playing in cinemas!</p>
    </div>

    <div class="service1">
      <h1>Favorite List</h1>
      <a href="favorites.php"><img class="image-serv" src="images/favorite.png" alt="Favorite List"></a>
      <p>As a user, manage a list with all your favorite movies. Browse your favorite movies in a seperate page.</p>
    </div>

    <div class="service1">
      <h1>Owner</h1>
      <a href="owner.php"><img class="image-serv" src="images/owner.png" alt="Owner"></a>
      <p>As a cinema owner, manage all your movies in a single page! Create, update or delete movies</p>
    </div>

    <div class="service1">
      <h1>Administration Table</h1>
      <a href="administration.php"><img class="image-serv" src="images/admin.png" alt="Admin"></a>
      <p>As an administrator, control all the website's members information. Update their data or delete them. </p>
    </div>

  </div>

<?php
  include_once 'footer.php';
?>
