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

  $favorite = new Favorite($db);

  $json = json_decode(file_get_contents("php://input"));

  $favorite->title = $json->title;
  $favorite->cinemaname = $json->cinemaname;
  
  $result = $favorite->fetch_subIDs();

  $num = count($result);

  if($num > 0) {

    $arr = array();
    $arr['data'] = array();

    foreach($result as $doc) {
      
      $item = array(
        'username' => $doc['USERNAME'],
        'title' => $doc['TITLE'],
        'subID' => $doc['subID'],
        'cinemaname' => $doc['CINEMANAME']
      );



      // Push to "data"
      array_push($arr["data"], $item);

    }

    // Turn to JSON % output
    echo json_encode($arr);

  } else {
    // No users
    echo json_encode(
      array('message' => 'No subs')
    );
  }