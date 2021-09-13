<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(!empty($_POST['RealUserName']) && !empty($_POST['Telephone'])  && !empty($_POST['password']) && !empty($_POST['username']) ){
        require_once '../Configuration/db.php';
    
        $RealUserName        = $_POST['RealUserName'];
        $administration_id   = $_POST['id'];
        $Telephone           = $_POST['Telephone'];
        $UserName          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['username']))));
        $Password          = base64_encode(base64_encode(base64_encode(base64_encode($_POST['password']))));
      
        mysqli_set_charset($con,"utf8");
        $administration_telephone_number = $_POST['Telephone'];
        $query = "UPDATE `administration_tbl` SET `administration_name`= '$RealUserName', 
                                                  `administration_telephone_number` = '$Telephone' ,
                                                  `administration_username` = '$UserName', 
                                                  `administration_password` = '$Password'  WHERE `administration_id` = '$administration_id' ";
        // echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) {
            if(isset($_POST['area_id'])){
                if(count($_POST['area_id']) > 0){
                    for($i=0;$i<count($_POST['area_id']);$i++){
                        $area_id_1 = $_POST['area_id'][$i];
                        // $query = "INSERT INTO `user_area_tbl` (`area_id`, `user_id`) VALUES ('$area_id_1', '$administration_id') ";
                        $query_pro  = "INSERT INTO `driver_capital_tbl`(`driver_id`, `capital_id`) VALUES ('$administration_id','$area_id_1') ";
                        //echo $query."<br/>";
                        $rs 	= mysqli_query($con, $query_pro);
                    }

            }
        }
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
