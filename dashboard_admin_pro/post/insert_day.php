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
        mysqli_set_charset($con,"utf8");
        $query  = "INSERT INTO `program_day_tbl` (`program_day_id`, `program_day_en`, `program_day_ar`, `program_day_date`, `program_start_end_date_id`, `program_day_flag`) 
                     VALUES (NULL, '$program_day_en', '$program_day_en', '$date', '$id', '1');";
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

} else {
     header('Location: index.php?err=1');
    exit();
    session_destroy();
}



?>