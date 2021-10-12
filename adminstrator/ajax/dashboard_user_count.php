<?php

require_once('../Configuration/db.php');
$hold = 0;
$active = 0;
$nonactive = 0;
$totaluser = 0;
$final_active = 0;

$user_sql  = "SELECT *, (SELECT  `program_duration`  FROM `program_tbl` WHERE `program_id` = `user_area_tbl`.`program_id` )  as  program_duration
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
                    FROM `user_area_tbl` WHERE `user_id` = `admin`.`administration_id` )";
        
    
            mysqli_set_charset($con, "utf8");
            $rs = mysqli_query($con, $user_sql);
            

            while ($arr = mysqli_fetch_array($rs)) { 
                $totaluser++;

                if ($arr['program_active'] == 3){
                    $hold++;
                }
                // Skip hold values
                if ($arr['program_active'] != 3){
                    // Future date >= current date 
                    if (  $arr['program_start_end'] >= date("Y-m-d")  ){
                        $active++;
                    }
                    else {
                        $nonactive++;
                    }
                }
            }





date_default_timezone_set('Asia/Kuwait');
$new_date = date('Y-m-d 00:00:00');
require_once("../controller/TodayOrderController.php");
require_once("../Model/ProgramModel.php");
include_once('../lang/' . $_SESSION['lang'] . '.php');


$date_model = new program_model();
$order_controller = new today_order_controller($con);
$pre_arr         =   $order_controller->select_pro();

if(is_array($pre_arr)){
    if(count($pre_arr) > 0){
        // for($i=0;$i<count($pre_arr);$i++){
        //     $date =  date("Y-m-d");
        //     // $count_num     =   $order_controller->get_num_order_where_area_id($pre_arr[$i]['capital_id'],$date);
        //     $pre_str       = ($_SESSION['lang'] == "en") ? $pre_arr[$i]['capital_en_title'] : $pre_arr[$i]['capital_ar_title'];
        //     $counter_order = $order_controller->get_num_order_where_area_id($new_date,$pre_arr[$i]['capital_id']); 
        //     $capital_id = base64_encode($pre_arr[$i]['capital_id']);
            
        //     $final_active += (int)$counter_order['counter'];
        //     }
        
        }
    }

$nonactive = $totaluser - ($final_active + $hold);

$data['status'] = 'ok';
$data['totaluser'] = $totaluser;
$data['nonactive'] = $nonactive;
$data['active'] = $final_active;
$data['hold'] = $hold;

echo json_encode($data);

// it will take 53 sec to return data.

//     $totaluser = 100;
//     $active = 20;
//     $hold = 10;
//     $nonactive = 70;
//     return  array($totaluser,$active,$hold,$nonactive);



?>