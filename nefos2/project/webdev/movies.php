<?php

  session_start();

  //include_once 'includes/dbh_handler.php';

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
  //Give access to this page only if the user has the role of "User". Else redirect him to the welcome page.
  $temp = 'User';
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: welcome.php?error=notUserOwner");
    exit();
  }
  
  include_once 'header.php';

  //If the user didn't accessed this site by the searching form.
  if( (!isset($_POST['search-btn'])) ) {

    ?>
    
    <!--BANNER-->
    <div class="banner">
    <img class="banner-image" src="images/potter.jpg" alt="banner">
    </div>

    <br>
    <br>


    <!--Inform the user about the status when he tries to add a movie to his favorites.-->

    <div id="favStatus"></div>
    <div id="orionStatus"></div>
    <div id="orionStatus1"></div>
    <div id="orionStatus2"></div>

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

        <form id="movieform" action="AJAX_moviesSearch.php" method="POST">
          <input id="searchvalid" type="search" name="search-val" placeholder="&#xf002 Search for a movie then hit enter..." class="srf" >
          <select name="parameter" id="paramid" class="param">
            <optgroup label="Search by:">
              <option value="Title">Title</option>
              <option value="Category">Category</option>
              <option value="CinemaOwner">Cinema Owner</option>
              <option value="Date">Date</option>
            </optgroup>
          </select>
          <label for="startdate" class="datelabl">Start date:</label>
          <input id="premdateid" type="date" name="startdate" class="dateinp">
          <label for="enddate" class="datelabl">End date:</label>
          <input id="dateendid" type="date" name="enddate" class="dateinp">
          <button id="formbtnid" type="submit" name="search-btn" class="srch"></button>
        </form>

      </div>
    </div>

    <div id="moviesid" class="movies-body">

    </div>

<?php

}

    ?>
  

</div>

<!---------------------------------------------------END BODY----------------------------------------------------------- -->

<!---------------AJAX CODE FOR SEARCH------------------------------>
<script>
  $(document).ready(function() {

    fetch_data();

    function fetch_data() {   
      $.ajax({
        url:"ajax_get_movies.php",
        success: function(data)
        {
          $('#moviesid').html(data);
        } 
      })
    }


    $("#movieform").submit(function(event) {
      event.preventDefault();

      var form_data = $(this).serialize();

      $.ajax({
        url:"ajax_get_movies.php",
        method: "GET",
        data: form_data,
        success: function(data)
        {
          $('#moviesid').html(data);
        }
      })

    });


    /////////////////////////////////////
    $(document).on('submit', '.formfav', function(event) {
    event.preventDefault();
    $('#favStatus').html("");
    var form_data = $(this).serialize();
    // Add movie to favorites
    $.ajax({
        url:"ajax_post_methods.php",
        method: "POST",
        data: form_data,
        success: function(data)
        {
          $('#favStatus').html(data);

          if( data != '<p class="failed">Movie already included in favorites!</p>'){

            $.ajax({
              url:"orion_createEntity.php",
              method: "POST",
              data: form_data,
              success: function(data)
              { 
                $("#orionStatus1").html(data);
              }
            })

            $.ajax({
              url:"orion_addSub.php",
              method: "POST",
              data: form_data,
              success: function(data)
              {
                $('#orionStatus2').html(data);
              }
            });
            
          }

        }
    });
  
  });


  });
 

</script>

<!---------------AJAX CODE FOR ADDING FAVORITES------------------------------>

<?php
include_once 'footer.php';
?>
