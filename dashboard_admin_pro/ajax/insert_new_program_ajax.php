<?php
//insert_new_program_ajax.php
session_start();
// header('Content-type: text/html; charset=utf-8');
error_reporting(0);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
  if (isset($_POST['user_area_id'])) {
  require_once('../lang/'.$_SESSION['lang'].'.php');
  require_once("../Controller/ProgramController.php");
  require_once("../Model/ProgramModel.php");
  require_once("../Configuration/db.php");
  $date_model = new program_model();
  $controller = new program_controller($date_model, $con);


    // insert program 
    require_once("../Controller/ProgramController.php");
    require_once("../Controller/DayController.php");
    require_once("../Model/ProgramModel.php");
    require_once("../Model/ProgramDayModel.php");
    require_once("../Configuration/db.php");
    
    $program_day = new program_day_model();
    $day_controller  = new day_controller($program_day, $con);
    
    $id = $_POST['id'];

    $controller->user_id =   $id;
    $fetch_program       = $controller->get_all_program();

    // echo "here 4.<br/>";
    $user_area_id =  $_POST['user_area_id'];
    if (is_numeric($user_area_id)) {
      $controller->user_area_id = $user_area_id;
      // fetch date from payment method
      $payment_sql   = "SELECT   `program_start_date`,`program_start_end_date_id`,`program_start_end` FROM `program_start_end_date_tbl` WHERE `user_area_id` =  '$user_area_id' ";
      $payment_query = mysqli_query($con,$payment_sql);
      $payment_row   = mysqli_fetch_row($payment_query);

      $date = date("Y-m-d");
      // update Adminstrator  
      $user_info_sql    = "UPDATE `administration_tbl` SET `administration_active` = '1', 
                                                    `administration_updated` = '$date' 
                                                    WHERE `administration_tbl`.`administration_id` = '$id' ";
      $user_info_query = mysqli_query($con,$user_info_sql);
     // echo $user_info_sql;
   
      // set property start date and end date 
      $date_model->start_date = $payment_row[0];
      $duration_day           = $_POST['duration_day'];
      $date_model->end_date   = $payment_row[2];

      
      $last_start_end_date    = $payment_row[1];
      $date_model->user_id    = $id;
      //return list of day from start date and end date 
       $day_array =  array();
       $z = 0;
        // select days without friday and starday
        $startTime = strtotime($date_model->start_date);
        $endTime   = strtotime($date_model->end_date);
        for ($i = $startTime;$i<=$endTime; $i = $i + 86400 ) {
            $timestamp = strtotime(date('Y-m-d',$i));
           // echo $timestamp."<br/>";
            $day = date('D', $timestamp);
            $arr = array('Thu'); // get out from week stauday and friday 
            if(!in_array($day,$arr)) {
               $day_array[$z++] = $day."_".date('Y-m-d 00:00:00',$i); // add all days inside array 
            }
        }
        // print_r($day_array);

        
           // leave two day from array for reset
           for($counter = 0 ;$counter <count($day_array);$counter++){
              $day_name = explode("_",$day_array[$counter]);
              $program_day->day_en      = $day_name[0]; //english day 
              $program_day->day_ar      = $day_name[0]; //english day 
              $program_day->date        = $day_name[1]; //date  
              $program_day->program_id  =  $last_start_end_date; // last id from start and end date 
              // insert days for program 
              $day_controller->insert_day_time_table();
          }
          
        $myObj->result  = "1";
        $myObj->message = $languages['cap_page']['renew'];
        $myJSON = json_encode($myObj);
        echo  $myJSON;
     
    }
  } else {
    $myObj->result  = "2";
    $myObj->message = $languages['cap_page']['error'];
    $myJSON = json_encode($myObj);
    echo  $myJSON;
  }
}

?>