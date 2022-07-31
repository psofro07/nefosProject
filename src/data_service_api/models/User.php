<?php
  class User {
    
    private $conn;
    private $coll = 'users';
    private $dbname = "nefosproject";

    // Post Properties
    public $id;
    public $name;
    public $surname;
    public $username;
    public $pwd;
    public $email;
    public $role;
    public $confirmed;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Users
    public function fetch_all_users() {

      $collection = $this->conn->nefosproject->users;

      try {

        $query= $collection->find()->toArray();

      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }
      
      return $query;

    }

    // Get Single User
    public function fetch_single_user() {

      $success = 1;

      $collection = $this->conn->nefosproject->users;

      try {
        $query= $collection->findOne([
          'USERNAME' => $this->username, 
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      } 

      if ( $query['NAME'] == null ){
        $success = 0;
        return $success;
      }
      
      // Set properties
      $this->name = $query['NAME'];
      $this->surname = $query['SURNAME'];
      $this->username = $query['USERNAME'];
      $this->pwd = $query['PASSWORD'];
      $this->email = $query['EMAIL'];
      $this->role = $query['ROLE'];
      $this->confirmed = $query['CONFIRMED'];

      return $success;

    }

    // Create User
    public function createUser() {

      $success = 1;

      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->surname = htmlspecialchars(strip_tags($this->surname));
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->pwd = htmlspecialchars(strip_tags($this->pwd));
      $this->email = htmlspecialchars(strip_tags($this->email));
    
      $collection = $this->conn->nefosproject->users;

      try {
        $query = $collection->insertOne([
          'NAME' => $this->name,
          'SURNAME' => $this->surname,
          'USERNAME' => $this->username,
          'PASSWORD' => $this->pwd,
          'EMAIL' => $this->email,
          'ROLE' => $this->role,
          'CONFIRMED' => '0'
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }  
      
      // Execute query
      if($success > 0) {
        return true;
      }

      // Print error if something goes wrong
      return false;

    }


    // Update User
    public function updateUser() {
      
      $success = 1;

      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->surname = htmlspecialchars(strip_tags($this->surname));
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->pwd = htmlspecialchars(strip_tags($this->pwd));
      $this->email = htmlspecialchars(strip_tags($this->email));
    
      $collection = $this->conn->nefosproject->users;

      try {
        $query = $collection->replaceOne([
          'ID' => $this->id
        ],
        [
          'NAME' => $this->name,
          'SURNAME' => $this->surname,
          'USERNAME' => $this->username,
          'PASSWORD' => $this->pwd,
          'EMAIL' => $this->email,
          'ROLE' => $this->role,
          'CONFIRMED' => $this->confirmed
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      }

      $modifCount = $query->getModifiedCount();

      if ($modifCount){
        return true;
      }
      else {
        return false;
      }

    }

    // Delete User
    public function deleteUser() {
      // Create query
      $success = 1;

      $collection = $this->conn->nefosproject->users;

      try {
        $query= $collection->deleteOne([
          'USERNAME' => $this->username, 
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      } 

      return $query->getDeletedCount();

    }

    // Authenticate User
    public function authenticateUser() {

      $success = 1;

      $collection = $this->conn->nefosproject->users;

      try {
        $query= $collection->findOne([
          'USERNAME' => $this->username,
          'PASSWORD' => $this->pwd
        ]);
      } catch (Exception $ex) {
        echo $ex->getMessage();
        $success = 0;
      } 

      if ( $query['NAME'] == null ){
        $success = 0;
        return $success;
      }
      
      // Set properties
      $this->name = $query['NAME'];
      $this->surname = $query['SURNAME'];
      $this->username = $query['USERNAME'];
      $this->pwd = $query['PASSWORD'];
      $this->email = $query['EMAIL'];
      $this->role = $query['ROLE'];
      $this->confirmed = $query['CONFIRMED'];

      return $success;


    }

    public function fetch_cinema() {

      $collection = $this->conn->nefosproject->cinemas;

      try {

        $query= $collection->findOne([
          'OWNER' => $this->username
        ]);

      } catch (Exception $ex) {
        echo $ex->getMessage();
        return -1;
      }

      return $query;

    }

  }