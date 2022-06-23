<?php

if (isset($_POST["submit"])) {
  
  $USERNAME = $_POST["USERNAME"];
  $PASSWORD = $_POST["PASSWORD"];

  require_once 'dbh.php';
  require_once 'functions.php';

  if (emptyInputLogin($USERNAME, $PASSWORD) !== false) {
    header("location: ../index.php?error=emptyInput");
    exit();
  }

  loginUser($conn, $USERNAME, $PASSWORD);

}
else {
  header("location: ../index.php");
  exit();
}
