<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

    // print_r($_POST);
    if(!empty($_POST['username']) || !empty($_POST['oldPassword']) ||
     !empty($_POST['newPassword']) || !empty($_POST['confirmPassword'])){
        require_once '../Configuration/db.php';
        $UserName           = $_POST['username'];
        $password           =  $_POST['oldPassword'];
     
        if($_SESSION['old_password'] == $_SESSION['password']){
            $newPassword     =  md5($_POST['newPassword']);
            $confirmPassword =  md5($_POST['confirmPassword']);
           if($newPassword == $newPassword){

            mysqli_set_charset($con,"utf8");
            $query = "UPDATE `administration_tbl` SET
             `administration_username` = '$UserName', 
             `administration_password` = '$newPassword' WHERE 
             `administration_tbl`.`administration_id` = '$_SESSION[user_id]'";
             //echo $query;
           $rs 	= mysqli_query($con, $query);
            if ($rs){ 
                echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </b> تمت عملية تعديل كلمة السر بنجاح.</b></div>';
            }else{
                echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>كلمة السر و تاكيد السر ليسوا متطابقين. </b></div>';
               }
              
           } else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b>كلمة السر و تاكيد السر ليسوا متطابقين. </b></div>';
           }
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b>كلمة السر السابقة غير صالحة . </b></div>';

        }
    
   

    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> يرجى ملء الحقول الفارغة. </b></div>';

    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();

}



?>