<?php
class Area
{
    // DB Stuff
    private $conn;
    private $table = '`area_tbl` ';
    // Properties
    public $area_id;
    public $area_name;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Product
    public function getArea(){
              // Create query
      $query = "SELECT * FROM ". $this->table ."  where `area_id` =  $this->area_id ";
       //echo  $query;
      mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return  $result;
    }

}

?>
