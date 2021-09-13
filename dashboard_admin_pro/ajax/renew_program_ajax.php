<?php
//renew_program_ajax
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
    
    $id = base64_decode($_POST['id']);

    $controller->user_id =   $id;
    $fetch_program = $controller->get_all_program();

    // echo "here 4.<br/>";
    $user_area_id =  base64_decode(base64_decode(base64_decode($_POST['user_area_id'])));
    if (is_numeric($user_area_id)) {
      $controller->user_area_id = $user_area_id;
      // get last end-date for renew 
      $last_end_date = "SELECT  `program_start_end` FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` WHERE  `user_id` = '$id' ) ";
     // echo $last_end_date."<br/>";
      if ($result = mysqli_query($con, $last_end_date)) {
        // Fetch one and one row
        while ($row = mysqli_fetch_row($result)) {
          $date_model->start_date = date('Y-m-d', strtotime('+1 day', strtotime($row[0])));
        }
        mysqli_free_result($result);
      }
      // set start and end date for program 
      $duration_day           = $_POST['duration_day'];
      $date_model->end_date   = date('Y-m-d', strtotime("+".$duration_day." day", strtotime($date_model->start_date)));
      $date_model->user_id    = $id;

      // echo $date_model->end_date."<br/>";
    
      // if ($current_program_arr == 0) {
        $controller->process      = "renew";
        $date_model->program_id  = $controller->renew_current_program();
        $controller->insert_program_date();
        
        $day_array =  array();
          $z = 0;
          // select days without friday and starday
          $startTime = strtotime($date_model->start_date);
          $endTime   = strtotime($date_model->end_date);

          for ($i = $startTime;$i<$endTime; $i = $i + 86400 ) {
            $timestamp = strtotime(date('Y-m-d',$i));
            $day = date('D', $timestamp);
            $arr = array('Thu'); // get out from week stauday and friday 
            if(!in_array($day,$arr)) {
              $day_array[$z++] = $day."_".date('Y-m-d 00:00:00',$i); // add all days inside array 
            }
          }

        $last_start_end_date = $controller->last_id_inserted_date_time();
           // leave two day from array for reset
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
