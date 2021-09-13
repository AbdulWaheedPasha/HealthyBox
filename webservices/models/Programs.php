<?php
class Programs
{
    private $conn;
    public $user_area_id;
    public $start_date;
    public $end_date;
    public $user_id;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setStartDateAndEndDate(){
        $query = "INSERT INTO `program_start_end_date_tbl`(`program_start_date`, `program_start_end`, `user_area_id`) VALUES ('$this->start_date','$this->end_date','$this->user_area_id')";
        // echo $query;
        mysqli_set_charset($this->conn,"utf8");  
        $result = mysqli_query($this->conn, $query);
        return  mysqli_insert_id($this->conn);
    }

    
  
    public function getSubcriberStatus(){
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->conn, "utf8");
        $query = "SELECT `user_status_id`, `user_status_ar_name`, `user_status_eng_name` FROM `user_status_tbl` WHERE  `user_status_id` =  (SELECT `administration_active` FROM `administration_tbl` WHERE `administration_id` = $this->user_id) ";
        // echo  $query."<br/>";
        $result = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['status_ar']          = $row['user_status_ar_name'];
            $prog_obj['status_en']         = $row['user_status_eng_name'];
        }

        return $prog_obj;
    }

    
    

}





?>


