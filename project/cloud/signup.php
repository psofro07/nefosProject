<?php
  include_once 'header.php';
  if (isset($_SESSION["id"])) {
    //If the user is already logged in redirect him to the welcome page.
    header("location: welcome.php");
    exit();
  }
?>
  <!-- Signup form to create the new user -->
<div class="backim">
  <section class="signup-form">
    <div class="signupdiv">
      <h2 class="signuph2">Register Form</h2>
      <form action="includes/signupinc.php" method="post">
        <label class="signuplabel">Name: </label>
        <input type="text" name="NAME" class="signupinp" placeholder="Name...">
        <label class="signuplabel">Surname: </label>
        <input type="text" name="SURNAME" class="signupinp" placeholder="Surname...">
        <label class="signuplabel">Username: </label>
        <input type="text" name="USERNAME" class="signupinp" placeholder="Username...">
        <label class="signuplabel">Password: </label>
        <input type="password" name="PASSWORD" class="signupinp" placeholder="Password...">
        <label class="signuplabel">Repeat Password: </label>
        <input type="password" name="PASSREPEAT" class="signupinp" placeholder="Repeat Password...">
        <label class="signuplabel">Email: </label>
        <input type="email" name="EMAIL" class="signupinp" placeholder="Email...">
        <label class="signupradio">User</label>
        <input type="radio" name="ROLE" class="signupinp" value="User"><br>
        <label class="signupradio">Cinema Owner</label>
        <input type="radio" name="ROLE" class="signupinp" value="CinemaOwner"><br>
        <label class="signupradio">Admin</label>
        <input type="radio" name="ROLE" class="signupinp" value="Admin">
        <button type="submit" name="submitSignup" class="signupbutton">Sign Up</button>
      </form>

      <?php
        //Get statements to inform the user if his actions where succesfull or had errors.
        if (isset($_GET["error"])){

          if ($_GET["error"]  == "emptyInput") {
            echo '<p class="failed">Fill in all fields!</p>';
          }
          else if ($_GET["error"]  == "invaliduid") {
            echo '<p class="failed">Choose a proper Username!</p>';
          }
          else if ($_GET["error"]  == "invaliduemail") {
            echo '<p class="failed">Choose a proper email!</p>';
          }
          else if ($_GET["error"]  == "passwordmismatch") {
            echo '<p class="failed">Passwords do not match!</p>';
          }
          else if ($_GET["error"]  == "stmtfailed") {
            echo '<p class="failed">Something went wrong!</p>';
          }
          else if ($_GET["error"]  == "usernametaken") {
            echo '<p class="failed">Username taken, choose a diffrent one!</p>';
          }
          else if ($_GET["error"]  == "none") {
            echo '<p class="success">You have signed up!</p>';
          }
        }

    ?>

    </div>

  </section>

</div>

<?php
  include_once 'footer.php';
?>
