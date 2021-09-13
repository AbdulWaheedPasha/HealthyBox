<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';
   if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
       if (!empty($_POST['title_ar']) && !empty($_POST['title_en'])) {
           $category_id                 = base64_decode(base64_decode(base64_decode($_POST['id'])));
           require_once '../Configuration/db.php';
           $category_title_ar  = $_POST['title_ar'];
           $category_title_en  = $_POST['title_en'];
           mysqli_set_charset($con, "utf8");
           $query = "UPDATE `capital_tbl` SET `capital_en_title` = '$category_title_en', `capital_ar_title`       = '$category_title_ar'    WHERE `capital_id`       = '$category_id' ";
            // echo  $query;
           $rs = mysqli_query($con, $query);
           if ($rs) {
            $myObj->result  = "1";
            $myObj->message =  $languages['area_page']['update_succe_ms'];
            $myJSON = json_encode($myObj);
            echo  $myJSON; 
             
           } else {
                $myObj->result  = "2";
                $myObj->message =  $languages['area_page']['empty_field'];
                $myJSON = json_encode($myObj); 
                echo  $myJSON; 
           }
       } else {
            $myObj->result  = "4";
            $myObj->message = $languages['area_page']['empty_field'];
            $myJSON = json_encode($myObj); 
            echo  $myJSON; 
       }
   } else {
       session_destroy();
       header('Location:../index.php?err=1');
       exit();
   }
   ?>

