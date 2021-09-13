<?php

session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])) {
        require_once '../Configuration/db.php';
        $area_name_ar       = $_POST['category_title_ar'];
        $area_name_eng      = $_POST['category_title_en'];
        mysqli_set_charset($con, "utf8");
        $query = "INSERT INTO `capital_tbl`( `capital_en_title`, `capital_ar_title`) VALUES ('$area_name_eng','$area_name_ar')";
        $rs = mysqli_query($con, $query);
       // echo $query;
        if ($rs) {
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_cap&&Message=' . base64_encode("save") . '">';
        } else {
           echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_cap&&Message=' . base64_encode("dont_save") . '">';
        }
    } else {
       echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_cap&&Message=' . base64_encode("empty_field") . '">';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
?>
