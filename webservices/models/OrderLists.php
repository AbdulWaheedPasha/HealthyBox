<?php
class OrderLists
{
    // DB Stuff
    private $conn;
    private $table = 'category_tbl';
    // Properties
    public $user_id;
    public $order_id;
    public $order_lists_id;
    public $participation_id;
    public $program_start_end_date_id;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all categories
    public function getAllPrograms()
    {
        $query = 'SELECT *,(SELECT  `program_cost`  FROM `program_tbl` WHERE `program_id` = `user_area_tbl`.`program_id` ) as program_price,
        (SELECT  `program_discount` FROM `program_tbl` WHERE `program_id` = `user_area_tbl`.`program_id` ) as program_discount FROM `user_area_tbl` INNER JOIN `program_start_end_date_tbl` ON `user_area_tbl`.`user_area_id` = `program_start_end_date_tbl`.`user_area_id` where `user_area_tbl`.`user_id` = '.$this->user_id.' ';
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        //echo $query;
        return  $result;
 
    }
    public function getProgramWhereProgramID()
    {
        $query = 'SELECT  * FROM  `user_area_tbl`
                  INNER JOIN `program_start_end_date_tbl` ON `user_area_tbl`.`user_area_id` = `program_start_end_date_tbl`.`user_area_id`
                  INNER JOIN `program_tbl` ON `program_tbl`.`program_id` = `user_area_tbl`.`program_id`
                  WHERE `user_area_tbl`.`user_area_id` =  '.$this->participation_id.' ';
       //echo $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
       // echo $query;
        return  $result;
 
    }
    public function getDaysWhereProgramID()
    {
        $query = ' SELECT * FROM `program_day_tbl` where `program_start_end_date_id` = '.$this->program_start_end_date_id.' ';
        //echo  $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
       // echo $query;
        return  $result;
 
    }

   public function getOrderDetialsByOrderID(){
       $query = 'SELECT 
            * 
        FROM 
            `order_tbl` 
            INNER JOIN `order_status_tbl` ON `order_tbl`.`order_status_id` = `order_status_tbl`.`order_status_id` 
            INNER JOIN `order_administration_tbl` ON `order_administration_tbl`.`order_id` = `order_tbl`.`order_id` where `order_tbl`.`order_id` = '.$this->order_id.' ORDER BY `order_tbl`.`order_id` DESC';
            mysqli_set_charset($this->conn,"utf8");
            $result = mysqli_query($this->conn, $query);
           // echo $query;
            return  $result;
     
    }

    public function  getOrderlistsByOrderID(){
        $query = "SELECT * FROM `order_lists_tbl` inner join `product_tbl` ON `order_lists_tbl`.`product_id` = `product_tbl`.`product_id` where `order_lists_tbl`.`order_id` =  $this->order_id ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
      
    }

    public function  getOrderAdditonsByOrderID(){
        $query = "SELECT * FROM `order_additions_item_tbl` INNER JOIN `additions_item_tbl` on `order_additions_item_tbl`.`additions_item_id` = `additions_item_tbl`.`additions_item_id` where `order_additions_item_tbl`.`order_lists_id` = $this->order_lists_id ";
       // echo  $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
      
    }
    
    
}

?>

