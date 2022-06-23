<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');


  include_once '../../config/Database.php';
  include_once '../../models/Movie.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $movie= new Movie($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $movie->id = $data->oldtitle;
  $movie->title = $data->title;
  $movie->startdate = $data->startdate;
  $movie->enddate = $data->enddate;
  $movie->cinemaname = $data->cinemaname;
  $movie->category = $data->category;


  // Update user
  if ($movie->updateMovie()) {
    echo json_encode(
      array('message' => 'Movie Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Movie not updated')
    );
  }