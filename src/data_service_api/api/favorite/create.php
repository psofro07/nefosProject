<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');


  include_once '../../config/Database.php';
  include_once '../../models/Favorite.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $favorite = new Favorite($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $favorite->username = $data->username;
  $favorite->title = $data->title;
  $favorite->cinemaname = $data->cinemaname;
  $favorite->startdate = $data->startdate;
  $favorite->enddate = $data->enddate;

  $result = $favorite->createFavorite();
  // Create user
  if ($result == 1) {
    echo json_encode(
      array('message' => 'Favorite Created')
    );
  }
  elseif($result == 0) {
    echo json_encode(
      array('message' => 'Favorite Exists')
    );
  }
  else {
    echo json_encode(
      array('message' => 'Favorite not created')
    );
  }