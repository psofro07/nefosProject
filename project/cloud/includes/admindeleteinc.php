<?php
include('dbh_handler.php');


if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    require_once 'functions.php';

    $query = "DELETE FROM users WHERE ID ='$id'";
    removeFavoritefromID($conn, $id);
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header('Location: ../administration.php?error=noned'); 
    }
    else
    {
        header('Location: ../administration.php?error=deletefailed');
    }
}
