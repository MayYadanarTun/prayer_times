<?php
    trait DBConnection{
        public $serverName = "localhost";
        public $userName = "root";
        public $password = "";
        public $dbName = "coding_test_pray";

        public function connect(){
            $conn = mysqli_connect($this->serverName,$this->userName,$this->password,$this->dbName);
                if(!$conn){
                    die('Connection fail:' . mysqli_connect_error());
                }
                return $conn;
        }

        public function disconnect($conn){
            $conn->close();
        }
    }
?>