<?php
session_start();
error_reporting(E_ALL);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])) {
        require_once '../Configuration/db.php';
        $governemet_select  = $_POST['governemet_select'];
        $area_name_ar       = $_POST['category_title_ar'];
        $area_name_eng      = $_POST['category_title_en'];
        $order              = $_POST['order'];
        mysqli_set_charset($con, "utf8");
        $query = "INSERT INTO `area_tbl`(`area_name_ar`, `area_name_eng`, `capital_id`, `area_order_by`) VALUES ('$area_name_ar', '$area_name_eng','$governemet_select','$order')";
        $rs = mysqli_query($con, $query);
        if ($rs) {
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_area&&Message=' . base64_encode("save") . '">';
        } else {
           echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_area&&Message=' . base64_encode("dont_save") . '">';
        }
    } else {
       echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=add_new_area&&Message=' . base64_encode("empty_field") . '">';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();}
?>
