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

  //GET ID
  $favorite->username = isset($_GET['username']) ? $_GET['username'] : die();
  $favorite->title = urldecode(isset($_GET['title'])) ? $_GET['title'] : die();
  $favorite->cinemaname = isset($_GET['cinemaname']) ? $_GET['cinemaname'] : die();

  // Get user
  $result = $favorite->fetch_single_favorite();

  /*if ($result == null) {
    echo json_encode(
      array('message' => 'No favorite Found')
    );
  }
  else {*/

  // Create array
  $fav_array = array(
    'subID' => $result['subID']
  );

  // Make JSON
  echo json_encode($fav_array);
  //}