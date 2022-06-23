<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $user = new User($db);

  //GET ID
  $user->username = isset($_GET['username']) ? $_GET['username'] : die();
  // Get user
  $result = $user->fetch_cinema();

  if (count($result)) {
    echo json_encode($result);
  }
  else {
    echo json_encode(
      array('message' => 'No cinema found')
    );
  }