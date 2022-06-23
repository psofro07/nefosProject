<?php

  session_start();
  
  $temp = 'User';

  //Chech if the user is logged in. Else redirect him to loggin page.
  if (!isset($_SESSION["id"])) {
    header("location: index.php?error=notloggedin");
    exit();
  }
  //Check if the user is confirmed by the admin. Else redirect to the welcome page.
  if (!isset($_SESSION["token"])) {
    header("location: welcome.php?error=notConfirmed");
    exit();
  }
  //Give access to this page only if the user has the role of "user". Else redirect him to the welcome page.
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: welcome.php?error=notUserOwner");
    exit();
  }
  
  $sessid = $_SESSION["id"];

  include_once 'header.php';

?>

<!--Banner-->
<div class="banner">
  <img class="banner-image" src="images/inception.jpg" alt="banner">
</div>

<!--Inform the user about the status when he tries to remove a movie from his favorites.-->

<div id="favremStatus"></div>
<div id="orionStatus"></div>

<!--Browse headline--> 
<div class="browse-body">
  <h1 class="browseH">Browse favorites</h1>
  <hr class="brlineh">
</div>

<!--Body displaying all the movies-->
<div class="movies-body" id="moviesid">

</div>

<!---------------AJAX CODE FOR REMOVING FAVORITES------------------------------>
<script>
$(document).ready(function() {

  fetch_data();

  function fetch_data() {   
      $.ajax({
        url:"ajax_get_favorites.php",
        method: "POST",
        success: function(data)
        {
          $('#moviesid').html(data);
        } 
      })
  }
  

  $(document).on('submit', '.formfav', function(event) {
    event.preventDefault();
    var form_data = $(this).serialize();
    //alert(form_data);

    $.ajax({
      url:"orion_deleteAlert.php",
      method: "POST",
      data: form_data,
      success: function(data)
      {
        fetch_data();
        $('#orionStatus').html(data);
      }
    })

    $.ajax({
      url:"orion_deleteSub.php",
      method: "POST",
      data: form_data,
      success: function(data)
      {
        fetch_data();
        $('#orionStatus').html(data);
      }
    })

    $.ajax({
      url:"orion_deleteEntity.php",
      method: "POST",
      data: form_data,
      success: function(data)
      {
        fetch_data();
        $('#orionStatus').html(data);
      }
    })

    $.ajax({
      url:"ajax_delete_methods.php",
      method: "POST",
      data: form_data,
      success: function(data)
      {
        fetch_data();
        $('#favremStatus').html(data);
      }
    })

    

    


  });

});




</script>

<?php
  include_once 'footer.php';
?>