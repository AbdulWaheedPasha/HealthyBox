<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//print_r($_POST);
if (isset($_SESSION['user_name']) && isset($_SESSION['password'])) {
    if(!empty($_POST['order_id']) &&  !empty($_POST['value']) ){
        require_once '../Configuration/db.php';

        //delete before one
        
        $query  = "DELETE FROM `order_pay_tbl` WHERE `order_id` = '$_POST[order_id]' ";
        $rs 	= mysqli_query($con, $query);
        
        mysqli_set_charset($con,"utf8");
        $query  = "INSERT INTO `order_pay_tbl` (`order_pay_id`, `order_id`, `delivery_id`) VALUES (NULL, '$_POST[order_id]', '$_POST[value]'); ";
       // echo  $query."<br/>";
        $rs 	= mysqli_query($con, $query);

        if ($rs) {
            //get order status id
           
            echo  
            '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              تمت عملية العميلة بنجاح 
            </div>';
            
            } else {
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </b>لم تتم العميلة بنجاح.</b></div>';
        }
    }
}else{
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
 
}
?>