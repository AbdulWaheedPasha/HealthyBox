<?php
    session_start();
    error_reporting(0);
    ini_set('display_errors', 0);
    if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once('../lang/' . $_SESSION['lang'] . '.php');
    if(isset($_POST)){
        //print_r($_POST);
        if (isset($_POST['user_id'])){
            require_once('../lang/'.$_SESSION['lang'].'.php');
            require_once("../Controller/HoldController.php");
            require_once("../Controller/AdminstratorController.php");
            require_once("../Controller/ProgramController.php");
            require_once("../Configuration/db.php");
            require_once("../Model/ProgramModel.php");
            require_once("../Controller/DayController.php");
            require_once("../Model/ProgramDayModel.php");
            $user_id = $_POST['user_id'];
            $date_model = new program_model();
            $controller = new hold_controller($con);
            $adminstrator_controller = new adminstrator_controller($con);
            $program_controller      = new program_controller($date_model,$con);
            $program_day             = new program_day_model();
            $day_controller          = new day_controller($program_day, $con);
            
            $adminstrator_controller->update_status_user(1,$user_id);
            $user_area_id = $_POST['user_area_id'];

            $hold_date       = date("Y-m-d");
            $num_days_arr    = $controller->get_hold_program($user_area_id);
           // $num_arr_int     = $num_days_arr['hold_date_num_days'];
            $last_renew_date =  $controller->get_last_renew_date($user_area_id);
            //start date 
            // $date_model->start_date = date("Y-m-d");

            $duration_day = 0;
  
        
            $num_day_sql = "SELECT `hold_date_num_days` FROM `hold_date_tbl` WHERE `user_area_id` = '$user_area_id' ";
            //echo $num_day_sql."<br/>";
             if ($num_day_result = mysqli_query($con, $num_day_sql)) {
               // Fetch one and one row
               while ($num_day_row = mysqli_fetch_row($num_day_result)) {
                  $duration_day = $num_day_row[0];
               }
             } 

             $day_array   = array();
             $date_model->start_date = date('Y-m-d',strtotime(date("Y-m-d")));
             $total_num              = $duration_day;
             $z = 0;
             $x = 0;
             $i = strtotime($date_model->start_date);
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

            $last_id       = count($day_array)-1;
            $last_date_arr = explode("_",$day_array[$last_id]);
            $sep_date      = explode(" 00:00:00",$last_date_arr[1]);

                        
                       
            //  echo $number_hold_day;
            $date_model->end_date   = date('Y-m-d',strtotime($sep_date[0]));
            $date_model->user_id    = $user_id;
            $date_model->program_id = $program_controller->reactive_program($user_area_id,$num_days_arr['hold_date_id']);
            $program_controller->insert_program_date();
           

          //print_r($day_array);
          $last_start_end_date = $program_controller->last_id_inserted_date_time();

          $result = false;
          // leave two day from array for reset
          for($counter = 0 ;$counter <count($day_array);$counter++){
             $day_name = explode("_",$day_array[$counter]);
           // print_r($day_name);
             $program_day->day_en      = $day_name[0]; //english day 
             $program_day->day_ar      = $day_name[0]; //english day 
             $program_day->date        = $day_name[1]; //date  
             $program_day->program_id  = $last_start_end_date['max']; // last id from start and end date 
             // insert days for program 
             $result = $day_controller->insert_day_time_table();
         }

         $myObj->result  = "1";
         $myObj->message = $languages['cap_page']['active_user'];
         $myJSON         = json_encode($myObj);
         echo  $myJSON;
         
        }else{
            $myObj->result  = "2";
            $myObj->message = $languages['cap_page']['active_error'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        }
        
    }else{
        $myObj->result  = "2";
        $myObj->message = $languages['cap_page']['active_error'];
        $myJSON = json_encode($myObj);
        echo  $myJSON;
    }
}
?>