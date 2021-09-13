<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
include_once('../dashboard_admin/lang/' . $_SESSION['lang'] . '.php');
date_default_timezone_set('Asia/Kuwait');
if (
    !empty($_POST['RealUserName'])
    && !empty($_POST['Telephone'])
    &&  $_POST['area_id'] != "0"
    &&  !empty($_POST['program_name'])
    &&  !empty($_POST['start_date'])
) {
    $place_id = $_POST['place_id'];
    if (empty($_POST['place_id'])) {
        $place_id = 1;
    }
    $required = array('block_number', 'street_number', 'house_no');
    switch ($_POST['place_id']) {
        case 1:
            $required = array('block_number', 'street_number', 'house_no');
            break;
        case 2:
            $required = array('block_number', 'street_number', 'building_num', 'floor', 'apart_num');
            break;
        case 3:
            $required = array('block_number', 'street_number', 'building_num', 'floor', 'office_num');
            break;
    }
    $error = false;
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $error = true;
        }
    }
    if ($error) {
        $myObj->result  = "8";
        $myObj->message = $languages['cap_page']['renew'];
        $myJSON = json_encode($myObj);
    }else{
        if($_POST['start_date'] >=  date("Y-m-d")){
            //gerneate random number for order ID 
            $passwordChar = '1234567890';
            $passwordLength = rand (15 , 30) ;
            $max = strlen($passwordChar) - 1;
            $number = '';
            $number1 = '';
            for ($i = 0; $i < $passwordLength; ++$i) {
                $number .= $passwordChar[random_int(0, $max)];
            }

            for ($i = 0; $i < $passwordLength; ++$i) {
                $number1 .= $passwordChar[random_int(0, $max)];
            }


            require_once '../dashboard_admin/Configuration/db.php';
            require_once '../dashboard_admin/lang/' . $_SESSION['lang'] . '.php';
            $UserName           = "";
            $branch_id          = "";
            $Password           = "";
            $RealUserName       = $_POST['RealUserName'];
            $Telephone          = $_POST['Telephone'];
            $Telephone2         = $_POST['Telephone2'];
            $start_date         = $_POST['start_date'];
            $program_id_duration   = explode("&&", $_POST['program_name']);
            $program_id           = $program_id_duration[0];
            $duration_day         = $program_id_duration[1];
    
            require_once("../dashboard_admin/Controller/UserAddressController.php");
            require_once("../dashboard_admin/Controller/ProgramController.php");
            require_once("../dashboard_admin/Controller/DayController.php");
            require_once("../dashboard_admin/Model/ProgramModel.php");
            require_once("../dashboard_admin/Model/ProgramDayModel.php");
    
            mysqli_set_charset($con, "utf8");
            $user_address_controller = new user_address_controller($user_model, $con);
    
            date_default_timezone_set("Asia/Kuwait");
            $registered_time = date("Y-m-d h:i:sa");
            $query  = "INSERT INTO `administration_tbl` (`administration_name`,`administration_type_id`, 
                    `administration_active`,`administration_telephone_number`,`administration_telephone_number1`, 
                    `administration_date_registeration`, `administration_username`, `administration_password`, `administration_start_day`) 
                               VALUES ('$RealUserName','5','4','$Telephone','$Telephone2','$registered_time','$UserName','$Password','$start_date')";
            //echo $query;
            $rs     = mysqli_query($con, $query);
            $adminstrator_id = mysqli_insert_id($con);
    
    
            switch ($place_id) {
                case 1:
                    $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`, `user_area_house_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`,`user_area_order_id`)
                        VALUES ('$_POST[area_id]','$adminstrator_id','$place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[house_no]','$_POST[figure]','$_POST[note]','$program_id','$number')";
                   // echo  $user_area_query ;
    
                    break;
                case 2:
                    $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`,`user_area_building_num`, `user_area_floor`, `user_area_apartment_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`,`user_area_order_id`)
                        VALUES ('$_POST[area_id]','$adminstrator_id',' $place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[apart_num]','$_POST[figure]','$_POST[note]','$program_id','$number')";
                    //echo  $user_area_query ;
    
    
                    break;
                case 3:
                    $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`,`user_area_block`, `user_area_street`, `user_area_avenue`,`user_area_building_num`, `user_area_floor`, `user_area_office_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`,`user_area_order_id`)
                        VALUES ('$_POST[area_id]','$adminstrator_id','$place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[office_num]','$_POST[figure]','$_POST[note]','$program_id','$number')";
                //echo $user_area_query;    
                break;
            }
            $rs       = mysqli_query($con, $user_area_query);
            $last_id  = mysqli_insert_id($con);
            if ($rs) {
                // $program_id 
                // get price 
                $price = 0;
                $program_sql = "SELECT  `program_cost`, `program_discount`, `program_active` FROM `program_tbl` WHERE  `program_id` =  $program_id";
                if ($program_result = mysqli_query($con, $program_sql)) {
                    // Fetch one and one row
                        while ($program_row = mysqli_fetch_row($program_result)) {
                            $price = $program_row[0];
                           if(!empty($program_row[1])){
                                $price = $program_row[1];
                           }
                        }
                   
                    }


                $date = date("Y-m-d");
                $time = date("h:i:sa");
                $payment_query     = "INSERT INTO `payment_tbl` (`payment_id`, `payment_order_id`, `payment_date`, `payment_time`, `payment_status_id`, `user_area_id`, `paymentId`,`payment_price`) 
                                                            VALUES (NULL, '$number', '$date', '$time', '1', '$last_id','$number1','$price')";
                //  echo $payment_query;
                $payment_process  = mysqli_query($con, $payment_query);
          
                $_SESSION['order'] = $number;
                $myObj->result  = "1";
                $myObj->url     =  $languages['url']['post_url']."?order_id=".$number;

                $myJSON = json_encode($myObj);
                echo  $myJSON;
            } else {
                $myObj->result  = "2";
                $myObj->message =  $languages['area_page']['empty_field'];
                $myJSON = json_encode($myObj);
                echo  $myJSON;
            }    

        }else{
            $myObj->result  = "10";
            $myObj->message = $languages['website']['wrong_msg_day'];
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
      
    }
} else {
    $myObj->result  = "5";
    $myObj->message = $languages['cap_page']['empty_field'];
    $myJSON = json_encode($myObj);
    echo  $myJSON;
}
