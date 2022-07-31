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

  // User query
  $result = $user->fetch_all_users();
  // Get row count
  $num = count($result);

  // Check if any users
  if($num > 0) {
    // User array and other usefull data
    $users_arr = array();
    $users_arr['data'] = array();

    foreach($result as $doc) {
      //Instead of writing $row['param'] i write $param
      $user_item = array(
        'name' => $doc['NAME'],
        'surname' => $doc['SURNAME'],
        'username' => $doc['USERNAME'],
        'pwd' => $doc['PASSWORD'],
        'email' => $doc['EMAIL'],
        'role' => $doc['ROLE'],
        'confirmed' => $doc['CONFIRMED']
      );

      // Push to "data"
      array_push($users_arr['data'], $user_item);

    }

    // Turn to JSON % output
    echo json_encode($users_arr);

  } else {
    // No users
    json_encode(
      array('message' => 'No users Found')
    );
  }
