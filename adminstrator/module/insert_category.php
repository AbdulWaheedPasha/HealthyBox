<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php echo $languages['cap_page']['title']; ?></h4>
                 
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
                                       <form action="./post/insert_capitial.php" method="post" enctype="multipart/form-data"
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
                                           </div>

                                        
                                           <br/>
                                        
                                           
                                           
                                           <div class="modal-footer">
                                               <input type="submit" class="btn btn-primary btn-round" value="<?php echo $languages['cap_page']['submit']; ?>">
                                           </div>

                                       </form>


                 
                </div>
              </div>
  <?php
   }
?>