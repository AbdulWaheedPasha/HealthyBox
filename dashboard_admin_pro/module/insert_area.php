<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php echo $languages['area']['add']; ?></h4>
                  <p class="card-category"><?php echo $languages['area']['describtion']; ?></p>
                </div>
                <div class="card-body">

                <?php
if(isset($_GET['Message'])){
    $message_error = base64_decode($_GET['Message']);
    switch ($message_error) {
        case "save":
             echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$languages['cap_page']['succe_ms'].'</b></div>';
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
                                       <form action="./post/insert_area.php" method="post" enctype="multipart/form-data"
                                           name="form" id="form">

                                           <div class="form-group" id="Result"></div>

                                           <div class="form-group">
                                               <label><?php echo $languages['cap_page']['name_en']; ?>
                                               </label>
                                               <input class="form-control"       name="category_title_en">
                                           </div>
                                           <div class="form-group">
                                               <label> <?php echo $languages['cap_page']['name_ar']; ?>
                                               </label>
                                               <input class="form-control"       name="category_title_ar">
                                           </div>
                                           <div class="form-group">
                                               <label> <?php echo $languages['area_page']['order']; ?>
                                               </label>
                                               <input class="form-control"    onkeypress="return isNumber(event)"   name="order">
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
                                           <label><?php echo $languages['cap_page']['main']; ?> : </label>
    <?php
                        // Change character set to utf8
                        mysqli_set_charset($con,"utf8");
                        $rs = mysqli_query($con, "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl` ");
                        $all_num_rows = mysqli_num_rows($rs);

                        ?>
                        <select class="form-control"  id="first"  name="governemet_select">                                                            <?php
                            while ($arr = mysqli_fetch_array($rs)) {
                                $title = ($_SESSION['lang'] == "en") ? $arr['capital_en_title'] : $arr['capital_ar_title'];
                                echo '<option  value="'.$arr['capital_id'].'">'. $title.'</option>';

                            }
                            ?>

                        </select>
 </div>


 </div>

                                        
                                           <br/>
                                        
                                           
                                           
                                           <div class="modal-footer">
                                               <input type="submit" class="btn btn-primary btn-round" value="<?php echo $languages['cap_page']['submit']; ?>">
                                           </div>

                                       </form>



          <?php
}
?>