<?php
class statistics_controller
{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function get_number_subscriber($capital_id)
    {
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT COUNT(`area_id`) as counter FROM `user_area_tbl` where `area_id` IN (SELECT `area_id` FROM `area_tbl` WHERE `capital_id` = '$capital_id')  ";
        //echo $query."<br/>";
        $result = mysqli_query($this->con, $query);
        $num = mysqli_num_rows($result);
        //echo $num;
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj['counter'];
    }
    public function get_number_subscriber_where_status($capital_id,$id)
    { 
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT COUNT(DISTINCT `user_area_tbl`.`user_id`) as counter FROM `user_area_tbl` inner JOIN `administration_tbl` on `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` where `user_area_tbl`.`area_id` IN (SELECT `area_id` FROM `area_tbl` WHERE `capital_id` =  '$capital_id') and `administration_tbl`.`administration_active` = '$id' and `administration_tbl`.`administration_type_id` = 5  ";
       //  echo "Sql: ".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        $num = mysqli_num_rows($result);
        //echo $num;
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj['counter'] ;
    }

    public function get_number_subscriber_where_id($id)
    {
        $where_query = "";
        if($id > 0){
            $where_query = " and  `administration_active` =  '$id' ";
        }
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT count(*) as counter FROM `administration_tbl` where `administration_type_id` = 5  $where_query  ";
        //echo  $query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj;
    }
    public function get_num_user_website_app($id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT count(*) as counter FROM `administration_tbl` where `administrator_register_id` =  '$id'  and `administration_type_id` = 5  ";
        //echo  $query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj;
    }
    
    
}
