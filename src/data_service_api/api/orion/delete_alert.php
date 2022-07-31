<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  //GET ID
  $title = isset($_GET['title']) ? $_GET['title'] : die();
  $username = isset($_GET['username']) ? $_GET['username'] : die();
    
  $collection = $db->nefosproject->subs;

  try {
    $query= $collection->deleteOne([
      'USERNAME' => $username,
      'TITLE' => $title
    ]);
  } catch (Exception $ex) {
    echo $ex->getMessage();
    return -1;
  }

  $count = $query->getDeletedCount();

  echo json_encode(
    array('message' => 'Deleted: '.$count.'')
  );
