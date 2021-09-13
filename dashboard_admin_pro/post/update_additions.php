
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $valueBool = false;
    $value1Bool = false;
    $value2Bool = false;
 
    if (!empty($_POST['additions_haveqty'])) {
        $value1Bool = true;
    }

    if(!empty($_POST['category_title_en']) && !empty($_POST['category_title_ar'])){
//        print_r($_POST);
        require_once '../Configuration/db.php';
        $title_ar  = $_POST['category_title_ar'];
        $title_en  = $_POST['category_title_en'];
        $many    = $_POST['many'];
        $active    = 1;
        $additions_id = $_POST['additions_id'];
        $additions_haveqty = $_POST['additions_haveqty'];
        $additions_select  = 0;
        $additions_qty     = $_POST['qty_product'];
        mysqli_set_charset($con,"utf8");

        $query = "UPDATE `additions_tbl` SET `additions_qty` = '$additions_qty',`additions_name_ar`='$title_ar',
        `additions_name_eng`='$title_en',`additions_type`= '$many',
        `additions_active`='$active',`additions_haveqty`= '$additions_haveqty' WHERE `additions_id` =  $additions_id ";



//        echo $query;
        $rs_additions = false;
        $rs  = mysqli_query($con, $query);
  
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> تم تحديث الإضافات بنجاح .</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> يرجى ملء الحقول الفارغة .</b></div>';
   

    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> يرجى ملء الحقول الفارغة .</b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>