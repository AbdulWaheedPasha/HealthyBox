<?php
class Additions
{
    // DB Stuff
    private $conn;
    private $table = 'category_tbl';
    // Properties
    public $product_id;
    public $additions_id;
 

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAdditions()
    {
        $query = "SELECT  * FROM `additions_tbl` as it inner join  `additions_product_tbl` as pro on it.`additions_id` = pro.`additions_id` where pro.`product_id` = '$this->product_id' and  it.`additions_active` = 1  group by  it.`additions_id` ";
        //echo  $query; 
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
 
    }   
    public function getItemsAdditions()
    {
        $query = "SELECT `additions_item_id`, `additions_item_ar_name`, `additions_item_en_name`, `additions_item_price`, `additions_id` FROM `additions_item_tbl`where `additions_id` = '$this->additions_id' and `additions_item_active` = '1' ";
        //echo  $query; 
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
 
    }
    
    
}

?>

