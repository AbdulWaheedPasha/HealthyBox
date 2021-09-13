<?php
class Offers
{
    // DB Stuff
    private $conn;
    private $table = '`product_tbl`';
    // Properties
    public $limit;
    public $offer_id;

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
    public function getProductOffers(){
              // Create query
      $query = "SELECT  `user_token_device` FROM `user_tbl` WHERE `user_id` =  ";
      mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return  $result;
    }
        // Get all categories
    public function getProductCountProductOffers(){
            // Create query
    $query = "SELECT count(*) FROM ". $this->table ." WHERE  `product_best_sell`  = 1 ";
    mysqli_set_charset($this->conn,"utf8");
    $result = mysqli_query($this->conn, $query);
    return  mysqli_num_rows($result);
    }


 


    
    
}

?>
