<?php

session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);


if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
if (is_array($_FILES)) {
    require_once '../Configuration/db.php';
    require_once("../class_file/counter.php");
    require_once("../class_file/get_class.php");
    require_once("../class_file/upload_img.php");
    $get_class          = new get_class();
    $counter_class      = new counter_class(); 
    $upload_img         = new upload_img();

    $category_icon    = $upload_img->func_upload($_FILES['images'],100,100);

}
} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}


?>