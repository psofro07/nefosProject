<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With:');


  include_once '../../config/Database.php';
  include_once '../../models/Movie.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $movie = new Movie($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $movie->title = $data->title;
  $movie->startdate = $data->startdate;
  $movie->enddate = $data->enddate;
  $movie->cinemaname = $data->cinemaname;
  $movie->category = $data->category;

  // Create user
  if ($movie->createMovie()) {
    echo json_encode(
      array('message' => 'Movie Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Movie not created')
    );
  }