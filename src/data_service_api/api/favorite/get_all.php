<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Favorite.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $favorite = new Favorite($db);

  $favorite->username = isset($_GET['username']) ? $_GET['username'] : die();

  // User query
  $result = $favorite->fetch_all_favorites();
  // Get row count
  $num = count($result);
  // Check if any movies
  if($num > 0) {

    echo json_encode($result);

  } else {
    // No users
    echo json_encode(
      array('message' => 'No favorites Found')
    );
  }
  
