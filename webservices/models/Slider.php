<?php
class Slider
{
    // DB Stuff
    private $conn;
    private $table = '`photos_tbl`';
    // Properties
    public $product_id;
    public $photos_id;
    public $photos_path;
    public $pages_id;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
     // Get all Product
    public function get_all_programs(){
          $query = "SELECT * FROM `program_tbl` inner join `category_tbl`  on `category_tbl`.`category_id` = `program_tbl`.`category_id` where `program_tbl`.`program_active` =  1";
         // echo $query;
          mysqli_set_charset($this->conn,"utf8");
          $result = mysqli_query($this->conn, $query);
          return  $result;
    } 
}

?>
