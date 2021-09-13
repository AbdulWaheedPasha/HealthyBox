<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST['categories']);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $pointer = false;
    foreach ($_POST['categories'] as $selected) {
        if (!empty($selected) && $selected != 0) {
            $pointer  = true;
        }
    }
    if (!empty($_POST['product_title_ar'])  && !empty($_POST['product_title_en']) && $pointer) {
        require_once '../Configuration/db.php';
           require_once("../class_file/counter.php");
           require_once("../class_file/get_class.php");
           require_once("../class_file/clear_query_class.php");
           $last_id = $_POST['product_id'];
           $get_class         = new get_class();
           $counter_class     = new counter_class();
           $clear_query_class = new clear_query_class();
           //$category_id  =  $_POST['category_type'];
           $product_title_en  = $_POST['product_title_en'];
           $product_title_ar  = $_POST['product_title_ar'];
   
           $product_discount  = $_POST['product_discount']; 
           $product_price     = $_POST['product_price'];
           $short_en          = $clear_query_class->seo_friendly_url($_POST['short_en']);
           $short_ar          = $clear_query_class->seo_friendly_url($_POST['short_ar']);
           $hotDeal          = "";
           if(isset($_POST['hot_deal'])){
               if($_POST['hot_deal'] == "1"){
                   $hotDeal =  " , `product_hot_deal` = '1' ";
               }
              
           }else{
            $hotDeal =  " , `product_hot_deal` = '0' ";
           }

        //    echo $hotDeal."<br/>";
          
   
          
           mysqli_set_charset($con,"utf8");
           
         
        $query_insert = "UPDATE `product_tbl` SET  
                                `product_display_id`     = '$product_display_id',
                                `product_title_ar`       = '$product_title_ar', 
                                `product_title_en`       = '$product_title_en', 
                                `product_description_en` = '$short_en', 
                                `product_description_ar` = '$short_ar', 
                                `product_price`          = '$product_price',
                                `product_discount`       = '$product_discount'
                                $hotDeal
                          WHERE  `product_id`      = '$last_id' ";
        // echo $query_insert."<br/>";   
        $rs = mysqli_query($con, $query_insert);
   
        if($rs){
            if (!empty($_POST['categories'])) {
               
                // delete category before
                $delete_query = "DELETE FROM `product_category_tbl` WHERE  `product_id` = '$last_id' ";
                // echo $delete_query."<br/>";
                mysqli_query($con, $delete_query);
               
                foreach ($_POST['categories'] as $selected) {
                    if (!empty($selected) && $selected != 0) {
                        $quer_related_product = "INSERT INTO `product_category_tbl` (`product_id`, `category_id`) VALUES ('$last_id','$selected')";
                        //echo $quer_related_product."<br/>";
                        mysqli_query($con, $quer_related_product);
                    }
                }
            }

            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b> تم تحديث المنتج بنجاح. </b></div>';
        } else {
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </b>لم يتم تحديث المنتج بنجاح .</b></div>';
        }
   
            }else {
                echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <b> يرجى ملء الحقول الفارغة .</b></div>';
            }
   } else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
       
        



?>