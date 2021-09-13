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
        mysqli_set_charset($con,"utf8");
        $query  = "UPDATE `order_tbl` SET `order_status_id` = '$_POST[value]' WHERE `order_id` = '$_POST[order_id]' ";
        $rs 	= mysqli_query($con, $query);

        if ($rs) {
            //get order status id
            $select = "SELECT  `order_status_name` FROM `order_status_tbl` WHERE `order_status_id` = '$_POST[value]' LIMIT 0,1";
            $query = mysqli_query($con,$select) or die(mysqli_close($con));
            $result = mysqli_fetch_assoc($query);

            $order_num_sql = "SELECT `order_number` FROM `order_tbl` WHERE `order_id` =   '$_POST[order_id]'";
            $order_num_rs = mysqli_query($con,$order_num_sql) or die(mysqli_close($con));
            $order_num_result = mysqli_fetch_assoc($order_num_rs);



            // if($_POST['value'] == 5){
            //     $delete_order_sql  = "DELETE FROM `order_administration_tbl` where `order_id` =  '$_POST[order_id]' ;";
            //     $delete_order_sql .= "DELETE FROM `order_tbl`                where `order_id` =  '$_POST[order_id]' ; ";
            //     $delete_order_sql .= "DELETE FROM `order_lists_tbl`          where `order_id`  =  '$_POST[order_id]' ; ";
            //     $delete_order_sql .= "DELETE FROM `product_out_stock_tbl` where `order_id`  =  '$_POST[order_id]' ; ";
            //     $delete_order_query = mysqli_multi_query($con, $delete_order_sql);
            //     // echo $delete_order_query;
            // }

            echo  
            '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               تمت تعديل حالة الطلب رقم <b>'.$order_num_result['order_number'].'</b>  الي الحالة  '.$result['order_status_name'].'  بنجاح
             </div>';
            
            } else {
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </b>لم يتم تحديث المنتج بنجاح .</b></div>';
        }
    }
}else{
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
 
}
?>