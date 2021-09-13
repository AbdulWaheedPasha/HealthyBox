
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

if(isset($_GET['id'])){

$id = base64_decode($_GET['id']);
$user_sql = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en FROM `administration_tbl` as admin Where `administration_id` =  '$id' ";

// Change character set to utf8
      mysqli_set_charset($con,"utf8");
      $rs = mysqli_query($con,$user_sql);
      $all_num_rows = mysqli_num_rows($rs);
?>


<div class="col">
                <?php
if(isset($_GET['operation']) && isset($_GET['driver_area_id'])){
    $message_error = base64_decode($_GET['operation']);
    $driver_area_id = base64_decode(base64_decode(base64_decode($_GET['driver_area_id'])));
    switch ($message_error) {
 
    
            case "delete":
              $active_mysqli_query = mysqli_query($con, "DELETE FROM `driver_capital_tbl` WHERE `driver_capital_id`  =  $driver_area_id ");

              echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              </b>'.$languages['cap_page']['delete'].'</b></div>';
              $page =  "dashboard.php?type=".$_GET['type']."&&id=".$_GET['id'];
              echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
       
                  break;
        case "empty_field":
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> '.$languages['cap_page']['empty_field'].'</b></div>';
        $page =  "dashboard.php?type=".$_GET['type']."&&driver_area_id=".$_GET['driver_area_id'];
        echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
            break; 
        case "login_again":
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> '.$languages['cap_page']['empty_field'].'</b></div>';
            $page =  "dashboard.php?type=".$_GET['type']."&&id=".$_GET['id'];
            echo '<meta http-equiv="refresh" content="3;URL='.$page.'">';
         break;
 
            
        default:{
            
           
        }
     
    }
 
 }


?> 

<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"><?php echo $languages['driver']['driver_info']; ?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <?php
                       while ($arr = mysqli_fetch_array($rs)) {
                        $type = ( $_SESSION['lang'] == "en" ) ? $arr['type_en'] : $arr['type_ar'];

                        if($arr['administration_active'] == 1){
                            $acive = $languages['driver']['active'] ;
                        }else{
                            $acive = $languages['driver']['not_active'];
                        }
                        ?>
                        <thead>
                        <tr>
                          <th><?php echo $languages['area']['en_name']; ?>:</th>
                          <th><?php echo $arr['administration_name']; ?></th>
                        </tr>
                      
                          <tr>
                            <th><?php echo $languages['table_user']['date']; ?>:</th>
                            <th><?php echo $arr['administration_date_registeration']; ?></th>
                          </tr>
                        <tr>
                          <th><?php echo $languages['driver']['active']; ?>:</th>
                          <th><?php echo $type; ?></th>
                        </tr>
                        <tr>
                           <th><?php echo $languages['login']['username']; ?></th>
                           <th><?php echo base64_decode(base64_decode(base64_decode(base64_decode( $arr['administration_username'])))); ?></th>
                          </tr>
                          <tr>
                            <th><?php echo $languages['login']['password']; ?></th>
                            <th><?php echo base64_decode(base64_decode(base64_decode(base64_decode( $arr['administration_password'])))); ?></th>
                          </tr>
                      
                      </thead>
                        <?php
                    }


?>
</table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title "><?php echo $languages['cap_page']['main']; ?></h4>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                      <tr>
                       
                       <th class="hidden-xs"><?php echo $languages['area']['process']; ?></th>
                       <th><?php echo $languages['cap_page']['name_ar']; ?></th>
                       <th><?php echo $languages['cap_page']['name_en']; ?></th>
                   </tr>
                     </thead>
                      <tbody>
                          <?php
$query = "SELECT * FROM `capital_tbl` INNER JOIN `driver_capital_tbl` on `driver_capital_tbl`.`capital_id` = `capital_tbl`.`capital_id` where `driver_capital_tbl`.`driver_id` = $id  ";
// echo $query;
 mysqli_set_charset($con, "utf8");
$area_query = mysqli_query($con,$query);
$area_rows  = mysqli_num_rows($area_query);
while ($arr = mysqli_fetch_array($area_query)) {
  // print_r();
    ?>
  <tr>
                      <td class="td-actions">
                            <a href="dashboard.php?type=driver_detials&&driver_area_id=<?php echo base64_encode(base64_encode(base64_encode($arr['driver_capital_id'])));?>&&operation=<?php echo base64_encode('delete');?>&&id=<?php echo $_GET['id']; ?>" class="btn btn-danger" >
                              <i class="material-icons" style="margin: 0;">delete</i>
                            </a>
                          </td>
                

                        <td><?php echo  $arr['capital_en_title']; ?></td>
                       
                        <td><?php echo  $arr['capital_ar_title']; ?></td>
                      </tr>
    <?php
}

?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
                  </div>
<?php

                  }
                }
                  ?>