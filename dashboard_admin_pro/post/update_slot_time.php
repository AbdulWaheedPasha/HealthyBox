<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST)
    if((!empty($_POST['from']) &&!empty($_POST['to']) && !empty($_POST['day_time_id'])) || $_POST['from'] == "00:00:00"  || $_POST['to'] == "00:00:00"){
        require_once '../Configuration/db.php';
        mysqli_set_charset($con,"utf8");
        $query  = "UPDATE `day_time_tbl` SET `day_time_hours_from` = '$_POST[from]', `day_time_hours_to` = '$_POST[to]'  WHERE  `day_time_id` = '$_POST[day_time_id]'  ";
        $rs 	= mysqli_query($con, $query);
        if($rs){
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>تمت التعديل بنجاح</b></div>';
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>لم تتم التعديل بنجاح</b></div>';
        }
    }else if(!isset($_POST['from']) || !isset($_POST['to']) || !isset($_POST['day_id'])){
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }
    else{
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}


?>