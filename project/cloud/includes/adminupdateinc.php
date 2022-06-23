<?php
include 'dbh_handler.php';

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $surname = $_POST['edit_surname'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $role = $_POST['edit_role'];
    $confirmed = $_POST['edit_confirmed'];

    /*if ($hashedPsw !=='') {
      $hashedPsw = password_hash($password, PASSWORD_DEFAULT);
    }*/
    


    $query = "UPDATE users SET NAME = '$name', SURNAME = '$surname', USERNAME = '$username', EMAIL = '$email', ROLE = '$role', CONFIRMED = '$confirmed' WHERE ID='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header('Location: ../administration.php?error=noneu'); 
    }
    else
    {
        header('Location: ../administration.php?error=updatefailed'); 
    }
}

?>
