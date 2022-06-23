<?php
  class Favorite {
    
    private $conn;
    private $table = 'favorites';

    // Favorite Properties
    public $id;
    public $username;
    public $title;
    public $cinemaname;
    public $subinfo;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Favorites
    public function fetch_all_favorites() {
      
      $collection = $this->conn->nefosproject->favorites;

      try {

        $query = $collection->find([ 'USERNAME' => $this->username, ])->toArray();

      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

      $num = count($query);

      if($num > 0) {

        $collection = $this->conn->nefosproject->movies;
        $movies_arr = array();
        $movies_arr['data'] = array();

        foreach($query as $key) {

          try {

            $q1 = $collection->findOne([ 'TITLE' => $key['TITLE'], 'CINEMANAME' => $key['CINEMANAME'] ]);
    
          } catch (Exception $ex) {
            echo $ex->getMessage();
          }

          $movie_item = array(
            'title' => $q1['TITLE'],
            'startdate' => $q1['STARTDATE'],
            'enddate' => $q1['ENDDATE'],
            'cinemaname' => $q1['CINEMANAME'],
            'category' => $q1['CATEGORY']
          );

          // Push to "data"
          array_push($movies_arr["data"], $movie_item);

        }
        return $movies_arr;

        //return $movies_arr;

      }

      return $query;

    }

    // Get Single Favorite (!probably dont need)
    public function fetch_single_favorite() {

      $collection = $this->conn->nefosproject->favorites;

      try {
        $query= $collection->findOne([
          'USERNAME' => $this->username,
          'TITLE' => $this->title,
          'CINEMANAME' => $this->cinemaname
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      /*if ( $query['subID'] == null ){
        return 0;
      }*/

      // Set properties

      return $query;

    }


    // Create Favorite
    public function createFavorite() {

      $collection = $this->conn->nefosproject->favorites;

      try {
        $query= $collection->findOne([
          'USERNAME' => $this->username,
          'TITLE' => $this->title,
          'CINEMANAME' => $this->cinemaname,
          'startdate' => $this->startdate,
          'enddate' => $this->enddate
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      if( $query == 0) {

        try {
          $query = $collection->insertOne([
            "USERNAME" => $this->username,
            "TITLE" => $this->title,
            "CINEMANAME" => $this->cinemaname,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate
          ]);
        }catch (Exception $ex) {
          echo $ex->getMessage();
          return -1;  
        }  

        return 1;
      }
      else {
        return 0;
      }         

    }


    // Delete Favorite
    public function deleteFavorite() {
      
      $collection = $this->conn->nefosproject->favorites;

      try {
        $query= $collection->deleteOne([
          'USERNAME' => $this->username,
          'TITLE' => $this->title,
          'CINEMANAME' => $this->cinemaname 
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      return $query->getDeletedCount();

    }


    public function delete_by_ids() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE USERID = :userid AND MOVIEID= :movieid ';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean Data
      $this->userid = htmlspecialchars(strip_tags($this->userid));
      $this->movieid = htmlspecialchars(strip_tags($this->movieid));

      // Bind data
      $stmt->bindParam(':userid', $this->userid);
      $stmt->bindParam(':movieid', $this->movieid);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      
      return false;

    }

    public function insertSubinfo($title, $id, $user) {

      $collection = $this->conn->nefosproject->favorites;

      try {
        $query= $collection->updateOne(
          ['TITLE' => $title, 'USERNAME' => $user],
            ['$set' => 
              ['subID' => $id]
            ]
        );
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      return 1;


    }


    public function subExists($id, $title, $user) {

      $collection = $this->conn->nefosproject->favorites;

      try {
        $query= $collection->findOne([
          'subID' => $id,
          'TITLE' => $title,
          'USERNAME' => $user
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }
      
      if($query == null){
        return 0;
      }
      else {
        return 1;
      }

    }


    public function fetch_SubIDs() {

      $collection = $this->conn->nefosproject->favorites;

      try {

        $query = $collection->find([
          'TITLE' => $this->title,
          'CINEMANAME' => $this->cinemaname,
          'subID' => array('$ne' => null)
        ])->toArray();

      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

      return $query;
      
    }


    public function insert_subAlert($user, $title, $startdate, $enddate){

      $collection = $this->conn->nefosproject->subs;

      try {
        $query1= $collection->findOne([
          'USERNAME' => $user,
          'TITLE' => $title
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      if($query1 != null){

        try {
          $query2= $collection->replaceOne([
            'TITLE' => $title,
            'USERNAME' => $user
            ],
            ['TITLE' => $title,
            'USERNAME' => $user,
            'STARTDATE' => $startdate,
            'ENDDATE' => $enddate
            ]
          );
        } catch (Exception $ex) {
          echo $ex->getMessage();
          return -1;
        }

      }
      else{

        try {
          $query2 = $collection->insertOne([
            'USERNAME' => $user,
            'TITLE' => $title,
            'STARTDATE' => $startdate,
            'ENDDATE' => $enddate
          ]);
        }catch (Exception $ex) {
          echo $ex->getMessage();
          return -1;  
        } 

      }
      return 1;
    }

  }