<?php
  // Headers
  header('Acess-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  include_once '../../config/Database.php';
  include_once '../../models/Movie.php';

  // Instantialise DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantialise User object
  $movie = new Movie($db);

  // User query
  $result = $movie->fetch_all_movies();
  // Get row count
  $num = count($result);

  // Check if any movies
  if($num > 0) {
    // Movie array and other usefull data
    $movies_arr = array();
    $movies_arr['data'] = array();

    foreach($result as $doc) {
      
      $movie_item = array(
        'title' => $doc['TITLE'],
        'startdate' => $doc['STARTDATE'],
        'enddate' => $doc['ENDDATE'],
        'cinemaname' => $doc['CINEMANAME'],
        'category' => $doc['CATEGORY']
      );



      // Push to "data"
      array_push($movies_arr["data"], $movie_item);

    }

    // Turn to JSON % output
    echo json_encode($movies_arr);

  } else {
    // No users
    echo json_encode(
      array('message' => 'No movies Found')
    );
  }
