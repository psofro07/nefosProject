<?php 

if (isset($_POST["submitSignup"])) {
  
  $NAME = $_POST["NAME"];
  $SURNAME = $_POST["SURNAME"];
  $USERNAME = $_POST["USERNAME"];
  $EMAIL = $_POST["EMAIL"];
  $PASSWORD = $_POST["PASSWORD"];
  $PASSREPEAT = $_POST["PASSREPEAT"];
  $ROLE = $_POST["ROLE"];

  require_once 'dbh.php';
  require_once 'functions.php';

  if (emptyInputSignup($NAME, $SURNAME, $USERNAME, $EMAIL, $PASSWORD, $ROLE) !== false) {
    header("location: ../signup.php?error=emptyInput");
    exit();
  }
  if (invalidUid($USERNAME) !== false) {
    header("location: ../signup.php?error=invaliduid");
    exit();
  }
  if (invalidEmail($EMAIL) !== false) {
    header("location: ../signup.php?error=invaliduemail");
    exit();
  }
  if (pwdMatch($PASSWORD, $PASSREPEAT) !== false) {
    header("location: ../signup.php?error=passwordmismatch");
    exit();
  }
  if (uidExists($conn, $USERNAME, $EMAIL) !== false) {
    header("location: ../signup.php?error=usernametaken");
    exit();
  }

  createUser($conn, $NAME, $SURNAME, $USERNAME, $EMAIL, $PASSWORD, $ROLE);

}
else {
  header("location: ../index.php");
}