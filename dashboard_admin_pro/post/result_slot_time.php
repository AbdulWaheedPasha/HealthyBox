<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(isset($_POST)){
        header("location:../result_slot_time.php?day_id=".base64_encode(base64_encode($_POST['day_drop_name']))."&&Message=save");
    }else
       header("location:index.php?err=1");
}else {
    header("location:index.php?err=1");
}

 
?>
