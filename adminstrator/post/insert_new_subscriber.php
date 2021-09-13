<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] .'.php';
date_default_timezone_set('Asia/Kuwait');
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['RealUserName']) && !empty($_POST['Telephone']) &&  ($_POST['area_id'] != "0") &&  !empty($_POST['program_name']) && ($_POST['program_name'] != "0")) {
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
            $myObj->result  = "5";
            $myObj->message = $languages['cap_page']['renew'];
            $myJSON = json_encode($myObj); 
        } else {
            require_once '../Configuration/db.php';
            require_once '../lang/'.$_SESSION['lang'].'.php';
            $UserName           = "";
            $branch_id          = "";
            $Password           = "";
            $RealUserName       = $_POST['RealUserName'];
            $Telephone          = $_POST['Telephone'];
            $Telephone2         = $_POST['Telephone2'];
            $program_id_duration   = explode("&&",$_POST['program_name']);
            $program_id           = $program_id_duration[0];
            $duration_day         = $program_id_duration[1];
   
            // insert program 
            require_once("../Controller/ProgramController.php");
            require_once("../Controller/DayController.php");
            require_once("../Model/ProgramModel.php");
            require_once("../Model/ProgramDayModel.php");
            require_once("../Configuration/db.php");
            $date_model  = new program_model();
            $controller  = new program_controller($date_model, $con);
            
            $program_day = new program_day_model();
            $day_controller  = new day_controller($program_day, $con);

            require_once("../Controller/UserAddressController.php");
            require_once("../Model/UserModel.php");
            $UserName          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
            $Password          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
            $user_model        = new user_model();
        
            $user_address_controller = new user_address_controller($user_model, $con);
            $user_model->set_administration_username($UserName);
            $user_model->set_administration_password($Password);

            if($user_address_controller->search_username_password_register() > 0){
                $myObj->result  = "5";
                $myObj->message = $languages['cap_page']['username_password'];
                $myJSON = json_encode($myObj); 
                echo  $myJSON; 
            }else{

            mysqli_set_charset($con, "utf8");

            date_default_timezone_set("Asia/Kuwait");
            $registered_time = date("Y-m-d h:i:sa");
            $query  = "INSERT INTO `administration_tbl` (`administration_name`,`administration_type_id`, `administration_active`,`administration_telephone_number`,`administration_telephone_number1`, `administration_date_registeration`, `administration_username`, `administration_password`) VALUES ('$RealUserName','5','1','$Telephone','$Telephone2','$registered_time','$UserName','$Password')";
            // echo  $query;
            $rs     = mysqli_query($con, $query);
            if ($rs) {
                $adminstrator_id = mysqli_insert_id($con);
                if ($adminstrator_id > 0) {
                    mysqli_set_charset($con, "utf8");
                    switch ($place_id) {
                        case 1:
                            $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`, `user_area_house_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`,`user_area_floor`, `user_area_apartment_num`)
                            VALUES ('$_POST[area_id]','$adminstrator_id','$place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[house_no]','$_POST[figure]','$_POST[note]','$program_id','$_POST[floor]','$_POST[apart_num]')";
                            //echo  $user_area_query ;
            
                            break;
                        case 2:
                            $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`,`user_area_building_num`, `user_area_floor`, `user_area_apartment_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`)
                            VALUES ('$_POST[area_id]','$adminstrator_id',' $place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[apart_num]','$_POST[figure]','$_POST[note]','$program_id')";
                            // echo  $user_area_query ;
            
                           
                            break;
                        case 3:
                            $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`,`user_area_block`, `user_area_street`, `user_area_avenue`,`user_area_building_num`, `user_area_floor`, `user_area_office_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`)
                            VALUES ('$_POST[area_id]','$adminstrator_id','$place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[office_num]','$_POST[figure]','$_POST[note]','$program_id')";
            
                           
                            break;
                    }
                    $rs     = mysqli_query($con, $user_area_query);
                    // get last id from table to add program 
                    
                    $result = mysqli_query($con," SELECT max(`user_area_id`) as max FROM `user_area_tbl`");
                    $row = mysqli_fetch_row($result);
                    $date_model->program_id  = $row[0];
//                     // insert Program date and time 
//                     //echo "here";
                    
                    if(empty($_POST['date_start'])){
                        $date_model->start_date = date('Y-m-d', strtotime(' +1 day'));

                        $total_num = $duration_day;
                        $z = 0;
                        $x = 0;
                        $i = strtotime($date_model->start_date);
                        //print_r($i);
                        do {
                           
                            // loop for date 
                            $timestamp = strtotime(date('Y-m-d',$i));
                            $day       = date('D', $timestamp);
                            $arr       = array('Thu'); // get out from week stauday and friday 
                            if(!in_array($day,$arr)) {
                                $day_array[$z++] = $day."_".date('Y-m-d 00:00:00',$i); // add all days inside array
                                $x++;
                            } 
                             $i = $i + 86400; 
                            //echo $i;
                        } while ($total_num > $x);

                    }else{
                        $date_model->start_date = date('Y-m-d',strtotime($_POST['date_start']));

                        $total_num = $duration_day;
                        $z = 0;
                        $x = 0;
                        $i = strtotime($date_model->start_date);
                        //print_r($i);
                        do {
                            // loop for date 
                            $timestamp = strtotime(date('Y-m-d',$i));
                            $day       = date('D', $timestamp);
                            $arr       = array('Thu'); // get out from week stauday and friday 
                            if(!in_array($day,$arr)) {
                                $day_array[$z++] = $day."_".date('Y-m-d 00:00:00',$i); // add all days inside array
                                $x++;
                            } 
                            $i = $i + 86400; 
                            
                            //echo $i;
                        } while ($total_num > $x);
                    }
                    //$date_model->end_date   = date('Y-m-d', strtotime("+".$duration_day." day", strtotime($date_model->start_date)));
                    // $date_model->end_date;

                    $last_id = count($day_array)-1;
                    $last_date_arr = explode("_",$day_array[$last_id]);
                    $sep_date      =   explode(" 00:00:00",$last_date_arr[1]);
                    // last date from last array
                    $date_model->end_date   = date('Y-m-d',strtotime($sep_date[0]));
                    $controller->insert_program_date();
                    $last_start_end_date = $controller->last_id_inserted_date_time();

                    for($counter = 0 ;$counter <count($day_array);$counter++){
                        $day_name = explode("_",$day_array[$counter]);

                           // print_r($day_name);
                            $program_day->day_en      = $day_name[0]; //english day 
                            $program_day->day_ar      = $day_name[0]; //english day 
                            $program_day->date        = $day_name[1]; //date  
                            $program_day->program_id  = $last_start_end_date['max']; // last id from start and end date 
                            // insert days for program 
                           $day_controller->insert_day_time_table();
                    }
                    $myObj->result  = "1";
                    $myObj->message =  $languages['area_page']['succe_ms'];
                    $myJSON = json_encode($myObj);
                    echo  $myJSON; 
            
                } else {
                    $myObj->result  = "3";
                    $myObj->message = $languages['area_page']['empty_field'];
                    $myJSON = json_encode($myObj); 
                    echo  $myJSON; 
              
                }
            } else {
                $myObj->result  = "4";
                $myObj->message = $languages['area_page']['empty_field'];
                $myJSON = json_encode($myObj); 
                echo  $myJSON; 
             
            }
         }

       
    }
    } else {
        $myObj->result  = "5";
        $myObj->message = $languages['cap_page']['empty_field'];
        $myJSON = json_encode($myObj); 
        echo  $myJSON; 
    }
} else {
    header('Location: index.php?err=1');
    exit();
    session_destroy();
}



?>