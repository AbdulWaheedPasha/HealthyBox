<?php
//update_subscriber
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] .'.php';
date_default_timezone_set('Asia/Kuwait');
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['RealUserName']) && !empty($_POST['Telephone']) && !empty($_POST['username']) && !empty($_POST['password'])  ) {
        $place_id = $_POST['place_id'];
        // if (empty($_POST['place_id'])) {
        //     $place_id = 1;
        // }
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
            if($_POST['area_id'] == 0 )
            {
                $area_id =  $_POST['old_area_id'];
            }else{
                $area_id = $_POST['area_id'];
            }
            $user_id           =  $_POST['user_id'];
            // insert program 
            require_once("../Controller/ProgramController.php");
            require_once("../Controller/UserAddressController.php");
            require_once("../Controller/DayController.php");
            require_once("../Model/ProgramModel.php");
            require_once("../Model/ProgramDayModel.php");
            require_once("../Configuration/db.php");
            require_once("../Model/UserModel.php");
            $date_model  = new program_model();
           
            $controller  = new program_controller($date_model, $con);
            
            $program_day = new program_day_model();
            $day_controller  = new day_controller($program_day, $con);

            $UserName          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
            $Password          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
            $user_model        = new user_model();
            
            $user_address_controller = new user_address_controller($user_model, $con);
            $user_model->set_user_id($user_id);
            $user_model->set_administration_username($UserName);
            $user_model->set_administration_password($Password);

            if($user_address_controller->search_username_password() > 0){
                $myObj->result  = "5";
                $myObj->message = $languages['cap_page']['username_password'];
                $myJSON = json_encode($myObj); 
                echo  $myJSON; 
            }else{
                
            mysqli_set_charset($con, "utf8");
       
           
            $user_area_id      =  $_POST['user_area_id'];

            date_default_timezone_set("Asia/Kuwait");
            $registered_time = date("Y-m-d h:i:sa");
            $query  = "UPDATE `administration_tbl` SET `administration_name`= '$RealUserName',
                                                        `administration_username`='$UserName',
                                                        `administration_password`='$Password',
                                                        `administration_telephone_number`='$Telephone',
                                                        `administration_telephone_number1`='$Telephone2' where `administration_id` = $user_id";
            // echo  $query;
            $rs     = mysqli_query($con, $query);
            if ($rs) {
                $adminstrator_id = $user_id;
                if ($adminstrator_id > 0) {
                    mysqli_set_charset($con, "utf8");
                    switch ($place_id) {
                        case 1:
                            $user_area_query = "UPDATE `user_area_tbl` SET `area_id`='$area_id',`user_id`='$adminstrator_id',`place_id`='$place_id',`user_area_block`='$_POST[block_number]',`user_area_street`='$_POST[street_number]',`user_area_avenue`='$_POST[avenus_number]',`user_area_house_num`='$_POST[house_no]',`user_area_automated_figure`='$_POST[figure]',`user_area_notes`='$_POST[note]',`user_area_floor` = '$_POST[floor]', `user_area_apartment_num` ='$_POST[apart_num]' where `user_area_id` = '$user_area_id' ";
                        //echo $user_area_query;
                        break;
                        case 2:
                            // $user_area_query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`,`user_area_building_num`, `user_area_floor`, `user_area_apartment_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`)
                            // VALUES ('$_POST[area_id]','$adminstrator_id',' $place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[apart_num]','$_POST[figure]','$_POST[note]','$program_id')";
                            // echo  $user_area_query ;
                            $user_area_query =  "UPDATE `user_area_tbl` SET  `area_id`='$area_id',`user_id`='$adminstrator_id',`place_id`='$place_id',`user_area_block`='$_POST[block_number]',`user_area_street`='$_POST[street_number]',`user_area_avenue`='$_POST[avenus_number]',`user_area_building_num`='$_POST[building_num]',`user_area_floor` = '$_POST[floor]', `user_area_apartment_num` ='$_POST[apart_num]' ,`user_area_automated_figure`='$_POST[figure]',`user_area_notes`='$_POST[note]'  where `user_area_id` = '$user_area_id' ";
                            //echo  $user_area_query;
                           
                            break;
                        case 3:
                            // `user_area_building_num`, `user_area_floor`, `user_area_office_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`)
                            // VALUES ('$_POST[area_id]','$adminstrator_id','$place_id','$_POST[block_number]','$_POST[street_number]','$_POST[avenus_number]','$_POST[building_num]','$_POST[floor]','$_POST[office_num]','$_POST[figure]','$_POST[note]','$program_id')";
                            $user_area_query =  "UPDATE `user_area_tbl` SET  `area_id`='$area_id',`user_id`='$adminstrator_id',`place_id`='$place_id',`user_area_block`='$_POST[block_number]',`user_area_street`='$_POST[street_number]',`user_area_avenue`='$_POST[avenus_number]',`user_area_building_num`='$_POST[building_num]',`user_area_floor` = '$_POST[floor]', `user_area_office_num` ='$_POST[office_num]' ,`user_area_automated_figure`='$_POST[figure]',`user_area_notes`='$_POST[note]'  where `user_area_id` = '$user_area_id' ";
                          //  echo  $user_area_query;
                        break;
                    }
                    $rs     = mysqli_query($con,$user_area_query);
                    
                    $myObj->result  = "1";
                    $myObj->message =  $languages['area_page']['update_succe_ms'];
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