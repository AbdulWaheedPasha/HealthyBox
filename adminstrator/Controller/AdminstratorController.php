<?php
class adminstrator_controller
{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function update_status_user($value,$id)
    {
        $renew_sql = "UPDATE `administration_tbl` SET  `administration_active`= '$value'  WHERE `administration_id` =  '$id' ";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $renew_sql);
        return mysqli_insert_id($this->con);
    }
    public function changeProgramStatus($user_area_id)
    {
        $renew_sql = "UPDATE `program_start_end_date_tbl` SET `program_active` = '3' WHERE `user_area_id` = '$user_area_id'  ";;
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $renew_sql);
        return mysqli_insert_id($this->con);
    }


    
    
}
