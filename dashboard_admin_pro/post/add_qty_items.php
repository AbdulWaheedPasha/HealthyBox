<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(isset($_POST['additions_haveqty'])){
        require_once '../Configuration/db.php';
       
        if($_POST['additions_haveqty'] == 0 ){
            mysqli_set_charset($con,"utf8");
            $query = "UPDATE `additions_tbl` SET `additions_haveqty` = '$_POST[additions_haveqty]' WHERE `additions_id` = $_POST[additions_id]";
           // echo $query;
            $rs 	= mysqli_query($con, $query);
            if ($rs) 
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b> تمت عملية التعديل بنجاح .</b></div>';
             else 
             echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             </b> لم تتم عملية التعديل بنجاح .</b></div>';
       

        }else if($_POST['additions_haveqty'] == 1 ){
            mysqli_set_charset($con,"utf8");
            $query = "UPDATE `additions_tbl` SET  `additions_haveqty` = '$_POST[additions_haveqty]'  WHERE `additions_id` = $_POST[additions_id]";
           // echo $query;
            $rs 	= mysqli_query($con, $query);
            if ($rs) 
                echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </b> تمت عملية التعديل بنجاح .</b></div>';
            else 
                echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </b> لم تتم عملية التعديل بنجاح .</b></div>';
       

        }

       

    }else{
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }
} else {
    
     header('Location: index.php?err=1');
    exit();
    session_destroy();

}



?>