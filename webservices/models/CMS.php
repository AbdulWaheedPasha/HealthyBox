<?php
class CMS
{
    private $conn;
    private $table = '`pages_tbl`';
    public $page_id;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getPageContent(){
          $query = "SELECT * FROM $this->table WHERE  `pages_id` = $this->page_id ";
          mysqli_set_charset($this->conn,"utf8");
          $result = mysqli_query($this->conn, $query);
          return  $result;
    }
    public function getArea(){
        $query = "SELECT `area_id`, `area_name_ar`, `area_name_eng`, `area_cost_delivery` FROM `area_tbl`  ";
        //echo $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
  }
}
?>
