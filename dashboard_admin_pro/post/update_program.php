<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);
require_once '../lang/' . $_SESSION['lang'] . '.php';
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if (isset($_POST)) {
        if (!empty($_POST['category_title_en']) && !empty($_POST['category_title_ar']) && !empty($_POST['Duration']) && !empty($_POST['price'])) {
            // print_r($_POST);
            require_once '../Configuration/db.php';
            require_once '../lang/' . $_SESSION['lang'] . '.php';
            $category_title_en = $_POST['category_title_en'];
            $category_title_ar = $_POST['category_title_ar'];
            $describe_en = $_POST['dec_title_en'];
            $describe_ar = $_POST['dec_title_ar'];
            $Duration          = $_POST['Duration'];
            $price = $_POST['price'];
            $discount    = $_POST['discount'];
            $category_id = $_POST['cate_id'];
            $color       = $_POST['color_list'];
            mysqli_set_charset($con, "utf8");

        $main_path = "../..";
        $uploadDir = '/asset/images/'; 
        $uploadedFile = ""; 
        $update_imge_query = "";
            if(!empty($_FILES["file"]["name"])){ 
                 
                // File path config 
                $fileName   = basename($_FILES["file"]["name"]);  // real name 
                $new_name   = uniqid() . "-" . time();  // new name 
                $extension  = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION ); // get extention
                $basename   = $new_name . "." . $extension;  
                $targetFilePath = $uploadDir . $basename; 
                $filename   = uniqid() . "-" . time(); 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats 
                $allowTypes = array('jpg', 'png', 'jpeg'); 
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                   
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $main_path.$targetFilePath)){
                        $uploadedFile = $targetFilePath; 
                    }else{ 
                        // $uploadStatus = 0; 
                        // $response['message'] = ; 
                        $myObj->result  = "2";
                        $myObj->message =   $languages['cap_page']['not_allowed'];
                        $myJSON = json_encode($myObj); 
                        echo  $myJSON; 
                    } 
                }else{ 
                    $myObj->result  = "2";
                    $myObj->message =  $languages['cap_page']['not_allowed'];
                    $myJSON = json_encode($myObj); 
                    echo  $myJSON; 

                } 

                $update_imge_query = " ,`program_image_path` = '$uploadedFile' ";
            }
            
            $query = "UPDATE `program_tbl` SET `program_color_id` = '$color' , `program_ar_describe`  = '$describe_ar'  , `program_en_describe` = '$describe_en' ,`program_title_ar`='$category_title_ar',`program_title_en`='$category_title_en' ,`program_duration`='$Duration' ,`program_cost`='$price',`program_discount`='$discount',`category_id` = '$category_id'  $update_imge_query WHERE  `program_id`= '$_POST[program_id]'";
            $rs     = mysqli_query($con, $query);
            if ($rs) {
                $myObj->result  = "1";
                $myObj->message =  $languages['area_page']['update_succe_ms'];
                $myJSON = json_encode($myObj);
                echo  $myJSON;
            } else {
                $myObj->result  = "4";
                $myObj->message = $languages['area_page']['empty_field'];
                $myJSON = json_encode($myObj);
                echo  $myJSON;
            }
        } else {
            $myObj->result  = "4";
            $myObj->message = $languages['area_page']['empty_field'];
            $myJSON = json_encode($myObj);
            echo  $myJSON;
        }
    } else {

        $myObj->result  = "4";
        $myObj->message = $languages['area_page']['empty_field'];
        $myJSON = json_encode($myObj);
        echo  $myJSON;
    }
} else {

    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>