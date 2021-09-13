<!-- update_category.php -->
<?php

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

mysqli_set_charset($con, "utf8");
$id = base64_decode($_GET['category_id']);
//echo "SELECT  `category_id`,`category_title_ar`, `category_title_en` FROM `category_tbl` WHERE  `category_id` = '$id'";
$rs = mysqli_query($con, "SELECT  `category_id`,`category_title_ar`, `category_title_en` FROM `category_tbl` WHERE  `category_id` = '$id'");
while ($arr = mysqli_fetch_array($rs)) {

?>


<div class="col">
    <?php

if(isset($_GET['Message'])){
    $message_error = base64_decode($_GET['Message']);
    switch ($message_error) {
        case "save":
             echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$languages['cap_page']['update_succe_ms'].'</b></div>';
            break;
        case "dont_save":
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$languages['cap_page']['error_ms'].'</b></div>';
 
            break;
        case "empty_field":
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> '.$languages['cap_page']['empty_field'].'</b></div>';
            break; 
        case "login_again":
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> '.$languages['cap_page']['empty_field'].'</b></div>';
         break;
 
            
        default:{
            
           
        }
     
    }
 
 }
 
    ?>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php echo $languages['category']['update_cat']; ?></h4>
                  <p class="card-category"><?php echo $languages['category']['sub_title']; ?></p>
                </div>
                <div class="card-body">
                <form action="./post/update_category.php" method="post" enctype="multipart/form-data" name="form" id="form">

                                           <div class="form-group" id="Result"></div>
                                           <input type="hidden" class="form-control"   name="id" value="<?php  echo base64_encode(base64_encode(base64_encode($arr['category_id']))) ;?>">
                                           <input class="form-control" type="hidden" value="<?php  echo base64_encode($arr['category_id']);?>"  name="category_id">
                                           <div class="form-group">
                                               <label><?php echo $languages['cap_page']['name_en']; ?>
                                               </label>
                                               <input class="form-control" value="<?php  echo $arr['category_title_en'] ;?>"  name="title_en">
                                           </div>
                                           <div class="form-group">
                                               <label> <?php echo $languages['cap_page']['name_ar']; ?>
                                               </label>
                                               <input class="form-control" value="<?php  echo $arr['category_title_ar'] ;?>" name="title_ar">
                                           </div>

 </div>

                                        
                                           <br/>
                                        
                                           
                                           
                                           <div class="modal-footer">
                                               <input type="submit" value="<?php echo $languages['cap_page']['submit']; ?>"  class="btn btn-primary btn-round">
                                           </div>

                                       </form>



                                       <script src="https://code.jquery.com/jquery-3.5.1.js"  crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                $("#form").on("submit", function(e) {

                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        data: postData,
                        success: function(data, textStatus, jqXHR) {
                        //  alert(data);
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
                                
                </div>
              </div>
            </div>
                     
            <?php
}
}
?>
