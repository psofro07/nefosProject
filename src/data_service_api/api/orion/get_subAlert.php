<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  //GET ID
  $username = isset($_GET['username']) ? $_GET['username'] : die();
    
  $collection = $db->nefosproject->subs;

  try {
    $query= $collection->find([
      'USERNAME' => $username
    ])->toArray();
  } catch (Exception $ex) {
    echo $ex->getMessage();
    return -1;
  }

  $num = count($query);

  if($num > 0) {

    $arr = array();
    $arr['data'] = array();

    foreach($query as $doc) {
      
      $item = array(
        'title' => $doc['TITLE'],
        'startdate' => $doc['STARTDATE'],
        'enddate' => $doc['ENDDATE'],
        'username' => $doc['USERNAME']
      );



      // Push to "data"
      array_push($arr["data"], $item);

    }

    // Turn to JSON % output
    echo json_encode($arr);

  } else {
    // No users
    echo json_encode(
      array('message' => 'No alerts found')
    );
  }
