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

  //$collection = $db->conn->nefosproject->subs;

  $data = $json->data;
  foreach($data as $key){
    $title = $key->movie->value;
    $startdate = $key->startdate->value;
    $enddate = $key->enddate->value;
    $user = $key->user->value;
  }
  $id = $json->subscriptionId;

  if($favorite->subExists($id, $title, $user)){
    
    $stmt = $favorite->insert_subAlert($user, $title, $startdate, $enddate);

    if ($stmt){
      echo json_encode(
        array('message' => 'Subinfo updated')
      );
    }
    else {
      echo json_encode(
        array('message' => 'Subinfo error')
      );
    }
    
  }
  else {
    
    $result = $favorite->insertSubinfo($title, $id, $user);

    echo json_encode(
      array('message' => $id)
    );
  }


