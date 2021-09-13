<?php
class today_order_controller
{
    private $program_model;
    private $con;
    public $process;
    public $user_id;
    public $user_area_id;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function get_today_orders()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * ,(SELECT `area_name_eng` FROM `area_tbl` WHERE `area_id` = `user_area_tbl`.`area_id` ) as area_name_eng
                           ,(SELECT `area_name_ar` FROM `area_tbl` WHERE `area_id` = `user_area_tbl`.`area_id` ) as area_name_ar FROM  `program_start_end_date_tbl`
                    INNER JOIN `program_day_tbl` ON `program_day_tbl`.`program_start_end_date_id` = `program_start_end_date_tbl`.`program_start_end_date_id`
                    INNER JOIN `user_area_tbl` ON `user_area_tbl`.`user_area_id` = `program_start_end_date_tbl`.`user_area_id` where `program_day_tbl`.`program_day_flag` = 0 Order by   `program_day_tbl`.`program_start_end_date_id` DESC";
       //echo $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['area_name_eng']              = $row['area_name_eng'];
            $prog_obj[$i]['area_name_ar']               = $row['area_name_ar'];
            $prog_obj[$i]['area_id']                    = $row['area_id'];
            $prog_obj[$i]['user_area_notes']            = $row['user_area_notes'];
            $prog_obj[$i]['user_area_id']               = $row['user_area_id'];
            $prog_obj[$i]['place_id']                   = $row['place_id'];
            $prog_obj[$i]['user_area_driver_notes']     = $row['user_area_driver_notes'];
            $prog_obj[$i]['program_day_date']           = $row["program_day_date"];


