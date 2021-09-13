<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
// print_r($_POST['categories']);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['product_title_ar']) 
    && !empty($_POST['product_title_en'])
    && !empty($_POST['categories'])  ) {
             require_once("../Configuration/db.php");
             require_once("../class_file/counter.php");
             require_once("../class_file/get_class.php");
             require_once("../class_file/clear_query_class.php");
             $get_class         = new get_class();
             $counter_class     = new counter_class();
             $clear_query_class = new clear_query_class();
             $product_title_en  = $_POST['product_title_en'];
             $product_title_ar  = $_POST['product_title_ar'];
             $product_price     = $_POST['product_price'];
             $product_discount  = $_POST['product_discount'];
             $hot_deal          = $_POST['hot_deal'];
             $short_en          = $clear_query_class->seo_friendly_url($_POST['short_en']);
             $short_ar          = $clear_query_class->seo_friendly_url($_POST['short_ar']);
            
            
          
     

            $product_active = "1";
            //echo  $product_display_id;
            mysqli_set_charset($con,"utf8");
            $product_query = "INSERT INTO `product_tbl`(`product_title_ar`, `product_title_en`, `product_description_en`, `product_description_ar`,
             `product_price`, `product_discount`, `product_active`, `quantity_num`, `product_display_id`,`product_root`,`product_hot_deal`) 
             VALUES ('$product_title_ar','$product_title_en','$short_en','$short_ar','$product_price','$product_discount','$product_active','0','0','0','$hot_deal')";
                                
             //echo  $product_query ."<br/>" ;
           
            $rs = mysqli_query($con, $product_query);


        if ($rs) {
            if(!empty($_POST['categories'])){
                $last_id = mysqli_insert_id($con);
                foreach($_POST['categories'] as $selected){
                    $quer_related_product = "INSERT INTO `product_category_tbl` (`product_id`, `category_id`) VALUES ('$last_id','$selected')";
                   // echo $quer_related_product."<br/>";
                    mysqli_query($con, $quer_related_product);

            }
        }

            // echo $product_query;
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b> تم إدخال المنتج بنجاح .</b></div>';
        } else {
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </b>لم يتم إدخال المنتج بنجاح.</b></div>';
        }
    }else{
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> رجاء املا الحقول الفارغة.</b></div>';
    }
   }else{
    echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
     <b>You need to login Again.</b></div>';
}
       
        



?>