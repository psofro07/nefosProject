<?php 

if (isset($_POST["submit"])) {
  
  $TITLE = $_POST["TITLE"];
  $STARTDATE = $_POST["STARTDATE"];
  $ENDDATE = $_POST["ENDDATE"];
  $CINEMANAME = $_POST["CINEMANAME"];
  $CATEGORY = $_POST["CATEGORY"];

  require_once 'dbh_handler.php';
  require_once 'functions.php';

  if (emptyInputAddmovie($TITLE, $STARTDATE, $ENDDATE, $CINEMANAME, $CATEGORY) !== false) {
    header("location: ../owner.php?error=emptyInput");
    exit();
  }

  createMovie($conn, $TITLE, $STARTDATE, $ENDDATE, $CINEMANAME, $CATEGORY);

}
else {
  header("location: ../owner.php");
}