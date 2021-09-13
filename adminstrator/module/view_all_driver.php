<div class="container-fluid">
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
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
           $page = "dashboard.php?type=driver";
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
           $page =  "dashboard.php?type=driver";
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
            session_destroy();
            header('Location:./index.php?err=1');
            exit();
           
        }
     
    }
 
 }

 if($_SESSION['role_id'] == "1") {
      ?> 

<a href="dashboard.php?type=add_new_driver" class="btn btn-primary btn-round"><?php echo $languages['driver']['add']; ?><div class="ripple-container"></div></a>
<?php
 }?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['menu_item']['driver']; ?></h4>
            <p class="card-category"><?php echo $languages['driver']['describe']; ?></p>
        </div>
                <div class="card-body">
                  <div class="table-responsive">

                  <?php
$user_sql = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en FROM `administration_tbl` as admin Where `administration_type_id` = 4 ";
 

mysqli_set_charset($con, "utf8");
$rs = mysqli_query($con, $user_sql);
$all_num_rows = mysqli_num_rows($rs);
?>
                <table id="example" class="table table-hover display" style="width:100%">
                    <thead>
                        
                         <th><?php echo $languages['area']['en_name']; ?></th>
                        <th><?php echo $languages['driver']['active']; ?></th>
                        <th><?php echo $languages['table_user']['type']; ?></th>
                        <th><?php echo $languages['table_user']['date']; ?></th>
                        <?php
                         if($_SESSION['role_id'] == "1") {
                        ?>
                        <th><?php echo $languages['area']['process']; ?></th>
                        <?php
                         }
                         ?>
                    </thead>
                    <tbody>
                        <?php
                        while ($arr = mysqli_fetch_array($rs)) {
                            $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];

                            if($arr['administration_active'] == 0) {
                                $icon = "close";
                                $title = "Not-Active";
                                $ope =  "Active";
                                $acive = $languages['driver']['not_active'];
                              }else{
                                $icon = "done";
                                $title = "Active";
                                $ope =  "Not-Active";
                                $acive = $languages['driver']['active'];
                               
                              }


                            echo '<tr >
                            
                            <td>' . $arr['administration_name'] . '</td>
                            <td>' . $type . '</td>
                            <td>' . $acive . '</td>
                            <td>' . $arr['administration_date_registeration'] . '</td>';

                            if($_SESSION['role_id'] == "1") {
                                  echo '<td>
                                  <a href="dashboard.php?type=update_driver&&id=' . base64_encode($arr['administration_id']) . '" class="btn btn-info btn-round btn-fab"> <i class="material-icons" style="margin: 0;">edit</i></a>
                                  <a href="dashboard.php?type=driver&&user_id='.base64_encode($arr['administration_id']).'&&action='.base64_encode($ope).'"  class="btn btn-warning btn-round  btn-fab"><i class="material-icons" style="margin: 0;">done</i><div class="ripple-container"></div></a>
      
                                  <a href="dashboard.php?type=driver_detials&&id=' . base64_encode($arr['administration_id']) . '" class="btn btn-success btn-round btn-fab"> <i class="material-icons" style="margin: 0;">touch_app</i></a>
                                  </td>';
                            }
                          
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                   
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        </div>
        <?php
}
?>