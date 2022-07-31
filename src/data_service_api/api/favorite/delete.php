<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');


  include_once '../../config/Database.php';
  include_once '../../models/Favorite.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $favorite = new Favorite($db);

  // Get raw posted data
  $favorite->username = isset($_GET['username']) ? $_GET['username'] : die();
  $favorite->title = isset($_GET['title']) ? $_GET['title'] : die();
  $favorite->cinemaname = isset($_GET['cinemaname']) ? $_GET['cinemaname'] : die();

  // Delete favorite
  if ($favorite->deleteFavorite()) {
    echo json_encode(
      array('message' => 'Favorite Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Error')
    );
  }