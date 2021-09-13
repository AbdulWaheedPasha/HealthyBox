<?php
class Product
{
    // DB Stuff
    private $conn;
    private $table = '`product_tbl`';
    private $cat_table = '`product_category_tbl`';
    private $img_table = '`photos_tbl` ';
    // Properties
    public $limit;
    public $category_id;

    public $product_id;
    public $product_title_ar;
    public $product_title_en;
    public $product_price;
    public $product_discount;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Product
    public function getProductWhereCategoryID(){
              // Create query
      $query = "SELECT * FROM ". $this->table ." as pro inner join ". $this->cat_table ." as cat on cat.`product_id` = pro.`product_id`  WHERE cat.`category_id`  = $this->category_id and  pro.`product_active` = 1 group by pro.`product_id` ";
      mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return  $result;
    }
        // Get all categories
    public function getProductCountWhereCategoryID(){
            // Create query
    $query = "SELECT count(*) FROM ". $this->table ." WHERE `category_id`  = '.$this->category_id.' ";
    mysqli_set_charset($this->conn,"utf8");
    $result = mysqli_query($this->conn, $query);
    return  mysqli_num_rows($result);
  }
      // Get all Product
public function getProductWhereProductID(){
        // Create query
$query = "SELECT * FROM ". $this->table ." WHERE `product_id`  = $this->product_id ";
mysqli_set_charset($this->conn,"utf8");
$result = mysqli_query($this->conn, $query);
return  $result;
}
public function getImageProduct(){
    // Create query
$query = "SELECT * FROM ". $this->img_table ." WHERE  `product_id`    = $this->product_id ";
//echo $query;
mysqli_set_charset($this->conn,"utf8");
$result = mysqli_query($this->conn, $query);
return  $result;
}
public function get_price_field(){
    $query = "SELECT `product_price` FROM `product_tbl` WHERE `product_id` = $this->product_id";
    //echo $query."<br/>";
    mysqli_set_charset($this->conn,"utf8");
    $result = mysqli_query($this->conn, $query);
    $row = mysqli_fetch_row($result);
    //echo "Parent id : ".$row[0]; 
    return  $row[0]; 
}

 


    
    
}

?>
