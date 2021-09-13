
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);

if (isset($_SESSION['user_name']) && isset($_SESSION['password'])) {
   
        require_once '../Configuration/db.php';
        $from  = $_POST['work_hour_start'];
        $to    = $_POST['work_hour_from'];
        mysqli_set_charset($con,"utf8");
        $query = "UPDATE `time_order_tbl` SET `time_order_start`='$from',`time_order_end`='$to'";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>تمت عملية التعديل وضع بنجاح</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم عملية التعديل </b></div>';
   

} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>