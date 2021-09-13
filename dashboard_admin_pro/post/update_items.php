
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    //print_r($_POST);
    if(!empty($_POST['English_Name']) && !empty($_POST['Arabic_Name']) && !empty($_POST['additions_item_id'])){
        require_once '../Configuration/db.php';
        $additions_item_id = $_POST['additions_item_id'];
        $English_Name = $_POST['English_Name'];
        $Arabic_Name = $_POST['Arabic_Name'];
        $additions_item_kitchin = $_POST['additions_item_kitchin'];
        mysqli_set_charset($con,"utf8");
        $query = "UPDATE `additions_item_tbl` SET 
        `additions_item_kitchin` = '$additions_item_kitchin',
        `additions_item_price` ='$_POST[price]',
        `additions_item_ar_name`='$Arabic_Name',
        `additions_item_en_name`='$English_Name',
        `additions_item_qty`    ='$_POST[additions_item_qty]',
          `branch_id`           = '$_POST[branch_id]'

        WHERE `additions_item_id` = ' $additions_item_id' ";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>تم تعديل الاضافات بنجاح .</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم العملية بنجاح . </b></div>';
   

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