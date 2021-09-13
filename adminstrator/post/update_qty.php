<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['id']) || !empty($_POST['qty_textfield'])) {
        if($_POST['qty_textfield'] > 0){
            require_once '../Configuration/db.php';
            mysqli_set_charset($con, "utf8");
            $query =  "UPDATE `product_amount_tbl` SET `product_amount_value` = '$_POST[qty_textfield]' WHERE `product_amount_id` = '$_POST[id]'";
            // echo $query;
            $rs 	= mysqli_query($con, $query);
            if ($rs) 
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b> تمت عملية تعديل الكميات بنجاح</b></div>';
             else 
             echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             </b> لم يتم تتم عملية التعديل بنجاح .</b></div>';
       
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b> من فضلك اختر كمية اكبر من0  .</b></div>';
        }
        
    }else{
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>من فضلك املا الحقول الفارغة.</b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}


?>