<?php
// update_program
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if(isset($_GET['program_id'])){
    if(!empty($_GET['program_id'])){
        require_once './Configuration/db.php';
        require_once './Controller/Program.php';
        $program_controller =  new all_program_controller($con);
        $program_id = base64_decode($_GET['program_id']);
        $program_controller->prorgram_id = $program_id;
        $program_arr =  $program_controller->get_program_where_id($program_id);

        require_once './Controller/Program.php';
        $program_controller =  new all_program_controller($con);
        $cat_arr =  $program_controller->fetc_cat();
        $color_arr   = $program_controller->fetc_color();
       
// print_r($program_arr);
    ?>

<div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php echo $languages['program']['update']; ?></h4>
                  <p class="card-category"><?php echo $languages['program']['describe_update']; ?></p>
                </div>
                <div class="card-body">


                <?php 

if(isset($_GET['action']) && isset($_GET['program_id'])){
    $message_error = base64_decode(base64_decode($_GET['action']));
   // echo $message_error;
    $Category_ID = base64_decode($_GET['program_id']);
    switch ($message_error) {
        case "delete_image_pointer":{
           mysqli_set_charset($con, "utf8");
           $active_query = "UPDATE `program_tbl` SET `program_image_path` = '' WHERE `program_id` = $Category_ID ";
          //echo $active_query ;
           $active_mysqli_query = mysqli_query($con,$active_query);
           echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           </b>'.$languages['cap_page']['delete_image'].'</b></div>';
           $page = "dashboard.php?type=all_program";
           echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
         } 
       break; 
         case "Not-Active": {
           mysqli_set_charset($con, "utf8");
           $active_query = "UPDATE `program_tbl` SET `program_active`= 0 WHERE `program_id` = $Category_ID ";
          // echo $active_query;
           $active_mysqli_query = mysqli_query($con,$active_query);
           echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           </b>'.$languages['cap_page']['not_active'].'</b></div>';
           $page =  "dashboard.php?type=all_program";
           echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
      
         }
       break;
       
            
        default:{
            // session_destroy();
            // header('Location:./index.php?err=1');
            // exit();
           
        }
     
    }
 
 }
                ?>

   <div id="Result"></div>
                                       <form action="./post/update_program.php" method="post" enctype="multipart/form-data"
                                           name="form" id="form">

                                           <div class="form-group" id="Result"></div>
                                           <input class="form-control"   type="hidden"    name="program_id" value="<?php echo $program_arr['program_id']; ?>">

                                           <div class="form-group">
                                               <label><?php echo $languages['cap_page']['name_en']; ?>
                                               </label>
                                               <input class="form-control"       name="category_title_en" value="<?php echo $program_arr['type_en']; ?>">
                                           </div>
                                           <div class="form-group">
                                               <label> <?php echo $languages['cap_page']['name_ar']; ?>
                                               </label>
                                               <input class="form-control"       name="category_title_ar" value="<?php echo $program_arr['type_ar']; ?>" >
                                           </div>
                                           <div class="form-group">
                                               <label> <?php echo $languages['program']['dur']; ?>
                                               </label>
                                               <input class="form-control"     onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"   name="Duration"  onkeypress="return isNumber(event)"   value="<?php echo $program_arr['program_duration']; ?>" >
                                           </div>
                                           <script>
                function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }
                </script>

                                <div class="form-group">
                <label> <?php echo $languages['cap_page']['desc_en']; ?>
                </label>
                <input class="form-control" name="dec_title_en"   value="<?php echo $program_arr['program_en_describe']; ?>">
            </div>
            <div class="form-group">
                <label> <?php echo $languages['cap_page']['desc_ar']; ?>
                </label>
                <input class="form-control" name="dec_title_ar"   value="<?php echo $program_arr['program_ar_describe']; ?>">
            </div>       
                                               <div class="form-group">
                                               <label> <?php echo $languages['program']['price']; ?>
                                               </label>
                                               <input class="form-control"       name="price"  onkeypress="return isNumber(event)"   step=".01"  value="<?php echo $program_arr['program_cost']; ?>" >
                                           </div>

                                           <div class="form-group">
                <label> <?php echo $languages['category']['category']; ?>
                </label>
                <select class="form-control"  id="first"  name="cate_id">                                                           
                         <?php
                        for($i=0;$i<count($cat_arr);$i++){
                               $title = ($_SESSION['lang'] == "en") ? $cat_arr[$i]['type_en'] : $cat_arr[$i]['type_ar'];

                                if($cat_arr[$i]['program_id'] == $program_arr['category_id']){
                                    echo '<option  value="'.$cat_arr[$i]['program_id'].'">'.$title.'</option>';
                                }

                            }
                            for($i=0;$i<count($cat_arr);$i++){
                                $title = ($_SESSION['lang'] == "en") ? $cat_arr[$i]['type_en'] : $cat_arr[$i]['type_ar'];
 
                                 if($cat_arr[$i]['program_id'] != $program_arr['category_id']){
                                     echo '<option  value="'.$cat_arr[$i]['program_id'].'">'.$title.'</option>';
                                 }
 
                             }

                            
                            ?>

                        </select>
            </div>


            <div class="form-group">
                <label> <?php echo $languages['category']['color']; ?>
                </label>
                <select class="form-control"  id="color_list"  name="color_list">                                                           
                         <?php
                        for($i=0;$i<count($color_arr);$i++){
                               $title =  $color_arr[$i]['color_name'];

                                if($color_arr[$i]['color_id'] == $program_arr['program_color_id']){
                                    echo '<option  value="'.$color_arr[$i]['color_id'].'">'.$title.'</option>';
                                }

                            }
                            for($i=0;$i<count($cat_arr);$i++){
                                $title =  $color_arr[$i]['color_name'];
 
                                 if($color_arr[$i]['color_id'] != $program_arr['program_color_id']){
                                     echo '<option  value="'.$color_arr[$i]['color_id'].'">'.$title.'</option>';
                                 }
 
                             }

                            
                            ?>

                        </select>
            </div>

<div class="form-group">
                                               <label> <?php echo $languages['program']['discount']; ?>
                                               </label>
                                               <input class="form-control"       name="discount"  onkeypress="return isNumber(event)"   step=".01"  value="<?php echo $program_arr['program_discount']; ?>">
                                           </div>

              

                                           <div class="form-group">
                <label> <?php echo $languages['program']['img']; ?>
                </label>
                
            </div>

            <input type="file" name="file" id="file">


           
          
           <?php
           if(!empty($program_arr['program_image_path'])){
           ?>
            <div class="card-profile">
                <div class="card-avatar">
                <a href="dashboard.php?<?php echo $_SERVER['QUERY_STRING']; ?>&&action=<?php echo base64_encode(base64_encode("delete_image_pointer")); ?>" class="btn btn-primary btn-round btn-fab">
                    <i class="material-icons" style="margin: 0;">delete</i><div class="ripple-container">
                </div>
                <div class="ripple-container"></div></a>
                  <a href="#pablo">
                     <img class="img" src="../<?php echo $program_arr['program_image_path'];?>">
                  </a>
                </div>
               
              </div>
              <br/>

              <?php

           }
           ?>


          
                                        
                                           
                                        
                                           
                                           
                                           <div class="modal-footer">
                                               <input type="submit" class="btn btn-primary btn-round" value="<?php echo $languages['cap_page']['submit']; ?>">
                                           </div>

                                       </form>





                                       <script src="https://code.jquery.com/jquery-3.5.1.js"  crossorigin="anonymous"></script>
      
<script>

$(document).ready(function () {
$("#form").on("submit", function(e) {
  
   var postData = $(this).serializeArray();
   var formURL = $(this).attr("action");
   $.ajax({
       url: formURL,
       type: "POST",
       data: new FormData(this),
                        contentType: false,
                        processData: false,
       success: function(data, textStatus, jqXHR) {
          // alert(data);
        var jsonData = JSON.parse(data);
                            if (jsonData.result == "1") {
                                Notify.suc({
                                    title: 'OK',
                                    text: jsonData.message,
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else {
                                Notify.suc(jsonData.message);
                            }
       },
       error: function(jqXHR, status, error) {
           console.log(status + ": " + error);
       }
   });
   e.preventDefault();
});

$("#submitForm").on('click', function() {
  $("#form").submit();
});
});
</script>
    <?php
}
}  
}    

?>