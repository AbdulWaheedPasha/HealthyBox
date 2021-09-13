<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);


if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

    require_once '../Configuration/db.php';
    require_once("../class_file/clear_query_class.php");
    $clear_query_class = new clear_query_class();
    if(isset($_POST)){
        $page_id   = base64_decode($_POST['Page_ID']);
        if (!empty($_POST['English_Description']) && !empty($_POST['Arabic_Description'])){
     
       
           
            $product_description_en    = $clear_query_class->seo_friendly_url($_POST['English_Description']);
            $product_description_ar    = $clear_query_class->seo_friendly_url($_POST['Arabic_Description']);
           
          
           $query = "UPDATE `pages_tbl` SET 
            `pages_contents_en`    = '$product_description_en',
            `pages_contents_ar`    = '$product_description_ar' 
             WHERE `pages_id`      =  '1' ";
             // echo $query;

             mysqli_set_charset($con,"utf8");
             mysqli_query($con,"SET NAMES 'utf8'");
             mysqli_query($con,"SET CHARACTER SET utf8");
             
             
             $rs 	               = mysqli_query($con,$query);
              if($rs) 
              echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../about_app.php?Message=Save">';
              else
              echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../about_app.php?&&Message=not_Save">';

    
        }else
             echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../about_app.php?Message=FillEmptyFiled">';
           
    }else
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=location:index.php?err=1">';
  
}else
echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=location:index.php?err=1">';
 
?>
