<?php
class hold_controller
{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
    }


    public function get_num_hold_days($user_area_id,$program_day_date){
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT count(*) as counter FROM `program_day_tbl` WHERE `program_start_end_date_id` = 
         (SELECT `program_start_end_date_id` FROM `program_start_end_date_tbl` WHERE `user_area_id` = '$user_area_id' ) and `program_day_date` > '$program_day_date' " ;
    //    echo $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']            = $row['counter'];
        }
        return $prog_obj;
    }

    public function markable_days_where_user_in_hold($user_area_id,$program_day_date)
    {
        mysqli_set_charset($this->con, "utf8");
        $markables_day_sql = "UPDATE `program_day_tbl` SET `program_day_flag` = '1' where `program_start_end_date_id` =  
                             (SELECT `program_start_end_date_id` FROM `program_start_end_date_tbl` WHERE `user_area_id` = '$user_area_id' ) 
                             and `program_day_date` > '$program_day_date' " ;
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $markables_day_sql);
        return $rs;
    }


    public function get_last_renew_date($user_area_id)
    {
        mysqli_set_charset($this->con, "utf8");
        $markables_day_sql = "SELECT  `program_start_date`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = $user_area_id " ;
       // echo $markables_day_sql;
        mysqli_set_charset($this->con, "utf8");
        $result = mysqli_query($this->con, $markables_day_sql);
        while ($row = mysqli_fetch_row($result)) {
           $last_date =  $row[0];
        }
        return $last_date;
    }





    public function insert_hold_table($id,$hold_date,$hold_num)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "INSERT INTO `hold_date_tbl` (`hold_date_num_days`, `user_area_id`, `hold_date_num_date`) VALUES ('$hold_num', '$id', '$hold_date'); " ;
        //echo $query;
        $result = mysqli_query($this->con, $query);
        return $result;
    }

    public function get_hold_program($user_area_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT *  FROM `hold_date_tbl` WHERE `user_area_id` =  '$user_area_id' " ;
       // echo $query."</br>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['hold_date_num_days']      = $row['hold_date_num_days'];
            $prog_obj['hold_date_id']            = $row['hold_date_id'];
        }

        return $prog_obj;
    }

    
}
