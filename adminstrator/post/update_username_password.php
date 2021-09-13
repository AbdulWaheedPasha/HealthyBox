<?php
session_start();
// <!-- update_user_admin -->
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';
require_once '../Configuration/db.php';

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(!empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['conf_password']) &&  !empty($_POST['new_pass']) ){
     
        $old_password        = $_SESSION['password'];
        $UserName            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
        $Password            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
        $new_pass            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['new_pass']))));
        $conf_password            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['conf_password']))));
        if($Password !=  $old_password){
            $myObj->result  = "2";
            $myObj->message =  $languages['area_page']['wrong_password'];
            $myJSON = json_encode($myObj); 
            echo  $myJSON;
        }else if( $new_pass  !=  $conf_password  ){
            $myObj->result  = "2";
            $myObj->message =  $languages['area_page']['doesnt_match'];
            $myJSON = json_encode($myObj); 
            echo  $myJSON;

        }else{
            require_once("../Controller/UserAddressController.php");
            require_once("../Model/UserModel.php");
            $user_model        = new user_model();
            $user_model->set_user_id($_SESSION['id']);
            $user_model->set_administration_username($UserName);
            $user_model->set_administration_password($Password);
            $user_address_controller = new user_address_controller($user_model, $con);
            if($user_address_controller->search_username_password() > 0){
                $myObj->result  = "5";
                $myObj->message = $languages['cap_page']['username_password'];
                $myJSON = json_encode($myObj); 
                echo  $myJSON; 
            }else{
            mysqli_set_charset($con,"utf8");
            $query = "UPDATE `administration_tbl` SET `administration_username` = '$UserName', 
                                                      `administration_password` = '$new_pass' WHERE `administration_id` = '$_SESSION[id]' ";
            //echo $query;
                $rs 	= mysqli_query($con, $query);
                if ($rs) {
                    include "../Controller/AdminstrationRoleController.php";
                    $adminstor_role_controller = new adminstrator_role_controller($con,$UserName,$new_pass,$_SESSION['role_id'],$_SESSION['id']);
                    $adminstor_role_controller->check_session();
                    $adminstor_role_controller->get_roles_where_id();
        
                    $myObj->result  = "1";
                    $myObj->message =  $languages['area_page']['update_succe_ms'];
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
        $myObj->result  = "4";
        $myObj->message =  $languages['area_page']['empty_field'];
        $myJSON = json_encode($myObj); 
        echo  $myJSON; 

    }
} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
