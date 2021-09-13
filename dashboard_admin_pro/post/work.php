<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
   
         require_once '../Configuration/db.php';
        $press_checkbox  = $_POST['press_checkbox0'];
      

        mysqli_set_charset($con,"utf8");
        $query = "UPDATE `process_work_tbl` SET  `process_work_status` = '$press_checkbox' ";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>تمت عملية التعديل  بنجاح</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم عملية التعديل </b></div>';
   

} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>