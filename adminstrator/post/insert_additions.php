
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    $valueBool = false;
    $value1Bool = false;
    $value2Bool = false;
   
    if(!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])){
       
        require_once '../Configuration/db.php';
        $title_ar  = $_POST['category_title_ar'];
        $title_en  = $_POST['category_title_en'];
        $Select    = $_POST['Select'];
        $active    = "1";
        $additions_haveqty = $_POST['additions_haveqty'];
        $additions_select  = 0;
        $additions_qty     = $_POST['qty_product'];
      
       

        mysqli_set_charset($con,"utf8");
        $query = "INSERT INTO `additions_tbl` (`additions_name_eng`,`additions_name_ar`, `additions_type`,
         `additions_active`,`additions_haveqty`,`additions_qty`)  
        VALUES  ('$title_en','$title_ar','$Select','$active','$additions_haveqty','$additions_qty')";
        // echo $query."<br/>";
     
        $rs 	= mysqli_query($con, $query);
  
       

        if ($rs) {
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>تمت عملية الاضافة بنجاح .</b></div>';
        }else{
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>فشلت عملية الاضافة .</b></div>';
        }
    
    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> يرجى ملء الحقول الفارغة.</b></div>';
    }
} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>