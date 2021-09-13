
<?php
// insert_new_driver
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    //print_r($_POST);
    if(!empty($_POST['UserName']) || !empty($_POST['Password'])){

        
        require_once '../Configuration/db.php';
        $UserName           = $_POST['UserName'];
        $type_adminstrator  = base64_decode($_POST['type_adminstrator']);
        $Password           = base64_encode(base64_encode(base64_encode($_POST['Password'])));
        $RealUserName       = $_POST['RealUserName'];
        $branch_name        = $_POST['branch_name'];

        mysqli_set_charset($con,"utf8");
        $query = "INSERT INTO `administration_tbl` (
            `administration_name`,`administration_username`,
             `administration_password`,
         `administration_type_id`, `administration_active`, `branch_id`) 
         VALUES ('$RealUserName','$UserName', '$Password', '$type_adminstrator','1','$branch_name')";
       // echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>  تمت اضافة المستخدم بنجاح</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>لم يتم اضافة المسنخدم</b></div>';
   

    } else {
        // echo "hfhfh";
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> Please Fill Empty Fields.</b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>