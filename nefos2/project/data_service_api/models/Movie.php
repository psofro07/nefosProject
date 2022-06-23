<?php
  class Movie {
    
    private $conn;
    private $coll = 'movies';
    private $dbname = 'nefosproject';

    // Movie Properties
    public $id;
    public $title;
    public $startdate;
    public $enddate;
    public $cinemaname;
    public $category;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Movies
    public function fetch_all_movies() {
      // Create query
      $collection = $this->conn->nefosproject->movies;

      try {

        $query= $collection->find()->toArray();

      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }
      
      return $query;
      
    }

    // Get movies by owner
    public function fetch_all_owner($username) {

      $collection = $this->conn->nefosproject->cinemas;

      try {

        $query= $collection->findOne([
          'OWNER' => $username
        ]);

      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      if(count($query) > 0) {

        $collection = $this->conn->nefosproject->movies;

        try {

          $q1= $collection->find([
            'CINEMANAME' => $query['CINEMANAME']
          ])->toArray();

        } catch (Exception $ex) {
          echo $ex->getMessage();
          $success = 0;
        }
        
        return $q1;
      }
      else {
        return $query;
      }

    }

    // Get Single Movie
    public function fetch_single_movie() {

      $success = 1;

      $collection = $this->conn->nefosproject->movies;

      try {
        $query= $collection->findOne([
          'TITLE' => $this->title, 
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      } 

      if ( $query['TITLE'] == null ){
        $success = 0;
        return $success;
      }

      // Set properties
      $this->title = $query['TITLE'];
      $this->startdate = $query['STARTDATE'];
      $this->enddate = $query['ENDDATE'];
      $this->cinemaname = $query['CINEMANAME'];
      $this->category = $query['CATEGORY'];

      return $success;

    }

    // Create Movie
    public function createMovie() {

      $success = 1;
     
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->cinemaname = htmlspecialchars(strip_tags($this->cinemaname));
      $this->category = htmlspecialchars(strip_tags($this->category));

      $collection = $this->conn->nefosproject->movies;

      try {
        $query = $collection->insertOne([
          "TITLE" => $this->title,
          "STARTDATE" => $this->startdate,
          "ENDDATE" => $this->enddate,
          "CINEMANAME" => $this->cinemaname,
          "CATEGORY" => $this->category
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }  
      
      // Execute query
      if($success > 0) {
        return true;
      }
      
      return false;

    }

    public function updateMovie() {

      $success = 1;

      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->cinemaname = htmlspecialchars(strip_tags($this->cinemaname));
      $this->category = htmlspecialchars(strip_tags($this->category));

      $collection = $this->conn->nefosproject->movies;

      try {
        $query = $collection->replaceOne([
          'TITLE' => $this->id,
          'CINEMANAME' => $this->cinemaname
        ],
        [
          'TITLE' => $this->title,
          'STARTDATE' => $this->startdate,
          'ENDDATE' => $this->enddate,
          'CINEMANAME' => $this->cinemaname,
          'CATEGORY' => $this->category
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }

      /****************/
      $collection = $this->conn->nefosproject->favorites;

      try {
        $q1= $collection->updateMany(
          ['TITLE' => $this->id, 'CINEMANAME' => $this->cinemaname],
            ['$set' => 
              ['startdate' => $this->startdate, 'enddate' => $this->enddate]
            ]
        );
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      /**********************/

      $modifCount = $query->getModifiedCount();

      if ($modifCount){
        return true;
      }
      else {
        return false;
      }


    }

    // Delete Post
    public function deleteMovie() {
      // Create query
      $success = 1;
      
      $collection = $this->conn->nefosproject->movies;

      try {
        $query= $collection->deleteOne([
          'TITLE' => $this->title, 
          'CINEMANAME' => $this->cinemaname
        ]);

        $collection = $this->conn->nefosproject->favorites;
        $q1= $collection->deleteOne([
          'TITLE' => $this->title, 
          'CINEMANAME' => $this->cinemaname
        ]);

      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      } 

      return $query->getDeletedCount();

    }


    // Search Movie
    public function searchMovies($search, $param, $startdate, $enddate) {

      $collection = $this->conn->nefosproject->movies;

      if (empty($search) && $param != 'Date'){

        try {

          $query= $collection->find()->toArray();
  
        } catch (Exception $ex) {
          echo $ex->getMessage();
          $success = 0;
        }
        
        return $query;

      }
      elseif(!empty($search) && $param == 'Title') {

        try {
          $query = $collection->find(array( 'TITLE' => array('$regex' => $search)))->toArray();
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }
        
        return $query;

      }
      elseif (!empty($search) && $param == 'Category') {
        
        try {
          $query= $collection->find(array( 'CATEGORY' => array('$regex' => $search)))->toArray();
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }
        
        return $query;

      }
      elseif (!empty($search) && $param == 'CinemaOwner') {

        try {
          $collection = $this->conn->nefosproject->cinemas;
          $query = $collection->findOne(array ('OWNER' => array('$regex' => $search)));
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }

        try {
          $collection = $this->conn->nefosproject->movies;
          $query1 = $collection->find(array( 'CINEMANAME' => array('$regex' => $query['NAME'])))->toArray();
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }

        return $query1;

      }
      elseif ($param == 'Date') {
        
        try {
          $query = $collection->find(array('$or' => array(
               array('STARTDATE' => $startdate),
               array('ENDDATE' => $enddate)
              )
            )
          );
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }
        
        return $query;

      }

    }

  }