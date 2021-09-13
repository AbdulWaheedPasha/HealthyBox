<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['english_name']) || !empty($_POST['arabic_name'])){
        require_once '../Configuration/db.php';
        $title_ar  = $_POST['arabic_name'];
        $title_en  = $_POST['english_name'];
        $add_id    = $_POST['add_id'];
        $price     = $_POST['price'];
        $additions_item_kitchin = $_POST['additions_item_kitchin'];

        mysqli_set_charset($con,"utf8");
        $query = "INSERT INTO `additions_item_tbl` ( `additions_item_ar_name`, `additions_item_en_name`, `additions_item_price`, `additions_item_kitchin`, `additions_id`,`additions_item_qty`, `branch_id`,`additions_item_active`) 
                                 VALUES ('$title_ar', '$title_en','$price','$additions_item_kitchin','$add_id','$_POST[qty]','$_POST[branch_id]','1')";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> تمت إضافة عنصر جديد بنجاح</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم إضافة العنصر الجديد بنجاح. </b></div>';
   

    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
   
}



?>