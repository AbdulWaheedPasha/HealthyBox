<?php
session_start();
   error_reporting(0);
   error_reporting(E_ERROR | E_WARNING | E_PARSE);
   error_reporting(E_ALL);
   error_reporting(E_ALL & ~E_NOTICE);
   if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
       if (!empty($_POST['title_ar']) && !empty($_POST['title_en'])) {
           $category_id                 = base64_decode(base64_decode(base64_decode($_POST['id'])));
           require_once '../Configuration/db.php';
           $category_title_ar  = $_POST['title_ar'];
           $category_title_en  = $_POST['title_en'];
           $governemet_select  =  $_POST['governemet_select'];
           $order              = $_POST['order'];
           mysqli_set_charset($con, "utf8");
           $query = "UPDATE `area_tbl`  SET `area_name_eng` = '$category_title_en', `area_name_ar`    = '$category_title_ar' , `capital_id` = '$governemet_select' , `area_order_by` = '$order'     WHERE `area_id`       = '$category_id' ";
            //echo  $query;
           $rs = mysqli_query($con, $query);
           if ($rs) {
                echo '<meta http-equiv="refresh" content="0; URL=../dashboard.php?type=update_new_area&&id='.$_POST['id'].'&&Message=' . base64_encode("save") . '" />';
               //echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../update_area.php?area_id='.base64_encode($category_id).'&&Message=' . base64_encode("save") . '">';

           } else {
              echo '<meta http-equiv="refresh" content="0; URL=../dashboard.php?type=update_new_area&&id='.$_POST['id'].'&&Message=' . base64_encode("dont_save") . '" />';
   
           }
       } else {
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=update_new_area&&'.$_POST['id'].'&&Message=' . base64_encode("empty_field") . '">';
       }
   } else {
       session_destroy();
       header('Location:../index.php?err=1');
       exit();
   }
   ?>

