<?php 

if (isset($_POST["removfav-btn"])) {
  
  $UID = $_POST["userid"];
  $MID = $_POST["movieid"];

  require_once 'dbh_handler.php';
  require_once 'functions.php';

  removeFavorite($conn, $UID, $MID);

}
else {
  header("location: ../welcome.php?wrongRouting");
}