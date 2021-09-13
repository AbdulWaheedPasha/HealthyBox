<?php

if(isset($_POST['submitForm'])){
    if( empty($_POST['company_ar'])   && empty($_POST['company_eng'])
    && empty($_POST['company_telep']) && empty($_POST['company_whatsapp'])  
    && empty($_POST['inst']) && empty($_POST['facebook']) && empty($_POST['twitter']) ){
    //    echo '<h2>من فضلك املا الحقول الفارغة</h2>';
                      
   }else{
        $string_en = "";
       if(!empty($_FILES['fileToUploadIcon_en']) || !empty($_FILES['fileToUploadIcon_ar'])){ 
           $string_en = ", ";
       }
       $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
       $path = '../Assets/'; // upload directory
       if(!empty($_FILES['fileToUploadIcon_en'])){
           $img = $_FILES['fileToUploadIcon_en']['name'];
           $tmp = $_FILES['fileToUploadIcon_en']['tmp_name'];
           $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
           $final_image = rand(1000,1000000).$img;
           if(in_array($ext, $valid_extensions)) { 
               $path =  $path.strtolower($final_image); 
               if(move_uploaded_file($tmp,$path)){
                $path_expolde = explode("..",$path);
                //print_r($path_expolde);
                $path = $path_expolde[1].strtolower($final_image); 
                   $string_en = $string_en . " `company_profile_en` = '$path' ";
               }
               
           }
       }

       if(!empty($_FILES['fileToUploadIcon_ar'])){
           $path = '../Assets/';
        //    $img = $_FILES['fileToUploadIcon_ar']['name'];
        //    $tmp = $_FILES['fileToUploadIcon_ar']['tmp_name'];
        //    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        //    $final_image = rand(1000,1000000).$img;
        //    if(in_array($ext, $valid_extensions)) { 
        //        $path =  $path.strtolower($final_image); 
        //        if(move_uploaded_file($tmp,$path)){
        //             $path_expolde = explode("..",$path);
        //             $path         = $path_expolde[1].strtolower($final_image); 
        //             $string_en =  $string_en .", `company_profile_ar` = '$path' ";
        //        }
        //    }
       }
       require_once './Configuration/db.php';
       mysqli_set_charset($con, "utf8");
       $query_insert = "UPDATE  `company_tbl` SET  `company_name_ar` = '$_POST[company_ar]', ". 
                       " `company_name_en` = '$_POST[company_eng]',  ".
                       "    `company_name_phone` = '$_POST[company_telep]',  ".
                       "   `company_whatsapp` = '$_POST[company_whatsapp]',  ".
                       "    `company_link_instagram` = '$_POST[inst]',  ".
                       "   `company_link_twitter` = '$_POST[facebook]',  ".
                       "    `company_link_facebook` = '$_POST[twitter]' ".
                       "  $string_en WHERE `administration_id` = '$_SESSION[user_id]'  ";
// echo $query_insert;
           
        // $rs = mysqli_query($con, $query_insert);
        
        // if ($rs) {

        //     // mysqli_close($con);
        //     // echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./company_info.php?Message=' . base64_encode("save") . '">';
        //     // exit();
        // } else {
        //     // mysqli_close($con);
        //     // echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./company_info.php?Message=' . base64_encode("dont_save") . '">';
        //     // exit();
        // }        
       
   }
}

?>
            