            $i++;
        }

        return $prog_obj;
    }

    public function get_today_orders_where_driver_id($date,$driver_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * , 
                FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                where  `administration_tbl`.`administration_type_id` = 5 and  `user_area_tbl`.`user_area_id` IN
                 (SELECT  `program_start_end_date_tbl`.`user_area_id` FROM  `program_start_end_date_tbl`  
                    INNER JOIN  `program_day_tbl` on `program_start_end_date_tbl`.`program_start_end_date_id` = `program_day_tbl`.`program_start_end_date_id`
                    where `program_day_tbl`.`program_day_date` = '$date'  and `program_day_tbl`.`program_day_flag` = 0 group by `program_start_end_date_tbl`.`user_area_id`) Order By `area_tbl`.`area_order_by` DESC";
       //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['name']                       = $row['administration_name'];
            $prog_obj[$i]['telep']                      = $row['administration_telephone_number'];
            $prog_obj[$i]['area_name_eng']              = $row['area_name_eng'];
            $prog_obj[$i]['area_name_ar']               = $row['area_name_ar'];
            $prog_obj[$i]['driver_name']                = $row['driver_name'];
            $prog_obj[$i]['user_area_notes']            = $row['user_area_notes'];
            $prog_obj[$i]['user_area_id']               = $row['user_area_id'];
            $prog_obj[$i]['place_id']                   = $row['place_id'];
            $prog_obj[$i]['user_area_driver_notes']     = $row['user_area_driver_notes'];


            $i++;
        }

        return $prog_obj;
    }
    public function select_pro()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl` ";
       //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['capital_id']           = $row['capital_id'];
            $prog_obj[$i]['capital_en_title']     = $row['capital_en_title'];
            $prog_obj[$i]['capital_ar_title']     = $row['capital_ar_title'];
            $i++;
        }

        return $prog_obj;
    }

    public function get_num_order_where_area_id($date,$capital)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  count(*) as counter 
                FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                where  `administration_tbl`.`administration_type_id` = 5 and  `user_area_tbl`.`user_area_id` IN
                (SELECT  `program_start_end_date_tbl`.`user_area_id` FROM  `program_start_end_date_tbl`  
                INNER JOIN  `program_day_tbl` on `program_start_end_date_tbl`.`program_start_end_date_id` = `program_day_tbl`.`program_start_end_date_id`
                where `program_day_tbl`.`program_day_date` = '$date'  and`program_day_tbl`.`program_day_flag` = 0 
                and `area_tbl`.`area_id` IN (SELECT `area_id`  FROM `area_tbl` WHERE `capital_id` =  '$capital' )  
                group by `program_start_end_date_tbl`.`user_area_id`) Order By `area_tbl`.`area_order_by` DESC";
       // echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']    = $row['counter'];


            $i++;
        }

        return $prog_obj;
    }


    public function get_all_order_where_capital($date,$capital){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * ,count(*) as counter ,
                            (SELECT  `administration_tbl`.`administration_name`   FROM  `user_area_tbl` 
                            INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                            INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                            where  `administration_tbl`.`administration_type_id` = 4 
                            and `area_tbl`.`area_id` = `user_area_tbl`.`area_id`  
                            group by `administration_tbl`.`administration_id`) as driver_name  
                FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                where  `administration_tbl`.`administration_type_id` = 5 and  `user_area_tbl`.`user_area_id` IN
                (SELECT  `program_start_end_date_tbl`.`user_area_id` FROM  `program_start_end_date_tbl`  
                INNER JOIN  `program_day_tbl` on `program_start_end_date_tbl`.`program_start_end_date_id` = `program_day_tbl`.`program_start_end_date_id`
                where `program_day_tbl`.`program_day_date` = '$date'  and`program_day_tbl`.`program_day_flag` = 0 
                and `area_tbl`.`area_id` IN (SELECT `area_id`  FROM `area_tbl` WHERE `capital_id` =  '$capital' )  
                group by `program_start_end_date_tbl`.`user_area_id`) Order By `area_tbl`.`area_order_by`,`user_area_tbl`.`user_area_block` DESC";
        // echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           // print_r($row);
            $prog_obj[$i]['name']                       = $row['administration_name'];
            $prog_obj[$i]['telep']                      = $row['administration_telephone_number'];
            $prog_obj[$i]['area_name_eng']              = $row['area_name_eng'];
            $prog_obj[$i]['area_name_ar']               = $row['area_name_ar'];
            $prog_obj[$i]['driver_name']                = $row['driver_name'];
            $prog_obj[$i]['user_area_notes']            = $row['user_area_notes'];
            $prog_obj[$i]['user_area_id']               = $row['user_area_id'];
            $prog_obj[$i]['place_id']                   = $row['place_id'];
            $prog_obj[$i]['user_area_driver_notes']     = $row['user_area_driver_notes'];


            $i++;
        }

        return $prog_obj;
    }
    public function search_orders()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * ,
                            (SELECT  `administration_tbl`.`administration_name`   FROM  `user_area_tbl` 
                            INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                            INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                            where  `administration_tbl`.`administration_type_id` = 4 
                            and `area_tbl`.`area_id` = `user_area_tbl`.`area_id`
                            group by `administration_tbl`.`administration_id`) as driver_name  
                FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                where  `administration_tbl`.`administration_type_id` = 5 and  `user_area_tbl`.`user_area_id` IN
                 (SELECT  `program_start_end_date_tbl`.`user_area_id` FROM  `program_start_end_date_tbl`  
                    INNER JOIN  `program_day_tbl` on `program_start_end_date_tbl`.`program_start_end_date_id` = `program_day_tbl`.`program_start_end_date_id`) Order By `area_tbl`.`area_order_by` DESC";
       // echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['name']                       = $row['administration_name'];
            $prog_obj[$i]['telep']                      = $row['administration_telephone_number'];
            $prog_obj[$i]['area_name_eng']              = $row['area_name_eng'];
            $prog_obj[$i]['area_name_ar']               = $row['area_name_ar'];
            $prog_obj[$i]['driver_name']                = $row['driver_name'];
            $prog_obj[$i]['user_area_notes']            = $row['user_area_notes'];
            $prog_obj[$i]['user_area_id']               = $row['user_area_id'];
            $prog_obj[$i]['place_id']                   = $row['place_id'];
            $prog_obj[$i]['user_area_driver_notes']     = $row['user_area_driver_notes'];


            $i++;
        }

        return $prog_obj;
    }



    // return realtion between program day and start and end date table 

    public function get_program_start_end_date_tbl($date,$capital){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * FROM `program_start_end_date_tbl`
                    INNER JOIN `program_day_tbl` ON `program_day_tbl`.`program_start_end_date_id` = `program_start_end_date_tbl`.`program_start_end_date_id`
                    INNER JOIN `user_area_tbl`   ON `user_area_tbl`.`user_area_id`                = `program_start_end_date_tbl`.`user_area_id`
                    INNER JOIN `area_tbl`        ON `area_tbl`.`area_id`                          = `user_area_tbl`.`area_id`
                    WHERE `program_day_tbl`.`program_day_date` = '$date' AND `program_day_tbl`.`program_day_flag` = 0 AND `user_area_tbl`.`area_id` IN(SELECT `area_id` FROM `area_tbl` WHERE `capital_id` = '$capital' ) order by `area_tbl`.`area_order_by` ASC,`user_area_tbl`.`user_area_block` ASC ";
        //  echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           // print_r($row);
            $prog_obj[$i]['user_area_id']               = $row['user_area_id'];
            $i++;
        }

        return $prog_obj;
    }


    public function get_all_order_where_user_area_id($id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  *,( SELECT  `color_name` FROM `color_tbl` WHERE `color_id` = `program_tbl`.`program_color_id`) as color 
                FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                INNER JOIN `area_tbl`           ON `area_tbl`.`area_id`                     = `user_area_tbl`.`area_id` 
                INNER JOIN `program_tbl`        ON  `program_tbl`.`program_id`              = `user_area_tbl`.`program_id`
                where   `user_area_tbl`.`user_area_id` = $id  Order By `area_tbl`.`area_order_by`,`user_area_tbl`.`user_area_block` DESC";
        //echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           
            $prog_obj['name']                       = $row['administration_name'];
            $prog_obj['telep']                      = $row['administration_telephone_number'];
            $prog_obj['area_name_eng']              = $row['area_name_eng'];
            $prog_obj['area_name_ar']               = $row['area_name_ar'];
            $prog_obj[$i]['program_id']                = $row['program_id'];
            $prog_obj['user_area_notes']            = $row['user_area_notes'];
            $prog_obj['user_area_id']               = $row['user_area_id'];
            $prog_obj['place_id']                   = $row['place_id'];
            $prog_obj['user_area_driver_notes']     = $row['user_area_driver_notes'];
            $prog_obj['color']     = $row['color'];
            


            $i++;
        }

        return $prog_obj;
    }
    public function get_subscriber_name($id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * FROM  `user_area_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                where   `user_area_tbl`.`user_area_id` = $id ";
        // echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['administration_id']          = $row['administration_id'];
            $prog_obj['name']                       = $row['administration_name'];
            $prog_obj['telep']                      = $row['administration_telephone_number'];
            $prog_obj['telep1']                      = $row['administration_telephone_number1'];
            $i++;
        }

        return $prog_obj;
    }
    public function get_driver_name($area_id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * FROM  `driver_capital_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `driver_capital_tbl`.`driver_id` 
                where   `driver_capital_tbl`.`capital_id` = $area_id AND `administration_tbl`.`administration_type_id` = 4 ";
       // echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           
            $prog_obj['name']                       = $row['administration_name'];
            $prog_obj['telep']                      = $row['administration_telephone_number'];
            $i++;
        }

        return $prog_obj;
    }

    public function get_program_day($prog_id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `program_title_ar`, `program_title_en` FROM `program_tbl` WHERE  `program_id` = '$prog_id' ";
       //echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['program_title_en']      = $row['program_title_en'];
            $prog_obj['program_title_ar']      = $row['program_title_ar'];
            $i++;
        }

        return $prog_obj;
    }


    public function get_driver_name_where_area_id($area_id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * FROM  `driver_capital_tbl` 
                INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `driver_capital_tbl`.`driver_id` 
                where   `driver_capital_tbl`.`capital_id` = (SELECT `capital_id` FROM `area_tbl` WHERE `area_id` = $area_id ) 
                AND `administration_tbl`.`administration_type_id` = 4 ";
       //echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           
            $prog_obj['name']                       = $row['administration_name'];
            $prog_obj['telep']                      = $row['administration_telephone_number'];
            $i++;
        }

        return $prog_obj;
    }


    public function get_user_info_where_id($user_area_id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT  * FROM   `user_area_tbl` 
                  INNER JOIN `administration_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                  AND `user_area_tbl`.`user_area_id` = $user_area_id ";
        //echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           
            $prog_obj['name']                       = $row['administration_name'];
            $prog_obj['telep']                      = $row['administration_telephone_number'];
            $i++;
        }

        return $prog_obj;
    }


    public function fetc_pro($id){
        $i = 0;
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `capital_en_title`, `capital_ar_title` FROM `capital_tbl` WHERE `capital_id` =  '$id'";
        //echo "Query:".$query."<br/>";
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['capital_en_title']    = $row['capital_en_title'];
            $prog_obj['capital_ar_title']    = $row['capital_ar_title'];
        }

        return $prog_obj;
    }




}
