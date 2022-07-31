<?php
  
  session_start();
  
  //If the user is already logged in redirect him to the welcome page.
  if (isset($_SESSION["id"])) {
    header("location: welcome.php");
    exit();
  }

  include_once 'header.php';

?>

<!-- Login Form -->
<div class="backindex">
  <section class="Login_form">
    <div class="signupdiv">
      <h2 class="signuph2">Log In</h2>
      <form id="indexform" action="includes/logininc.php" method="post">
        <input type="hidden" name="loginAction" value="login">
        <label class="signuplabel">Email: </label>
        <input id="userid" type="text" name="USERNAME" class="signupinp" placeholder="Username...">
        <label class="signuplabel">Password: </label>
        <input id="pwdid" type="password" name="PASSWORD" class="signupinp" placeholder="Password...">
        <button type="submit" name="submit" class="signupbutton">Login</button>
      </form>

      <p id="loginStatus"></p>

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

<script>
  $(document).ready(function() {

    $('#indexform').submit(function(event) {

      event.preventDefault();
      $("#loginStatus").html("");

      if($("#userid").val() == '') {
        $("#loginStatus").html(
          '<p class="failed">Fill in Username!</p>'
        );
      }
      else if($("#pwdid").val() == '') {
        $("#loginStatus").html(
          '<p class="failed">Fill in Password!</p>'
        );
      }
      else {

        var form_data = $(this).serialize();

        $.ajax({
          url:"keyrock_signIn.php",
          method: "POST",
          data: form_data,
          success:function(data)
          {
            // Function that gets the  ajax response
            // fetch_data();

            $("#indexform")[0].reset();
            if( data == 'Log In') {
              window.location="http://localhost/welcome.php";
            }
            else if( data == 'error'){
              $("#loginStatus").html('<p class="failed">Wrong combination of Username or Password!</p>');
            }
            else {
              $("#loginStatus").html('<p class="failed">Fatal Error!</p>');
            }
          }

        });
        
      }

    });


});

</script>

<?php
  include_once 'footer.php';
?>
