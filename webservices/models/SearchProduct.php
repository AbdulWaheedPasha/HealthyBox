<?php
class SearchProduct
{
    // DB Stuff
    private $conn;
    private $table = '`product_tbl`';
    // Properties
    public $product_name;
    public $limit;
  
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all categories
    public function getProductSearchByName()
    {
        $query = "SELECT *  FROM $this->table  WHERE `product_active` = 1 and (`product_title_ar` LIKE '%".$this->product_name."%' AND `product_title_en` LIKE '%".$this->product_name."%') LIMIT $this->limit,30   ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
 
    }
    
    
}

?>

