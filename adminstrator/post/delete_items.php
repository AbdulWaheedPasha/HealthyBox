
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])){
      
        require_once '../Configuration/db.php';
        $title_ar  = $_POST['category_title_ar'];
        $title_en  = $_POST['category_title_en'];
        $Select    = $_POST['Select'];
        $active    = $_POST['active'];
   
        mysqli_set_charset($con,"utf8");
        $query = "";
        //echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> تم اضافة الاضافات بنجاح.</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b> لم تتم اضافة الاضافات</b></div>';
   

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