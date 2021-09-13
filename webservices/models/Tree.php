<?php
class Tree
{
    // DB Stuff
    private $conn;
    private $product_tbl = '`product_tbl`';
    private $category_tbl = '`category_tbl`';
    // Properties
    public $category_id;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    public function getMainCategory(){
        $query = "SELECT * FROM $this->category_tbl  WHERE `category_active` = '1'  and `category_id_tree` = 0 ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
         return  $result;
    }
    public function getProduct(){
        $query = "SELECT * FROM ". $this->product_tbl ." WHERE  `product_active` = 1 and `category_id` = $this->category_id order by `product_id` DESC  LIMIT 20 ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
    }
}

?>
