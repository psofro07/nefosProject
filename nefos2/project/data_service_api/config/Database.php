<?php
  require 'vendor/autoload.php';

  class Database {
    // DB params
    //$client = new MongoClient("mongodb://${username}:${password}@localhost/myDatabase");
    //private $client= new MongoDB\Client("mongodb://localhost:27017"); 
    private $servername = 'localhost';
    private $port = 27018;
    private $username = 'root';
    private $password= "devpass";
    //private $DBname = "nefosproject";
    private $conn;

    function __construct(){
      //Connecting to MongoDB
      try {
      //Establish database connection
          $this->conn = new MongoDB\Client("mongodb://root:devpass@mongo1:27017");
      }catch (Exception $e) {
          echo $e->getMessage();
          echo nl2br("n");
      }
    }

    function getConnection() {
      return $this->conn;
    }
  

  }
?>
