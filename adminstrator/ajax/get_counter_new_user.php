<?php 
    session_start();
    error_reporting(0);
    ini_set('display_errors', 0);
    if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
        require_once("../Configuration/db.php");
        require_once('../lang/'.$_SESSION['lang'] . '.php');
        require_once("../Controller/CommentsController.php");
        $comment_controller = new comment_controller($con);
        $counter_arr = $comment_controller->fetc_num_new_user();
        $counter = array("counter_view"=>$counter_arr["counter"]);
        echo json_encode($counter,JSON_PRETTY_PRINT) ;
    }
?>