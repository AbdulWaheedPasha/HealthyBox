<?php

session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

    if (!empty($_POST['category_title_ar']) && !empty($_POST['category_title_en'])) {
        require_once '../Configuration/db.php';
        // require_once("../class_file/counter.php");
        // require_once("../class_file/get_class.php");
        // require_once("../class_file/upload_img.php");
        // $get_class = new get_class();
        // $counter_class = new counter_class();
        // $upload_img = new upload_img();
        $category_title_ar = $_POST['category_title_ar'];
        $category_title_en = $_POST['category_title_en'];
        $product_active    = 1;
        $category_img = "";
        //func_upload($_FILES['fileToUploadIcon'], 51 , 48);
        // $category_icon = $upload_img->func_upload($_FILES['fileToUploadIcon'],51,48);
        mysqli_set_charset($con, "utf8");
        $query = "INSERT INTO `category_tbl` (`category_title_ar`, `category_title_en`)  VALUES ('$category_title_ar', '$category_title_en')";
    //    echo $query;

        $rs = mysqli_query($con, $query);
        
        if ($rs) {

            mysqli_close($con);
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=insert_new_category&&Message=' . base64_encode("save") . '">';
            exit();

        } else {
            mysqli_close($con);
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=insert_new_category&&Message=' . base64_encode("dont_save") . '">';
            exit();
        }
    } else {
        echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../dashboard.php?type=insert_new_category&&Message=' . base64_encode("empty_field") . '">';
        exit();

    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();}
?>
