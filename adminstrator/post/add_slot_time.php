<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    require_once '../Configuration/db.php';
    if((!empty($_POST['from_time']) &&!empty($_POST['to_time']) && !empty($_POST['day_drop_name'])) || $_POST['from_time'] == "00:00:00"  || $_POST['to_time'] == "00:00:00"){
        mysqli_set_charset($con,"utf8");
        $query = "INSERT INTO `day_time_tbl` (`day_time_hours_from`, `day_time_hours_to`, `day_id`) 
                                       VALUES ('$_POST[from_time]', '$_POST[to_time]', '$_POST[day_drop_name]');";
        $rs 	= mysqli_query($con, $query);
        if($rs){
            echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>تمت الاضافة بنجاح</b></div>';
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>لم تتم الاضافة بنجاح</b></div>';
        }
    }else if(!isset($_POST['from_time']) || !isset($_POST['to_time']) || !isset($_POST['day_drop_name'])){
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }
    else{
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> يرجى ملء الحقول الفارغة. </b></div>';
    }

} else {
    session_destroy();
    header('Location: index.php?err=1');
    exit();
}
?>