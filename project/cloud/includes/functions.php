<?php

//Check for empty fields when creating user
function emptyInputSignup($NAME, $SURNAME, $USERNAME, $EMAIL, $PASSWORD, $ROLE) {

  $result;

  if(empty($NAME) || empty($SURNAME) || empty($USERNAME) || empty($EMAIL) || empty($PASSWORD) || empty($ROLE)) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Check for empty fields when creating movie
function emptyInputAddmovie($TITLE, $STARTDATE, $ENDDATE, $CINEMANAME, $CATEGORY) {

  $result;

  if(empty($TITLE) || empty($STARTDATE) || empty($ENDDATE) || empty($CINEMANAME) || empty($CATEGORY)) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Make sure the username has acceptable characters
function invalidUid($USERNAME) {

  $result;

  if( !preg_match("/^[a-zA-Z0-9]*$/", $USERNAME)) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Check if the email given is valid
function invalidEmail($EMAIL) {

  $result;

  if(!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Check the password and the repeated password to be the same
function pwdMatch($PASSWORD, $PASSREPEAT) {

  $result;

  if( $PASSWORD !== $PASSREPEAT) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Check if the username already exists
function uidExists($conn, $USERNAME, $EMAIL) {

  //Creating prepared statements to avoid sql injection
  $sql = "SELECT * FROM users WHERE USERNAME = ? OR EMAIL = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }



  mysqli_stmt_bind_param($stmt, "ss", $USERNAME, $EMAIL);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  }
  else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

//Create a user
function createUser($conn, $NAME, $SURNAME, $USERNAME, $EMAIL, $PASSWORD, $ROLE) {

  //Creating prepared statements to avoid sql injection
  $sql = "INSERT INTO users (NAME, SURNAME, USERNAME, PASSWORD, EMAIL, ROLE) VALUES (?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmt2failed");
    exit();
  }

  //Hash the password before adding it to the database
  $hashedPsw = password_hash($PASSWORD, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssssss", $NAME, $SURNAME, $USERNAME, $hashedPsw, $EMAIL, $ROLE);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../signup.php?error=none");

}

//Creating a database
function createMovie($conn, $TITLE, $STARTDATE, $ENDDATE, $CINEMANAME, $CATEGORY) {

  //Creating prepared statements to avoid sql injection
  $sql = "INSERT INTO movies (TITLE, STARTDATE, ENDDATE, CINEMANAME, CATEGORY) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../owner.php?error=stmt2failed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sssss", $TITLE, $STARTDATE, $ENDDATE, $CINEMANAME, $CATEGORY);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../owner.php?error=nonec");
}

//Delete movie
function deleteMovie($conn, $MID) {

  $query = "DELETE FROM movies WHERE ID='$MID'";
  $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header('Location: ../owner.php?error=noned'); 
    }
    else
    {
        header('Location: ../owner.php?error=deletefailed'); 
    }   
}

//Insert a movie to favorites
function insertFavorite($conn, $UID, $MID) {
  if (favExist($conn, $UID, $MID)) {
    header("location: ../movies.php?error=alreadyFav");
    exit();
  }
  $sql = "INSERT INTO favorites (USERID, MOVIEID) VALUES (?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../owner.php?error=stmt2failed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $UID, $MID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../movies.php?error=none");

}

//Check if this movie is already in favorites
function favExist($conn, $UID, $MID) {
  
  $result;

  $query= "SELECT * FROM favorites WHERE USERID = '$UID' AND MOVIEID = '$MID' ";
  $query_run = mysqli_query($conn, $query);

  if (mysqli_num_rows($query_run) > 0) {
    $result = 1;
  }
  else {
    $result = 0;
  }

  return $result;
}

//Update the movie's data
function updateMovie($conn, $id, $title, $startdate, $enddate, $cinemaname, $category) {

  $query = "UPDATE movies SET TITLE = '$title', STARTDATE = '$startdate', ENDDATE = '$enddate', CINEMANAME = '$cinemaname', CATEGORY = '$category' WHERE ID='$id' ";
  $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header('Location: ../owner.php?error=nonee'); 
    }
    else
    {
        header('Location: ../owner.php?error=updatefailed'); 
    }
}

//Remove from favorites
function removeFavorite($conn, $UID, $MID) {

    $query = "DELETE FROM favorites WHERE USERID ='$UID' AND MOVIEID='$MID'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header('Location: ../favorites.php?error=none'); 
    }
    else
    {
        header('Location: ../favorites.php?error=deletefailed'); 
    }    
}

//Remove from favorites before deleting the movie
function removeFavoritefirst($conn, $MID) {

  $query = "DELETE FROM favorites WHERE MOVIEID='$MID'";
  $query_run = mysqli_query($conn, $query);

  if($query_run)
  {
      return;
  }
  else
  {
      header('Location: ../owner.php?error=failedToDeleteFav'); 
  }    
}

//Remove favorite byid field
function removeFavoritefromID($conn, $ID) {

  $query = "DELETE FROM favorites WHERE USERID='$ID'";
  $query_run = mysqli_query($conn, $query);

  if($query_run)
  {
      return;
  }
  else
  {
      header('Location: ../administration.php?error=failedToDeleteFav'); 
  }    
}

//Check for empty fields in login
function emptyInputLogin($USERNAME, $PASSWORD) {

  $result;

  if( empty($USERNAME) ||  empty($PASSWORD)) {
    $result = true;
  }
  else {
    $result = false;
  }

  return $result;
}

//Login the user
function loginUser($conn, $USERNAME, $PASSWORD){
  
  $EMAIL = "Dont care";
  $uidExists = uidExists($conn, $USERNAME, $EMAIL);

  if ($uidExists === false) {
    header("location: ../index.php?error=wronglogin");
    exit();
  }

  //Check if the password is correct
  $pwdHashed = $uidExists["PASSWORD"];
  $checkPwd = password_verify($PASSWORD, $pwdHashed);

  if ($checkPwd === false) {
    header("location: ../index.php?error=wronglogin");
    exit();
  }
  elseif ($checkPwd === true) {
    //Create the session variables once logged in
    session_start();
    $_SESSION["id"] = $uidExists["ID"];
    $_SESSION["name"] = $uidExists["NAME"];
    $_SESSION["surname"] = $uidExists["SURNAME"];
    $_SESSION["username"] = $uidExists["USERNAME"];
    $_SESSION["role"] = $uidExists["ROLE"];
    $_SESSION["confirmed"] = $uidExists["CONFIRMED"];
    header("location: ../welcome.php");
    exit();
  }
}