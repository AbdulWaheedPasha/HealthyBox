<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['delivery_time'])){
        require_once '../Configuration/db.php';
        $delivery_time  = $_POST['delivery_time'];
      

        mysqli_set_charset($con,"utf8");
        $query = "UPDATE `delivery_time_tbl` SET `delivery_time` = '$delivery_time' ";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$delivery_time.' تمت تعديل وقت التسليم الي </b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم يتم تعديل وقت التسليم</b></div>';
   

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