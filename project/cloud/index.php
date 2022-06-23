<?php
  include_once 'header.php';
  //If the user is already logged in redirect him to the welcome page.
  if (isset($_SESSION["id"])) {
    header("location: welcome.php");
    exit();
  }

?>

<!-- Login Form -->
<div class="backindex">
  <section class="Login_form">
    <div class="signupdiv">
      <h2 class="signuph2">Log In</h2>
      <form action="includes/logininc.php" method="post">
        <label class="signuplabel">Username: </label>
        <input type="text" name="USERNAME" class="signupinp" placeholder="Username...">
        <label class="signuplabel">Password: </label>
        <input type="password" name="PASSWORD" class="signupinp" placeholder="Password...">
        <button type="submit" name="submit" class="signupbutton">Login</button>
      </form>

    <?php
      //Get statements to inform the user if his actions where succesfull or had errors.
      if (isset($_GET["error"])){

        if ($_GET["error"]  == "emptyInput") {
          echo '<p class="failed">Fill in all fields!</p>';
        }
        else if ($_GET["error"]  == "wronglogin") {
         echo '<p class="failed">Username or password are incorrect!</p>';
        }
        else if ($_GET["error"]  == "stmtfailed") {
          echo '<p class="failed">Something went wrong!</p>';
        }
        else if ($_GET["error"]  == "notloggedin") {
         echo '<p class="failed">ACCESS DENIED are not logged in!</p>';
       }

      }

    ?>

    </div>
  </section>
</div>

<?php
  include_once 'footer.php';
?>
