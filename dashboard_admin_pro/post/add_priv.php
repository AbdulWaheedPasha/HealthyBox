
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['Add'])) {
        foreach($_POST['add'] as $check) {
            $value = true; 
        }
    }else{
        $value = false;  
    }
    if(!$value){
        require_once '../Configuration/db.php';
        $query = "DELETE FROM `privilege_tbl` WHERE `administration_id` = '$_POST[user_Id]' ";
        $rs 	= mysqli_query($con, $query);
        foreach($_POST['add'] as $check) {
            mysqli_set_charset($con,"utf8");
            $query = "INSERT INTO `privilege_tbl` VALUES (NULL,'$check','$_POST[user_Id]')";
           // echo $query;
            $rs 	= mysqli_query($con, $query);
        }

      
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>تمت اضافة الصلاحيات</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم اضافة الصلاحيات . </b></div>';
   

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