<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $user = new User($db);

  //GET ID
  $data = json_decode(file_get_contents("php://input"));
  $user->username = $data->username;
  $user->pwd = $data->pwd;

  // Get user
  $success = $user->authenticateUser();

  if ($success == 0) {
    print_r(json_encode(
      array('message' => 'Error not in database')
    ));
  }
  else {

    // Create array
    $user_array = array(
      'message' => 'User Exists',
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