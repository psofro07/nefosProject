<?php 

if (isset($_POST["addfav-btn"])) {
  
  $UID = $_POST["userid"];
  $MID = $_POST["movieid"];

  require_once 'dbh_handler.php';
  require_once 'functions.php';

  insertFavorite($conn, $UID, $MID);

}
else {
  header("location: ../welcome.php?wrongRouting");
}