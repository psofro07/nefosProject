<?php

  session_start();

  if (isset($_SESSION["id"])) {
    //If the user is already logged in redirect him to the welcome page.
    header("location: welcome.php");
    exit();
  }

  include_once 'header.php';
  
?>
  <!-- Signup form to create the new user -->
<div class="backim">
  <section class="signup-form">
    <div class="signupdiv">
      <h2 class="signuph2">Register Form</h2>
      <form id="formid" action="ajax_signup.php" method="post">
        <label class="signuplabel">Username: </label>
        <input id="userid" type="text" name="USERNAME" class="signupinp" placeholder="Username...">
        <label class="signuplabel">Password: </label>
        <input id="passid" type="password" name="PASSWORD" class="signupinp" placeholder="Password...">
        <label class="signuplabel">Repeat Password: </label>
        <input id="rpassid" type="password" name="PASSREPEAT" class="signupinp" placeholder="Repeat Password...">
        <label class="signuplabel">Email: </label>
        <input id="emailid" type="email" name="EMAIL" class="signupinp" placeholder="Email...">
        <label class="signupradio">User</label>
        <input type="radio" name="ROLE" class="signupinp" value="User"><br>
        <label class="signupradio">Cinema Owner</label>
        <input type="radio" name="ROLE" class="signupinp" value="CinemaOwner"><br>
        <label class="signupradio">Admin</label>
        <input type="radio" name="ROLE" class="signupinp" value="Admin">
        <input type="hidden" name="signupAction" value="signup">
        <button id="btnid" type="submit" name="submitSignup" class="signupbutton">Sign Up</button>
      </form>

      <p id="createStatus"></p>

    </div>

  </section>

</div>

<script>

$(document).ready(function() {


  $("#formid").submit(function(event) {

    event.preventDefault();
    $("#createStatus").html("");

    if($("#userid").val() == '') {
      $("#createStatus").html(
        '<p class="failed">Fill in Username!</p>'
      );
    }
    else if($("#passid").val() == '') {
      $("#createStatus").html(
        '<p class="failed">Fill in Password!</p>'
      );
    }
    else if($("#passid").val() == '' || $("#rpassid").val() == ''  || $("#rpassid").val() != $("#passid").val()) {
      $("#createStatus").html(
        '<p class="failed">Repeat password correctly!</p>'
      );
    }
    else if($("#emailid").val() == '') {
      $("#createStatus").html(
        '<p class="failed">Fill in Email!</p>'
      );
    }
    else if ( $('input[name="ROLE"]:checked').val() == null) {
      $("#createStatus").html(
        '<p class="failed">Fill in role!</p>'
      );
    }
    else {

      var form_data = $(this).serialize();

      $.ajax({
        url:"ajax_post_methods.php",
        method: "POST",
        data: form_data,
        success:function(data)
        {
          // Function that gets the  ajax response
          // fetch_data();

          $("#formid")[0].reset();
          if( data == 'created') {
            $('#createStatus').html('<p class="success">You have signed up!</p>');
          }
          else if( data == 'error'){
            $("#createStatus").html('<p class="failed">Error in Database... User was not created!</p>');
          }
          else {
            $("#createStatus").html('<p class="failed">Fatal Error!</p>');
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
