<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once '../Configuration/db.php';
    $category_id  = $_POST['category_id'];
    mysqli_set_charset($con,"utf8");
    $query = "DELETE FROM `category_tbl` WHERE `category_id` = '$category_id' ";
        //echo $query."<br/>";
        $rs = mysqli_query($con,$query);

        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> تمت عملية حذف بنجاح .</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b> لم تتم عملية الحذف بنجاح</b></div>';
  
        
   

   
} else {
    
    echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <b>من ادخل كلمة الدخول و المرور.</b></div>';
}



?>