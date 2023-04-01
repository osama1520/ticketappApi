<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Credentials', 'true');

class Database {
  private $host;
  private $dbusername;
  private $dbpass;
  private $dbname;

  function __construct() {
      $this->host='localhost';
      $this->dbusername='root';
      $this->dbpass='';
      $this->dbname='ticketapp';
      $this->con = new mysqli($this->host,$this->dbusername,$this->dbpass,$this->dbname);
      if($this->con->connect_error) {
          die("Error: " . $this->con->connect_error);
      } else {
        //   echo "Connected to database successfully!";
      }
  }   
}
// new Database;
?>
