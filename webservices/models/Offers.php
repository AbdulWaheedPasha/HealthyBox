<?php
class Offers
{
    // DB Stuff
    private $conn;
    private $table = '`offer_tbl`';
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
    public function fetchOffer(){
              // Create query
      $query =  "SELECT `offer_id`, `offer_title_ar`, `offer_title_en`, `offer_title_week`, `offer_month`, `offer_day`, `offer_day`, `offer_cost`  FROM $this->table  \n"
                . "ORDER BY `offer_tbl`.`offer_id`  DESC";
      //echo  $query;
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
