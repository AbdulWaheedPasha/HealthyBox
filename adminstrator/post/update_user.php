
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);


if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(!empty($_POST['UserName']) || !empty($_POST['Password'])){
        require_once '../Configuration/db.php';
        $UserName           = $_POST['UserName'];
        $type_adminstrator  = base64_decode($_POST['update_type_adminstrator']);
        $branch_id          = $_POST['branch_name'];
        $Password           = base64_encode(base64_encode(base64_encode($_POST['Password'])));
        $RealUserName       = $_POST['RealUserName'];
        $administration_id   = $_POST['administration_id'];
        mysqli_set_charset($con, "utf8");
        $query = "UPDATE `administration_tbl` SET `administration_name`= '$RealUserName',`administration_username`= '$UserName',
        `administration_password`= '$Password', `branch_id` ='$branch_id', `administration_type_id`= '$type_adminstrator' WHERE `administration_id` = '$administration_id' ";
       //  echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable" style="text-align:right"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>  تمت عملية تعديل المستخدم بنجاح</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable" style="text-align:right"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم تتم عملية التعديل بنجاح.</b></div>';
   

    } else {
        // echo "hfhfh";
        echo  '<div class="alert alert-danger alert-dismissable" style="text-align:right"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b>  من فضلك املا الحقول الفارغة.</b></div>';
    }
} else {
    
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>