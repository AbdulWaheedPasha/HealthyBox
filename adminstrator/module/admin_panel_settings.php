<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
// admin_panel_settings
   require_once './Configuration/db.php';
  require_once './Controller/AdminstratorRoleController.php';
  $program_controller =  new adminstrator_role_controller($con);
  $user_arr           =  $program_controller->get_all_user_adminstration();
?>

            


<div class="col-md-12">

<?php

if(isset($_GET['action']) && isset($_GET['user_id'])){
    $message_error = base64_decode($_GET['action']);
    // echo $message_error;
    $Category_ID = base64_decode($_GET['user_id']);
    switch ($message_error) {
        case "Active":{
           mysqli_set_charset($con, "utf8");
           $active_query = "UPDATE `administration_tbl`  SET `administration_active`= 1 WHERE `administration_id`= $Category_ID ";
          // echo $active_query ;
           $active_mysqli_query = mysqli_query($con,$active_query);
           echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           </b>'.$languages['cap_page']['active'].'</b></div>';
           $page = "dashboard.php?type=admin_panel_settings";
           echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
         } 
       break; 
         case "Not-Active": {
           mysqli_set_charset($con, "utf8");
           $active_query = "UPDATE `administration_tbl`  SET `administration_active`  = 0 WHERE `administration_id`= $Category_ID ";
          // echo $active_query;
           $active_mysqli_query = mysqli_query($con,$active_query);
           echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
           </b>'.$languages['cap_page']['not_active'].'</b></div>';
           $page =  "dashboard.php?type=admin_panel_settings";
           echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
      
         }
       break;
       case "Delete": {
        mysqli_set_charset($con, "utf8");
        $active_query = "DELETE FROM `administration_tbl` WHERE `administration_id` = $Category_ID ";
       // echo $active_query;
        $active_mysqli_query = mysqli_query($con,$active_query);
        echo  '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$languages['cap_page']['delete'].'</b></div>';
        $page =  "dashboard.php?type=admin_panel_settings";
        echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
   
      }
    break;
       
            
        default:{
            
           
        }
     
    }
 
 }


?> 

<div class="row">
    <div class="col">
        <a href="dashboard.php?type=insert_new_user" class="btn btn-primary btn-round"><?php echo $languages['adminstrator']['add']; ?><div class="ripple-container"></div></a>

    </div>
</div><br />

              <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['menu_item']['admin_panel_settings']; ?></h4>
                  <p class="card-category"><?php echo $languages['adminstrator']['user']; ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table  class="table table-hover" style="width:100%" id="table">
                  
                        <thead>
                          <th><?php echo $languages['area']['en_name']; ?></th>
                          <th><?php echo $languages['login']['username']; ?></th>
                          <th><?php echo $languages['login']['password']; ?></th>
                          <th><?php echo $languages['login']['role']; ?></th>
                          <th><?php echo $languages['adminstrator']['status_user']; ?></th>
                          <th><?php echo $languages['area']['process']; ?></th>
                         
                        </tr>
                      </thead>
                        <?php
                        if (is_array($user_arr) || is_object($user_arr))
                        {
                        // if(count($user_arr[0]) > 0){
                       foreach ($user_arr  as  $arr) {
                           //print_r($arr);
                         if($arr['administration_active'] == 0) {
                           $icon = "close";
                           $title = "Not-Active";
                           $ope =  "Active";
                         }else{
                           $icon = "done";
                           $title = "Active";
                           $ope =  "Not-Active";
                         }
                
                         $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];
                            echo '<tr class="gradeA odd" role="row">
                            <td >'.$arr['administration_name'].'</td>
                            <td>'.base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_username'])))).'</td>
                            <td>'.base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_password'])))).'</td>
                            <td class="td-actions">
                                <a class="btn btn-primary btn-round"><i class="material-icons" style="margin: 0;">'.$icon.'</i><div class="ripple-container"></div></a> '.$title.'</td>
                                <td>'.$type.'</td>

                            <td class="td-actions">
                               <a href="dashboard.php?type=update_user&&user_id='.base64_encode($arr['administration_id']).'"  class="btn btn-primary btn-round btn-fab"><i class="material-icons" style="margin: 0;">edit</i><div class="ripple-container"></div></a>
                               <a href="dashboard.php?type=admin_panel_settings&&user_id='.base64_encode($arr['administration_id']).'&&action='.base64_encode($ope).'"  class="btn btn-info btn-round btn-fab"><i class="material-icons" style="margin: 0;">done</i><div class="ripple-container"></div></a>
                               <a href="dashboard.php?type=admin_panel_settings&&user_id='.base64_encode($arr['administration_id']).'&&action='.base64_encode("Delete").'"  class="btn btn-warning btn-round  btn-fab"><i class="material-icons" style="margin: 0;">delete_forever</i><div class="ripple-container"></div></a>

                          </td>
                            </tr>';
                        }
                      }
                      // }
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