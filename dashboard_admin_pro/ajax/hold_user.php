<?php
    session_start();
    error_reporting(0);
    ini_set('display_errors', 0);

    if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once('../lang/' . $_SESSION['lang'] . '.php');
    // print_r($_POST);
    if(isset($_POST)){
        if (isset($_POST['id'])) {
            require_once('../lang/'.$_SESSION['lang'].'.php');
            require_once("../Controller/HoldController.php");
            require_once("../Controller/AdminstratorController.php");
            require_once("../Configuration/db.php");
            $controller = new hold_controller($con);
            $adminstrator_controller =  new adminstrator_controller($con);
            $id            = base64_decode(base64_decode(base64_decode($_POST['id'])));
            $hold_date     = date("Y-m-d");
            
            $hold_num_date_arr    = $controller->get_num_hold_days($id,$hold_date);
            $markable_days_result = $controller->markable_days_where_user_in_hold($id,$hold_date);
            // echo $markable_days_result;
            if($markable_days_result){
                $user_id              = base64_decode($_POST['user_id']);
                $adminstrator_controller->update_status_user(3,$user_id);
                $hold_num             =  $hold_num_date_arr["counter"];
                $last_renew_date      = $controller->get_last_renew_date($id);
                //echo $last_renew_date;
                if($hold_date >  $last_renew_date){
                    // echo "greater than $hold_date ";
                    $result            =  $controller->insert_hold_table($id,$hold_date,$hold_num);
                }else{
                    // echo "greater than $last_renew_date ";
                    $result            =  $controller->insert_hold_table($id,$last_renew_date,$hold_num);
                }
               
                if($result){
                    $myObj->result  = "1";
                    $myObj->message = $languages['cap_page']['hold'];
                    $myJSON         = json_encode($myObj);
                    echo  $myJSON;
                }else{
                    $myObj->result  = "2";
                    $myObj->message = $languages['cap_page']['hold_error'];
                    $myJSON = json_encode($myObj);
                    echo  $myJSON;
                }
            }else{
                $myObj->result  = "2";
                $myObj->message = $languages['cap_page']['hold_error'];
                $myJSON = json_encode($myObj);
                echo  $myJSON;
            }
            
   
        }else{
            $myObj->result  = "2";
            $myObj->message = $languages['cap_page']['hold_error'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        }
        
    }else{
        $myObj->result  = "2";
        $myObj->message = $languages['cap_page']['hold_error'];
        $myJSON = json_encode($myObj);
        echo  $myJSON;
    }
}
?>