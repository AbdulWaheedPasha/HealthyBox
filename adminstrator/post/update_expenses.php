
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once '../lang/' . $_SESSION['lang'] . '.php';
    if(!empty($_POST['product_price']) || !empty($_POST['type_expenses'])){
        require_once("../Configuration/db.php");
        // require_once('../lang/'.$_SESSION['lang'] . '.php');
        $product_price     = $_POST['product_price'];
        $expenses_detials_id  = $_POST['expenses_detials_id'];
        $type_expenses     = $_POST['type_expenses'];
        $expenses_detials_date = $_POST["expenses_detials_date"];

        mysqli_set_charset($con,"utf8");
        
        // $date = new DateTime("now", new DateTimeZone('Asia/Kuwait') );
        // $time =  $date->format('Y-m-d H:i:s');

        $query = " UPDATE `expenses_detials_tbl` SET `expenses_detials_name` = '$type_expenses',`expenses_detials_cost` = '$product_price',`expenses_detials_date` = '$expenses_detials_date'  WHERE `expenses_detials_id` = '$expenses_detials_id' ";
  
        //  echo $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) 
        echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b> '.$languages['area_page']['succe_ms'].'.</b></div>';
         else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>'.$languages['area_page']['error_ms'].' .</b></div>';
   

    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> '.$languages['area_page']['empty_field'].'.</b></div>';
    }
} else {
    
    echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <b>'.$languages['website']['wrong_msg_day'].'.</b></div>';
}



?>