<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$mesg_error = " ";

// print_r($_POST)."<br/>";
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    if(    empty($_POST['company_ar'])   && empty($_POST['company_eng']) 
        && empty($_POST['company_telep']) && empty($_POST['company_whatsapp'])  
        && empty($_POST['inst']) && empty($_POST['facebook']) && empty($_POST['twitter']) ){
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../company_info.php?Message=' . base64_encode("empty_field") . '">';
            exit();        
    }else{
           require_once '../Configuration/db.php';
           require_once("../class_file/upload_img.php");
           $upload_img = new upload_img();
           $string_en = "";

           $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
           $path = '../Assets/'; // upload directory
           if(!empty($_FILES['fileToUploadIcon_en']['name'])){
             $fileToUploadIcon_en = $upload_img->func_upload($_FILES['fileToUploadIcon_en'],300, 300);
             $string_en           = $string_en .", `company_profile_en` = '$fileToUploadIcon_en' ";
           }
           if(!empty($_FILES['fileToUploadIcon_ar']['name'])){
              $fileToUploadIcon_ar = $upload_img->func_upload($_FILES['fileToUploadIcon_ar'], 300, 300);
              $string_en =  $string_en .", `company_profile_ar` = '$fileToUploadIcon_ar' ";
           }
           mysqli_set_charset($con, "utf8");
           $query_insery = "UPDATE  `company_tbl` SET  `company_name_ar` = '$_POST[company_ar]', ". 
                           " `company_name_en` = '$_POST[company_eng]',  ".
                           "    `company_name_phone` = '$_POST[company_telep]',  ".
                           "   `company_whatsapp` = '$_POST[company_whatsapp]',  ".
                           "    `company_link_instagram` = '$_POST[inst]',  ".
                           "   `company_link_twitter` = '$_POST[twitter]',  ".
                           "    `company_link_facebook` = '$_POST[facebook]' ,".
                           "    `company_pinterest_link` = '$_POST[pinterest]', ".
                           "    `company_youtube` = '$_POST[youtube]' ".
                           "  $string_en WHERE `administration_id` = '$_SESSION[user_id]'  ";
            // echo $query_insery;
            $rs = mysqli_query($con, $query_insery);
            if($rs){
                echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../company_info.php?Message='.base64_encode("save").'">';
                exit(); 
            }else{
                echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../company_info.php?Message='.base64_encode("dont_save").'">';
                exit(); 
            }
        }
 } else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
              
?>