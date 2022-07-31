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
  $success = $user->fetch_single_user();

  if ($success == 0) {
    print_r(json_encode(
      array('message' => 'No user Found')
    ));
  }
  else {

    // Create array
    $user_array = array(
      'name' => $user->name,
      'surname' => $user->surname,
      'username' => $user->username,
      'pwd' => $user->pwd,
      'email' => $user->email,
      'role' => $user->role,
      'confirmed' => $user->confirmed
    );

    // Make JSON
    echo json_encode($user_array); 
  }