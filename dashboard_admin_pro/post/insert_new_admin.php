<?php
// insert_new_driver
session_start();
error_reporting(0);
ini_set('display_errors', 0);
// print_r($_POST);
require_once '../lang/' . $_SESSION['lang'] . '.php';
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['RealUserName']) && !empty($_POST['username']) && !empty($_POST['password'])   && !empty($_POST['area_id']) ){
        require_once '../Configuration/db.php';
        require_once("../Controller/UserAddressController.php");
        require_once("../Model/UserModel.php");
        $user_model         = new user_model();
        $user_id            = $_POST['area_id'][0];
        $UserName           = "";
        $branch_id          = "";
        $Password           = "";
        $RealUserName       = $_POST['RealUserName'];
        $Telephone          = $_POST['Telephone'];
        $UserName          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
        $Password          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
        $user_address_controller = new user_address_controller($user_model, $con);
        $user_model->set_administration_username($UserName);
        $user_model->set_administration_password($Password);
        if($user_address_controller->search_username_password_register() > 0){
            $myObj->result  = "5";
            $myObj->message = $languages['cap_page']['username_password'];
            $myJSON = json_encode($myObj); 
            echo  $myJSON; 
        }else{
            
            date_default_timezone_set("Asia/Kuwait");
            $registered_time = date("Y-m-d h:i:sa");

            mysqli_set_charset($con,"utf8");
            $query  = "INSERT INTO `administration_tbl`(`administration_name`,`administration_username`, `administration_password`,`administration_type_id`, `administration_active`, `administration_date_registeration`) 
                       VALUES ('$RealUserName','$UserName', '$Password', '$user_id','1','$registered_time')";
                    //    echo $query;
           
           $rs 	= mysqli_query($con, $query);
            if ($rs) {
             
             
                // area_id
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
   

    } else {
        $myObj->result  = "4";
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