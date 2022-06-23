<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $user = new User($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $user->name = $data->name;
  $user->surname = $data->surname;
  $user->username = $data->username;
  $user->pwd = $data->pwd;
  $user->email = $data->email;
  $user->role = $data->role;

  // Create user
  if ($user->createUser()) {
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User not created')
    );
  }
