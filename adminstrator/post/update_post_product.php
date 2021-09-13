<?php
   session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_password'])) {
    if(isset($_POST)){
        if (!empty($_POST['product_title_en'])) {
            require_once("../db.php");
            require_once("../class_file/counter.php");
            require_once("../class_file/get_class.php");
            require_once("../class_file/clear_query_class.php");
            $get_class         = new get_class();
            $counter_class     = new counter_class();
            $clear_query_class = new clear_query_class();

         

                $product_id   = base64_decode($_GET['category_id']);
            
                $product_title_en  = $_POST['product_title_en'];
                $product_title_ar  = $_POST['product_title_ar'];
                $id                = $_POST['id'];
                if(isset($_POST['isActive'])){
                    if($_POST['isActive'] == '1')
                        $product_active    = 1;
                    else
                        $product_active    = 0;
                    
                }else
                    $product_active    = 0;

                if(isset($_POST['isDigitial'])){
                    if($_POST['isDigitial'] == '1')
                            $product_is_digital    = 1;
                        else
                            $product_is_digital    = 0;
                        
                }else
                    $product_is_digital    = 0;
                    
                $product_code      = $_POST['txtPcode'];
                $product_price     = $_POST['product_price'];
                if($_POST['discount_select'] == 1){
                    $product_discount  = $_POST['product_discount']."%";
 
                }else
                $product_discount  = $_POST['product_discount'];
                $product_num_items         = $_POST['product_num_items'];
                $short_en          = $clear_query_class->seo_friendly_url($_POST['short_en']);
                $short_ar          = $clear_query_class->seo_friendly_url($_POST['short_ar']);
                $product_description_en    = $clear_query_class->seo_friendly_url($_POST['Description']);
                $product_description_ar    = $clear_query_class->seo_friendly_url($_POST['DescriptionAr']);
                $product_specifications_en = $clear_query_class->seo_friendly_url($_POST['Specifications']);
                $product_specifications_ar = $clear_query_class->seo_friendly_url($_POST['SpecificationsAr']);
               
                $query = "UPDATE `product_tbl` SET `product_code`= '$product_code',
                `product_description_en`= '$product_description_en' ,`product_description_ar`= '$product_description_ar',
                `product_title_ar`= '$product_title_ar' ,`product_title_en`= '$product_title_en',`product_num_items`='$product_num_items',
                `product_price`= '$product_price',`product_discount`= '$product_discount',
                `product_active`='$product_active',`product_is_digital`='$product_is_digital',
                `product_short_en`='$product_short_en',`product_short_ar`='$product_short_ar',
                `product_specifications_en`='$product_specifications_en',`product_specifications_ar`='$product_specifications_en' WHERE `product_id` = '$product_id' ";
                
                // echo $query."\n";
                
                $rs 	= mysqli_query($con,$query);

  

                if($rs) 
                   header("location:../update_project_item.php?category_id=".$_GET['category_id']."&&Message=Save");
                else

                   header("location:../update_project_item.php?category_id=".$_GET['category_id']."&&Message=not_Save");
         
        
        }else{
             header("location:../update_project_item.php?category_id=".$_GET['category_id']."&&Message=FillEmptyFiled");
        }
           
    }
  
}else{
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>