<?php
   session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_password'])) {
    if (isset($_POST)) {
        if (!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])) {
            $category_id                 = base64_decode($_GET['category_id']);
            require_once("../db.php");
            require_once("../class_file/counter.php");
            require_once("../class_file/get_class.php");
            require_once("../class_file/upload_img.php");
            $get_class      = new get_class();
            $counter_class  = new counter_class();
            $upload_img         = new upload_img();
             
            $category_title_ar  = $_POST['category_title_ar'];
            $category_title_en  = $_POST['category_title_en'];
            $category_order     = $_POST['Sorted_Order'];
            if (isset($_POST['Is_Active'])) {
                if ($_POST['Is_Active'] == "Yes") {
                    $category_active = "1";
                } else {
                    $category_active = "0";
                }
            } else {
                $category_active = "0";
            }
            $category_icon_str = "";
            $category_img_str  = "";
            
            if (!empty($_FILES['fileToUploadImage']["name"])) {
                $category_icon    = $upload_img->func_upload($_FILES['fileToUploadIcon'], 100, 100);
                $category_icon_str = "  `category_icon` = '$category_icon' , " ;
            }

            if (!empty($_FILES['fileToUploadImage']["name"])) {
                $category_img     = $upload_img->func_upload($_FILES['fileToUploadImage'], 100, 100);
                $category_img_str =  "  `category_img` = '$category_img' , " ;
            }

            mysqli_set_charset($con,"utf8");
            $query = "UPDATE `category_tbl` SET `category_title_ar`='$category_title_ar',
                                                `category_title_en`='$category_title_en', 
                                                $category_img_str 
                                                $category_icon_str 
                                                `category_order`= '$category_order',
                                                `category_active`= '$category_active'
                                                WHERE `category_id` = '$category_id' ";
            $rs 	= mysqli_query($con, $query);
            if ($rs) {
                header("location:../update_category_item.php?category_id=".base64_encode($category_id)."&&Message=save");
            } else {
                header("location:../update_category_item.php?category_id=".base64_encode($category_id)."&&Message=not_save");
            }
        } else {
            if ($ID  == 0) {
                header("location:../update_category_item.php?category_id=".base64_encode($category_id)."&&Message=empty");
            } else {
                header("location:../update_category_item.php?category_id=".base64_encode($category_id)."&&Message=empty");
            }
        }
    }else{
        header("location:index.php?err=1");
    
    }
}else{
    header("location:index.php?err=1");

}


?>