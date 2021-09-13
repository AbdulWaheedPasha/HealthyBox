<?php
class GetTimeDate
{
    // DB Stuff
    private $conn;
    private $table = 'category_tbl';
    // Properties]
    public $day_name;
    public $category_id;
    public $level;
    public $category_icon;
    public $category_title_ar;
    public $category_title_en;
    public $category_img;
    public $category_order;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all categories
    public function getAvailable()
    {
        $time_query = "SELECT `process_work_id`, `process_work_status` FROM `process_work_tbl`  ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $time_query);
        return  $result;
 
    }
    public function getDeliveryTime()
    {
        $product_query = "SELECT `delivery_time_id`, `delivery_time` FROM `delivery_time_tbl` ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $product_query);
        return  $result;
    }
    public function getTimeWork()
    {
        $product_query = 'SELECT * FROM `day_tbl` inner join   `day_time_tbl` ON  `day_tbl`.`day_id` =    `day_time_tbl`.`day_id` where  `day_tbl`.`day_nam_en` = "'.$this->day_name.'" ';
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $product_query);
        return  $result;
    }
    
    
}

?>

