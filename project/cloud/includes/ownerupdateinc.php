<?php 

if (isset($_POST["updatebtn"])) {
  
  $id = $_POST["edit_id"];
  $title= $_POST["edit_title"];
  $startdate = $_POST["edit_startdate"];
  $enddate= $_POST["edit_enddate"];
  $cinemaname = $_POST["edit_cinemaname"];
  $category = $_POST["edit_category"];

  require_once 'dbh_handler.php';
  require_once 'functions.php';

  updateMovie($conn, $id, $title, $startdate, $enddate, $cinemaname, $category);

}
else {
  header("location: ../welcome.php?wrongRouting");
}