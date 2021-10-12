<?php
    error_reporting(1);
    ini_set('display_errors', 1);
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
        $date_query = "";
        // $where_query  = " where  `program_start_end_date_tbl`.`program_active` = '$id' ";
        // $where_query .= (empty($where_query)) ?  "where " :  $where_query;
        $date_query = "";
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
          $query = "SELECT
        COUNT(*) as  counter 
            FROM
                `administration_tbl`
            WHERE
                `administration_id`  IN 
                (
                  SELECT  `administration_tbl`.`administration_id` FROM `user_area_tbl`
                                             INNER JOIN `program_start_end_date_tbl` ON `user_area_tbl`.`user_area_id` = `program_start_end_date_tbl`.`user_area_id` 
                                             INNER JOIN  `administration_tbl`        ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` 
                                             where  `user_area_tbl`.`area_id` IN (SELECT `area_id` FROM `area_tbl` WHERE `capital_id` =  '$capital_id')  
            ) ";

        $result = mysqli_query($this->con, $query);
        $num = mysqli_num_rows($result);
        //echo $num;
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj['counter'] ;
    }
    public function get_number_subscriber_where_status($capital_id,$id){ 
        $count_num = 0;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT COUNT(*) as  counter 
            FROM
                `user_area_tbl`
            INNER JOIN `administration_tbl` AS admin
            ON
                `user_area_tbl`.`user_id` = `admin`.`administration_id`
            INNER JOIN  `program_start_end_date_tbl`
            ON
                `program_start_end_date_tbl`.`user_area_id`  = `user_area_tbl`.`user_area_id`
                
            WHERE
                `admin`.`administration_type_id` = 5 AND `user_area_tbl`.`user_area_id` =(
                    SELECT
                MAX(`user_area_id`)
            FROM
                `user_area_tbl`
                inner join `area_tbl` USING (`area_id`)
            WHERE
                `user_id` = admin.`administration_id` AND `area_tbl`.`capital_id` =  '$capital_id' )  and  `program_start_end_date_tbl`.`program_active` = $id "; 
        // echo  "<p>".$query."</p><br/>";      
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $count_num =  $row['counter'];
        }
        return  $count_num;
    }

    public function get_num_user_website_app($id)
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
    public function get_number_subscriber_where_id($id)
    {   

        $hold = 0;
        $active = 0;
        $nonactive = 0;
        $totaluser = 0;

         
            // $user_sql  = "SELECT *, (SELECT  `program_duration`  FROM `program_tbl` WHERE `program_id` = `user_area_tbl`.`program_id` )  as  program_duration
            //         FROM
            //         `user_area_tbl`
            //         INNER JOIN `administration_tbl` AS admin
            //         ON
            //         `user_area_tbl`.`user_id` = `admin`.`administration_id`
            //         INNER JOIN  `program_start_end_date_tbl`
            //         ON
            //         `program_start_end_date_tbl`.`user_area_id`  = `user_area_tbl`.`user_area_id`
                    
            //         WHERE
            //         `admin`.`administration_type_id` = 5 AND `user_area_tbl`.`user_area_id` =(
            //         SELECT
            //             MAX(`user_area_id`)
            //         FROM `user_area_tbl` WHERE `user_id` = `admin`.`administration_id` )";
        
    
            // mysqli_set_charset($this->con, "utf8");
            // $rs = mysqli_query($this->con, $user_sql);
            


            // while ($arr = mysqli_fetch_array($rs)) { 
            //     $totaluser++;

            //     if ($arr['program_active'] == 3){
            //         $hold++;
            //     }

            //     // Skip hold values
            //     if ($arr['program_active'] != 3){
            //         // Future date >= current date 
            //         if (  $arr['program_start_end'] >= date("Y-m-d")  ){
            //             $active++;
            //         }
            //         else {
            //             $nonactive++;
            //         }
            //     }
            // }

            // $final_active = 0;
            // date_default_timezone_set('Asia/Kuwait');
            // $new_date = date('Y-m-d 00:00:00');
            // require_once("TodayOrderController.php");
            // require_once("./Model/ProgramModel.php");
            // include_once('./lang/' . $_SESSION['lang'] . '.php');
            // $date_model = new program_model();
            // $order_controller = new today_order_controller($this->con);
            // $pre_arr         =   $order_controller->select_pro();
            // // echo $pre_arr;
            // if(is_array($pre_arr)){
            // if(count($pre_arr) > 0){
            //     for($i=0;$i<count($pre_arr);$i++){
            //         $date =  date("Y-m-d");
            //         // $count_num     =   $order_controller->get_num_order_where_area_id($pre_arr[$i]['capital_id'],$date);
            //         $pre_str       = ($_SESSION['lang'] == "en") ? $pre_arr[$i]['capital_en_title'] : $pre_arr[$i]['capital_ar_title'];
            //         $counter_order = $order_controller->get_num_order_where_area_id($new_date,$pre_arr[$i]['capital_id']); 
            //         $capital_id = base64_encode($pre_arr[$i]['capital_id']);
                    
            //         $final_active += (int)$counter_order['counter'];
            //         }
                
            //     }
            // }

        // $nonactive = $totaluser - ($final_active + $hold);

        return  array($totaluser,$active,$hold,$nonactive);

    


        // $count_num = 0;
        // $prog_obj = NULL;
        // mysqli_set_charset($this->con, "utf8");
        // // $query = "SELECT admin.`administration_id`,(SELECT `program_active` FROM `program_start_end_date_tbl` WHERE `user_area_id` = ( SELECT MAX(`user_area_id`) FROM `user_area_tbl`  WHERE `user_id` = admin.`administration_id` ) and  `program_start_end_date_tbl`.`program_active` = $id ) AS program_duration FROM `administration_tbl` AS admin WHERE `administration_type_id` = 5 "; 
        // // echo  "<pre>".$query."</pre><br/>";
        // $query = "SELECT
        // COUNT(*) as  counter 
        //     FROM
        //         `user_area_tbl`
        //     INNER JOIN `administration_tbl` AS admin
        //     ON
        //         `user_area_tbl`.`user_id` = `admin`.`administration_id`
        //     INNER JOIN  `program_start_end_date_tbl`
        //     ON
        //         `program_start_end_date_tbl`.`user_area_id`  = `user_area_tbl`.`user_area_id`
                
        //     WHERE
        //         `admin`.`administration_type_id` = 5 AND `user_area_tbl`.`user_area_id` =(
        //         SELECT
        //             MAX(`user_area_id`)
        //         FROM
        //             `user_area_tbl`
        //         WHERE
        //             `user_id` = `admin`.`administration_id` ) and  `program_start_end_date_tbl`.`program_active` = $id "  ;
        //             // echo  $query ;

        // $result = mysqli_query($this->con, $query);
        // while ($row = mysqli_fetch_array($result)) {
  
        //      $count_num = $row['counter'];
             
        // }
        // return  $count_num;
    }

    public function get_total_subscriber(){
        $date_query = "";
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT
                COUNT(*) as  counter 
                    FROM
                        `user_area_tbl`
                    INNER JOIN `administration_tbl` AS admin
                    ON
                        `user_area_tbl`.`user_id` = `admin`.`administration_id`
                    INNER JOIN  `program_start_end_date_tbl`
                    ON
                        `program_start_end_date_tbl`.`user_area_id`  = `user_area_tbl`.`user_area_id`
                        
                    WHERE
                        `admin`.`administration_type_id` = 5 AND `user_area_tbl`.`user_area_id` =(
                        SELECT
                            MAX(`user_area_id`)
                        FROM
                            `user_area_tbl`
                        WHERE
                            `user_id` = `admin`.`administration_id` )";
    
       // echo   $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['counter']          = $row['counter'];
        }

        return $prog_obj['counter'] ;
    }
    
    
}
