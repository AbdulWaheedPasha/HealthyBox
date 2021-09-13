<?php
session_start();
error_reporting(0);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once("../Configuration/db.php");
    require_once('../lang/'.$_SESSION['lang'] . '.php');
    require_once("../Controller/CommentsController.php"); 
    $user_area_id =  base64_decode(base64_decode(base64_decode($_POST['user_area_id'])));
    $id           =  base64_decode($_POST['user_id']);
    $program_sql  = "SELECT `program_start_end_date_id` FROM `program_start_end_date_tbl` WHERE `user_area_id` = '$user_area_id' ";

    // echo  $program_sql;
    $program_result = mysqli_query($con, $program_sql);
      // Fetch one and one row
      while ($program_row = mysqli_fetch_row($program_result)) {
        // echo $row[0];
        $delete_query   = "DELETE FROM `program_day_tbl` WHERE `program_start_end_date_id` =  $program_row[0] ";
        //echo $delete_query."<br/>";
        //// delete days for user 
        $delete_result  = mysqli_query($con, $delete_query);
        
        if($delete_result){
            // update status user 
            $date = date("Y-m-d");
            $user_info_sql    = "UPDATE `administration_tbl` SET `administration_active` = '5',`administration_updated` = '$date'  WHERE `administration_tbl`.`administration_id` = '$id' ";
            //echo $user_info_sql."<br/>";
            $user_info_query = mysqli_query($con,$user_info_sql);

            $myObj->result  = "1";
            $myObj->message = $languages['order']['delete_user_info'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        }else{
            $myObj->result  = "2";
            $myObj->message = $languages['cap_page']['error'];
            $myJSON         = json_encode($myObj);
            echo  $myJSON;   
    
        }
      }
  } else {
    $myObj->result  = "2";
    $myObj->message = $languages['cap_page']['error'];
    $myJSON = json_encode($myObj);
    echo  $myJSON;
  }

?>