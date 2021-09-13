
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) && isset($_SESSION['password'])) {
    if(!empty($_GET['order_id'])){
        require_once '../Configuration/db.php';
        mysqli_set_charset($con,"utf8");
        $query  = "UPDATE `order_tbl` SET `order_status_id` = '4' WHERE `order_id` = '$_GET[order_id]' ";
        $rs 	= mysqli_query($con, $query);
    }
} else{
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
?>