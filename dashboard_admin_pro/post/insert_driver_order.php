
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);


if (isset($_SESSION['user_name']) && isset($_SESSION['password'])) {
  // print_r($_POST);
    if(!empty($_POST['Driver_Cost']) && !empty($_POST['Driver_selection'])){
        require_once '../Configuration/db.php';
        mysqli_set_charset($con,"utf8");
        //delete order 
        
        $delete_sql = "DELETE FROM `order_administration_tbl` WHERE `order_id` = '$_POST[order_id]' and `order_administration_cost` <> '0.000' ";
        //echo $delete_sql;
        $rs 	    = mysqli_query($con, $delete_sql);
        $insert_sql = "INSERT INTO `order_administration_tbl` VALUES (NULL, '$_POST[order_id]', '$_POST[Driver_selection]', '$_POST[Driver_Cost]');";
        //echo $insert_sql;
        $rs 	= mysqli_query($con, $insert_sql);
       if($rs) 
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>  تمت تعيين السواق للطلب بنجاح .</b></div>';
         else 
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b> لم يتم تعيين السواق للطلب بنجاح. </b></div>';
    } else {
       // echo "hfhfh";
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> من فضلك املا الحقول الفارغة .</b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
    
}



?>