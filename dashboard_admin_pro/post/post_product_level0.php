<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['product_title_ar']) && !empty($_POST['product_title_en']) && !empty($_POST['branch_name'])) {
        require_once '../Configuration/db.php';
           require_once("../class_file/counter.php");
           require_once("../class_file/get_class.php");
           require_once("../class_file/clear_query_class.php");
           $get_class         = new get_class();
           $counter_class     = new counter_class();
           $clear_query_class = new clear_query_class();
           //$category_id  =  $_POST['category_type'];
           $product_title_en  = $_POST['product_title_en'];
           $product_title_ar  = $_POST['product_title_ar'];
           $short_title_en  = $_POST['short_title_en'];
           $short_title_ar  = $_POST['short_title_ar'];
           $branch_id         = $_POST['branch_name'];
           $product_active    = 1;
           $product_price     = 0;
           $product_discount  = 0;
           
           mysqli_set_charset($con,"utf8");
           $quer_insert = "INSERT INTO `product_tbl`
           VALUES (NULL,'','$short_title_en',
           '$short_title_ar','$product_title_ar','$product_title_en','',
           '','$product_price','$product_discount','$product_active',
           '','','','',
           '','','',
           '','$branch_id','','0','0','0')";
            // echo $quer_insert;
             $last_id = "";
             $rs = mysqli_query($con, $quer_insert);
             if ($rs) {
                echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             </b>تم ادخال اقسام المنتجات بنجاح .</b></div>';
            } else {
                echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              </b>لم يتم  ادخال اقسام المنتجات بنجاح .</b></div>';
            }
             
            
         

               
           }else {
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> رجاء املا الحقول الفارغة.</b></div>';
           }
   } else {
    echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
     <b>You need to login Again.</b></div>';
}
       
        



?>