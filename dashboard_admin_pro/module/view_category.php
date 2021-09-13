<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
require_once './Configuration/db.php';
  require_once './Controller/Program.php';
  $program_controller =  new all_program_controller($con);
  $program_arr =  $program_controller->fetc_cat();

?>

            
<!-- all_program -->

<div class="col-md-12">

<?php

if(isset($_GET['action']) && isset($_GET['program_id'])){
    $message_error = base64_decode($_GET['action']);
    // echo $message_error;
    $Category_ID = base64_decode($_GET['program_id']);
    switch ($message_error) {
        case "Active":{
           mysqli_set_charset($con, "utf8");
           $active_query = "UPDATE `program_tbl` SET `program_active`= 1 WHERE `program_id` = $Category_ID ";
          // echo $active_query ;
           $active_mysqli_query = mysqli_query($con,$active_query);
           echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           </b>'.$languages['cap_page']['active'].'</b></div>';
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
            
           
        }
     
    }
 
 }

 if( $_SESSION['role_id'] == "1") {
?> 

<div class="row">
    <div class="col">
        <a href="dashboard.php?type=insert_new_category" class="btn btn-primary btn-round"><?php echo $languages['category']['add_bttn']; ?><div class="ripple-container"></div></a>

    </div>
</div><br />
<?php
 }?>

              <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['category']['title']; ?></h4>
                  <p class="card-category"><?php echo $languages['category']['sub_title']; ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table  style="width:100%">
                  
                        <thead>
                          <th><?php echo $languages['area']['en_name']; ?></th>
                          <th><?php echo $languages['area']['ar_name']; ?></th>
                          <?php  if( $_SESSION['role_id'] == "1") { ?>
                          <th><?php echo $languages['area']['process']; ?></th>
                          <?php } ?>
                         
                        </tr>
                      </thead>
                        <?php
                       foreach ($program_arr as  $arr) {
                            echo '<tr class="gradeA odd" role="row">
                            <td >'.$arr['type_en'].'</td>
                            <td>'.$arr['type_ar'].'</td>';
                          if($_SESSION['role_id'] == "1") {
                        echo  '  <td class="td-actions">
                               <a href="dashboard.php?type=update_category&&category_id='.base64_encode($arr['program_id']).'"  class="btn btn-primary btn-round btn-fab"><i class="material-icons" style="margin: 0;">edit</i><div class="ripple-container"></div></a>
                             

                          </td>';
                       }
                           echo ' </tr>';
                        }
                            ?>
                      </tbody>
                    </table>
                  </div>
   
                  
                </div>
              </div>
            </div>

<?php

                      }
                      ?>