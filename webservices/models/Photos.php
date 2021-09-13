<?php
class Photos
{
    // DB Stuff
    private $conn;
    private $table = '`photos_tbl`';
    // Properties

    public $photos_id;
    public $photos_path;
    public $product_id;
    public $pages_id;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

      // Get all Product
    public function getImageProductWhereProductID(){
          $query = "SELECT *  FROM ". $this->table ."  WHERE `product_id` = $this->product_id  ";
          mysqli_set_charset($this->conn,"utf8");
          $result = mysqli_query($this->conn, $query);
          return  $result;
    }

    public function getSingleImageProductWhereProductID(){
        $query = "SELECT *  FROM ". $this->table ."  WHERE `product_id` = $this->product_id  LIMIT 1 ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
      }


    
    
}

?>
