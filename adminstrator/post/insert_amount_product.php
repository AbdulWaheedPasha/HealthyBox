<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['product_amount_value']) && !empty($_POST['product_amount_time']) && !empty($_POST['product_id']) && ($_POST['product_amount_value'] > 0) ){
        require_once '../Configuration/db.php';
        $product_amount_value   = $_POST['product_amount_value'];
        $product_id             = $_POST['product_id'];
        $product_amount_date    = $_POST['product_amount_date']; 
        $product_amount_time    = $_POST['product_amount_time'];
       // echo $product_amount_time; 
        mysqli_set_charset($con,"utf8");
        $query = "INSERT INTO `product_amount_tbl` VALUES (NULL,'$product_amount_value','$product_id',CURDATE(),'$product_amount_time','$_SESSION[user_id]')";
         // echo $query;
         mysqli_query($con,"UPDATE `product_tbl` SET `product_active` = '1' WHERE `product_id` = '$product_id' ");

        $rs 	= mysqli_query($con,$query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> تم اضافة الكمية بنجاح. </b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم يتم إضافة الكمية بنجاح</b></div>';
   

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
