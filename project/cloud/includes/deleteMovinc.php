<?php 

if (isset($_POST["deleteMov-btn"])) {
  
  $MID = $_POST["movieid"];

  require_once 'dbh_handler.php';
  require_once 'functions.php';

  removeFavoritefirst($conn, $MID);
  deleteMovie($conn, $MID);

}
else {
  header("location: ../welcome.php?wrongRouting");
}