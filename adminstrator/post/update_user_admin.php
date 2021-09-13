<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(!empty($_POST['RealUserName']) && !empty($_POST['password']) && !empty($_POST['username']) ){
        require_once '../Configuration/db.php';
        $role_id             = $_POST['area_id'][0];
        $RealUserName        = $_POST['RealUserName'];
        $administration_id   = $_POST['id'];
        $UserName            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
        $Password            = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
        if(empty($role_id)){
            $role_id = $_POST['administration_type_id'];
        }
      
        mysqli_set_charset($con,"utf8");
        $administration_telephone_number = $_POST['Telephone'];
        $query = "UPDATE `administration_tbl` SET `administration_name`= '$RealUserName', 
                                                  `administration_username` = '$UserName', 
                                                  `administration_password` = '$Password',
                                                  `administration_type_id`  = '$role_id' WHERE `administration_id` = '$administration_id' ";
        // echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) {
           

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
