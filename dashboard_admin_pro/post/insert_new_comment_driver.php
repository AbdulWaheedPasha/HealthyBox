<?php
// <!-- insert_new_subscriber -->
session_start();
error_reporting(0);
ini_set('display_errors', 0);
// print_r($_POST);
require_once '../lang/' . $_SESSION['lang'] . '.php';
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['comment']) && !empty($_POST['user_id'])) {
        require_once '../Configuration/db.php';
        $comment           = $_POST['comment'];
        $user_id          = $_POST['user_id'];
        date_default_timezone_set("Asia/Kuwait");
        $registered_time = date("Y-m-d h:i:sa");

        mysqli_set_charset($con, "utf8");
        $query  = "INSERT INTO `comment_driver_tbl`(`comment_driver_text`, `comment_driver_driver_id`, `comment_driver_user_id`, `comment_driver_view`, `comment_driver_date`)  VALUES ('$comment','$_SESSION[id]','$user_id','0','$registered_time')";
       // echo $query;

        $rs     = mysqli_query($con, $query);
        if ($rs) {


            // area_id
            $myObj->result  = "1";
            $myObj->message =  $languages['area_page']['succe_ms'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        } else {
            $myObj->result  = "2";
            $myObj->message =  $languages['area_page']['empty_field'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        }
    } else {

        $myObj->result  = "2";
        $myObj->message =  $languages['area_page']['empty_field'];
        $myJSON = json_encode($myObj);
        echo  $myJSON;
    }
} else {
    header('Location: index.php?err=1');
    exit();
    session_destroy();
}




?>