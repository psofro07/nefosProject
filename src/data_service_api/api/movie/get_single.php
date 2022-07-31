<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Movie.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $movie = new Movie($db);

  //GET ID
  $movie->title = isset($_GET['title']) ? $_GET['title'] : die();

  // Get user
  $success = $movie->fetch_single_movie();

  if ($success == 0) {
    print_r(json_encode(
      array('message' => 'No user Found')
    ));
  }
  else {

  // Create array
  $movie_array = array(
    'title' => $movie->title,
    'startdate' => $movie->startdate,
    'enddate' => $movie->enddate,
    'cinemaname' => $movie->cinemaname,
    'category' => $movie->category
  );

  // Make JSON
  print_r(json_encode($movie_array));

  }