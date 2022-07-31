<?php

  session_start();
  
  $temp = 'CinemaOwner';
  //Chech if the user is logged in. Else redirect him to loggin page.
  if (!isset($_SESSION["id"])) {
    header("location: movies.php");
    exit();
  }
  //Check if the user is confirmed by the admin. Else redirect to the welcome page.
  if (!isset($_SESSION["token"])) {
    header("location: welcome.php?error=notConfirmed");
    exit();
  }
  //Give access to this page only if the user has the role of "CinemaOwner". Else redirect him to the welcome page.
  $temp = 'CinemaOwner';
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: movies.php");
    exit();
  }

  include_once 'header.php';
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
    <button class="addmov-btn" style="vertical-align:middle"><span><a id="addmovid" class="create-mov">Add Film</a></span></button>
    </div>
  </section>

  <!--The div that contains the modal for the button above-->
  <div class="btn-modal">
    <div class="modal-content">
      <!--A fake button to close the modal with js-->
      <div class="close-tag">+</div>
        <img src="images/movie.svg" class="mov-img" alt="image">

        <!--A form with the new movies details-->
        <form action="ajax_ownerCreate.php" method="POST" class="movform">

          <label class="mov-lab">Title</label>
          <input type="text" name="TITLE" class="modal-inputs" placeholder="Movie Title...">
          <label class="mov-lab">Category</label>
          <input type="text" name="CATEGORY" class="modal-inputs" placeholder="Category...">
          <label class="mov-lab">Cinema</label>
          <label id="mycinema" class="mov-lab"></label>
          <!--A query that finds all the current owner's cinemas for him to choose to add his movie in-->
          <label class="mov-lab">Premiere date</label>
          <input type="date" name="STARTDATE" class="modal-inputsdate" placeholder="Start date...">
          <label class="mov-lab">End date</label>
          <input type="date" name="ENDDATE" class="modal-inputsdate" placeholder="End date...">
          <input type="hidden" name="mycinemaid" value="">
          <input type="hidden" name="createmovAction" value="createmov">
          <button type="submit" name="submit" class="btn-addmov">Register Movie</button>

        </form>

    </div>
  </div>

  <br>

  <p id="actionStatus"></p>
  <div id="orionStatus"></div>
  

<!--The main body to display the owner's movies--->
<div class="browse-body">
  <h1 class="browseH">My movies</h1>
  <hr class="hrlineo">

  <div id="moviesbody" class="movies-body">

  </div>

<script src="js/createmovie.js"></script>

<script>
  /*******************************AJAX CODE ******************************/
$(document).ready(function() {

  fetch_data();
  fetch_mycinema();
  

  function fetch_data() {  
    $.ajax({
      url:"ajax_owner_movies.php",
      method: "GET",
      success: function(data)
      {
        $('#moviesbody').html(data);
      } 
    })
  }

  function fetch_mycinema() {
    $.ajax({
      url:"ajax_get_cinema.php",
      method: "GET",
      success: function(data)
      {
        $("#mycinema").text(data);
        $("#mycinemaid").val(data);
      } 
    })
  }

  function mycinema() {
    var name = null;
    $.ajax({
      url:"ajax_get_cinema.php",
      method: "GET",
      success: function(data)
      {
        name = data;
      } 
    })
    return name;
  }

  /*******************************AJAX CODE FOR MOVIE DELETION******************************/
  $(document).on('click', '.btndl', function (event) {
    event.preventDefault();

    var movtitle = $(this).parents('.formfav').find("input[name='movieid']").val();
    var cinemname= $(this).parents('.formfav').find("input[name='cinemanameid']").val();
    var btnname = $(this).val();
    $.ajax({
      url:"ajax_delete_methods.php",
      method: "POST",
      data: { title : movtitle, cinemaname : cinemname, btndlt : btnname},
      success: function(data)
      {
        fetch_data();
        $('#actionStatus').html(data);
      }
    })

  });

  /*******************************AJAX CODE FOR EDITING MOVIES******************************/
  $(document).on('submit', '.formfav', function(event) {
      event.preventDefault();
      
      var form_data = $(this).serializeArray();
      dataObj = {};

      $(form_data).each(function(i, field){
        dataObj[field.name] = field.value;
      });
      oldtitle = dataObj['movieid'];
      updtAction = dataObj['updtAction'];

      var $form = $(this);
      var btntext = $form.find("button[name='update-btn']").text();

      var btnname = $(this).text();
      var currentfield = $(this).parents('.movie-border').find('h5');

      var title = $(this).parents('.movie-border').find('.letitle').text(); 
      var category = $(this).parents('.movie-border').find('.lecat').text();
      var cinename = $('#mycinema').text();
      var startdate = $(this).parents('.movie-border').find('.lestart').text();
      var enddate = $(this).parents('.movie-border').find('.leend').text();


      if (btntext == 'create') { 
        
        $.each(currentfield, function () {
        $(this).prop('contenteditable', true)
        });

      }
      else if (btntext == 'check_circle') {

        $.each(currentfield, function () {
          $(this).prop('contenteditable', false)
        });
          
          $.ajax({
            url:"ajax_put_methods.php",
            method: "POST",
            data: { title : title, cinemaname : cinename, category : category, startdate : startdate, enddate : enddate, oldtitle : oldtitle, updtAction : updtAction},
            success: function(data)
            { 
              fetch_data();
              $("#actionStatus").html(data);
            }
          })
          
          $.ajax({
            url:"orion_putEntity.php",
            method: "POST",
            data: { title : title, cinemaname : cinename, category : category, startdate : startdate, enddate : enddate, oldtitle : oldtitle, updtAction : updtAction},
            success: function(data)
            { 
              fetch_data();
              $("#orionStatus").html(data);
            }
          }) 


      }

      $(this).find("button[name='update-btn']").html($(this).find("button[name='update-btn']").html() == '<i class="material-icons favicon">create</i>' ? '<i class="material-icons favicon">check_circle</i>' : '<i class="material-icons favicon">create</i>')

    });

 /*******************************AJAX CODE FOR CREATING A MOVIE******************************/
 $(document).on("submit", '.movform', function(event) {
    event.preventDefault();
    document.querySelector('.btn-modal').style.display = 'none';
    
    //var $form = $(this);
    //var btnval = $form.find("button[name='submit']").val();
    //var TITLE = $form.find("input[name='TITLE']").val();
    //var CATEGORY = $form.find("input[name='CATEGORY']").val();
    //var CINEMANAME = $form.find("select[name='CINEMANAME']").val();
    //var STARTDATE = $form.find("input[name='STARTDATE']").val();
    //var ENDDATE = $form.find("input[name='ENDDATE']").val();

    

    var form_data = $(this).serialize();
    var cinename = $('#mycinema').text();
    var newdata = form_data + '&CINEMANAME=' + cinename;
    $.ajax({
        url:"ajax_post_methods.php",
        method: "POST",
        data: newdata,
        success: function(data)
        {
          fetch_data();
          if (data == 'created') {
            $("#actionStatus").html('<p class="success">Movie created successfully!</p>');
          }
          else {
            $("#actionStatus").html('<p class="failed">Error!</p>');
          }
          
        } 
      })

  });


});




</script>

<?php
  include_once 'footer.php';
?>