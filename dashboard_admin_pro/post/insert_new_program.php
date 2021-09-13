<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
require_once '../lang/' . $_SESSION['lang'] . '.php';

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    // print_r($_POST);
    if(!empty($_POST['category_title_en']) && !empty($_POST['category_title_ar']) && !empty($_POST['Duration']) && !empty($_POST['price']) && !empty($_POST['cate_id'])){
       // print_r($_POST);
        require_once '../Configuration/db.php';
     
        $main_path = "../..";
        $uploadDir = '/asset/images/'; 
        $uploadedFile = ""; 
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
            }


        $category_title_en = $_POST['category_title_en'];
        $category_title_ar = $_POST['category_title_ar'];
        $dec_title_en      = $_POST['dec_title_en'];
        $dec_title_ar      = $_POST['dec_title_ar'];
        $Duration          = $_POST['Duration'];
        $price             = $_POST['price'];
        $cate_id           = $_POST['cate_id'];
        $discount          = $_POST['discount'];
        $color             = $_POST['color_list'];
        mysqli_set_charset($con,"utf8");
        $query  = "INSERT INTO `program_tbl`(`program_title_ar`, `program_title_en`, `program_duration`, `program_cost`, `program_discount`, `program_active`,`program_image_path`,`program_ar_describe`, `program_en_describe`,`category_id`,`program_color_id`) 
                  VALUES ('$category_title_ar','$category_title_en', '$Duration','$price','$discount','1','$uploadedFile','$dec_title_ar','$dec_title_en','$cate_id','$color')";
    //    echo  $query;
        $rs 	= mysqli_query($con, $query);
        if ($rs) {
       
            $myObj->result  = "1";
            $myObj->message =  $languages['area_page']['succe_ms'];
            $myJSON = json_encode($myObj);
            echo  $myJSON; 
        }
         else {
            $myObj->result  = "2";
            $myObj->message =  $languages['area_page']['empty_field'];
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
     header('Location: index.php?err=1');
    exit();
    session_destroy();
}



?>