<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
        require_once '../Configuration/db.php';
        $id               = $_POST['user_area_id'];
        $max_id = 0;
        $last_date_query = "SELECT max(`program_day_date`) as max_id FROM `program_day_tbl` where `program_start_end_date_id` = $id ";
        if ($result = mysqli_query($con, $last_date_query)) {
            while ($row = mysqli_fetch_row($result)) {
                $max_id = $row[0];
            }
            mysqli_free_result($result);
          }
          $id               = $_POST['user_area_id'];
          $date             = ($max_id  == 0) ? date('Y-m-d', strtotime(' +1 day')) : date('Y-m-d', strtotime('+1 day', strtotime($max_id)));
        $program_day_en     = date('D', strtotime($date));
        $program_day_ar     = date('D', strtotime($date));
        //echo $program_day_en;
        if($program_day_en == "Thu"){
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            $program_day_en     = date('D', strtotime($date));
            $program_day_ar     = date('D', strtotime($date));
            // echo  $program_day_en;
          
        }
        $date             = $date ." 00:00:00";
        $end_date_query   = "UPDATE `program_start_end_date_tbl` SET `program_start_end` = '$date' WHERE `program_start_end_date_id` = '$id'";
        $end_date_rs 	  = mysqli_query($con, $end_date_query);

        $hold_pointer = 1;

        $hold_query = "SELECT `program_active` FROM `program_start_end_date_tbl` WHERE `program_start_end_date_id` = $id ";
        // echo $hold_query;
            $hold_result1 = mysqli_query($con, $hold_query);
            while ($hold_row = mysqli_fetch_row($hold_result1)){
                if($hold_row[0] == 3 || $hold_row[0] == 2){
                    $myObj->result  = "3";
                    $myObj->message =  $languages['area_page']['hold_user'];
                    $myJSON = json_encode($myObj); 
                    echo  $myJSON; 
                }else{

                    mysqli_set_charset($con,"utf8");
                    $query  = "INSERT INTO `program_day_tbl` (`program_day_id`, `program_day_en`, `program_day_ar`, `program_day_date`, `program_start_end_date_id`, `program_day_flag`) 
                                 VALUES (NULL, '$program_day_en', '$program_day_en', '$date', '$id', '0');";
                    $rs 	= mysqli_query($con, $query);
                    if ($rs) {
                        $myObj->result  = "1";
                        $myObj->message =  $languages['area_page']['succe_ms'];
                        $myJSON = json_encode($myObj);
                        echo  $myJSON; 
                    }
                     else {
                        $myObj->result  = "2";
                        $myObj->message =  $languages['area_page']['empty_field'];
                        $myJSON = json_encode($myObj); 
                        echo  $myJSON; 
                     }

                }
            }
       
        
     

} else {
     header('Location: index.php?err=1');
    exit();
    session_destroy();
}



?>