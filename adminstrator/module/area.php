<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
      
    <div class="container-fluid">

   
   <?php
                // area
if(isset($_GET['operation']) && isset($_GET['id'])){
    $message_error = base64_decode($_GET['operation']);
    $Category_ID = base64_decode(base64_decode(base64_decode($_GET['id'])));
    switch ($message_error) {
        case "active":
          
        mysqli_set_charset($con, "utf8");
        if($_GET['active'] == 1){
          $active_mysqli_query = mysqli_query($con, "UPDATE `area_tbl` SET `area_active`= 0 WHERE `area_id` = $Category_ID ");
          echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </b>'.$languages['cap_page']['active'].'</b></div>';

        }else{
          $active_mysqli_query = mysqli_query($con, "UPDATE `area_tbl` SET `area_active`= 1  WHERE `area_id` = $Category_ID ");
          echo  '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  </b>'.$languages['cap_page']['not_active'].'</b></div>';

        }
          
            break;
        case "dont_save":
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </b>'.$languages['cap_page']['error_ms'].'</b></div>';
 
            break;
            case "delete":
              $active_mysqli_query = mysqli_query($con, "Delete from `area_tbl`  WHERE `area_id` = $Category_ID ");

              echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              </b>'.$languages['cap_page']['delete'].'</b></div>';
       
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
<?php 
   if($_SESSION['role_id'] == "1" || $_SESSION['role_id'] == "2") {
?>

        <div class="col">
   <a href="dashboard.php?type=add_new_area" class="btn btn-primary btn-round"><?php  echo $languages['area_page']['add'];?><div class="ripple-container"></div></a>
   
</div>  
<?php 
   }
   ?>          
   
   <div class="row">
  


   <?php

$catpital_arr  = Array();
$counter = 0;
$cap_query  = "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl` ";
mysqli_set_charset($con, "utf8");
$cap_result = mysqli_query($con,$cap_query);
$num_cap    = mysqli_num_rows($cap_result);
if($num_cap > 0){
$active = "";
while($cap_arr =  mysqli_fetch_array($cap_result,MYSQLI_ASSOC)){
$cap_id_encrypt = base64_encode(base64_encode(base64_encode($cap_arr['capital_id'])));
$catpital_arr[$counter] = $cap_arr['capital_id'];
$title = ( $_SESSION['lang'] == "en" ) ? $cap_arr['capital_en_title'] : $cap_arr['capital_ar_title'];


?>
   <div class="col-lg-6 col-md-12">

              <div class="card card-profile">
                
                <div class="card-body">
                  <h3 class="card-category"><?php echo $title; ?></h3>
                 <?php 
$query = "SELECT * FROM `area_tbl` WHERE `area_tbl`.`capital_id` =  $cap_arr[capital_id] LIMIT 8 ";
//echo $query;
 mysqli_set_charset($con, "utf8");
$area_query = mysqli_query($con,$query);
$area_rows  = mysqli_num_rows($area_query);
?>
<table class="table table-hover">
<thead class="text-warning">
                    <tr>
                    <th>#</th>
                       <?php
   if($_SESSION['role_id'] == "1") {
                       ?>
                        <th class="hidden-xs"><?php echo $languages['area']['process']; ?></th>
                        <?php
   }
                        ?>
                 
                        <th><?php echo $languages['cap_page']['name_en']; ?></th>
                        <th><?php echo $languages['cap_page']['name_ar']; ?></th>
                        
                    </tr> 
                  </thead>

<?php
while ($arr = mysqli_fetch_array($area_query)) {

    $title = ( $_SESSION['lang'] == "en" ) ? $arr['area_name_eng'] : $arr['area_name_ar'];
    // echo '<div class="col-sm-4">  <a href="update_area.php?area_id='.base64_encode($arr['area_id']).'" class="btn btn-success"><i class="fa fa-edit"></i></a> 
    //  <a href="'.$url.'" class="btn btn-danger"> <i '.$class.'></i></a></div>';
    if($arr['area_active'] == "1"){
      $active_str = "&&active=1";
      $icon  = "done_all";
    }else{
      $active_str = "&&active=0";
      $icon = "close";
    }
    ?>

                      <tr>
                      <td><?php echo  $arr['area_order_by']; ?></td>
                      <?php
   if($_SESSION['role_id'] == "1") {
                       ?>
                      <td class="td-actions text-right">
                            <a href="dashboard.php?type=update_new_area&&id=<?php echo $area_id = base64_encode(base64_encode(base64_encode($arr['area_id'])));?>&&operation=<?php echo base64_encode('active');?>" rel="tooltip" class="btn btn-info" data-original-title="" title="">
                              <i class="material-icons" style="margin: 0;">edit</i>
                            <div class="ripple-container"></div></a>
                            <a href="dashboard.php?type=area&&id=<?php echo $area_id = base64_encode(base64_encode(base64_encode($arr['area_id'])));?>&&operation=<?php echo base64_encode('active').$active_str  ;?>" type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                              <i class="material-icons" style="margin: 0;"><?php echo $icon ;?></i>
</a>
                            <a href="dashboard.php?type=area&&id=<?php echo $area_id = base64_encode(base64_encode(base64_encode($arr['area_id'])));?>&&operation=<?php echo base64_encode('delete');?>" class="btn btn-danger" >
                              <i class="material-icons" style="margin: 0;">delete</i>
                            </a>
                          </td>
                          <?php
   }?>
                

                        <td><?php echo  $arr['area_name_eng']; ?></td>
                       
                        <td><?php echo  $arr['area_name_ar']; ?></td>
                      </tr>
                  
    <?php
  
   
}
echo '  
</tbody>
</table>';
                 ?>
                 
                  <a href="dashboard.php?type=view_all_area&&cap_id=<?php echo base64_encode(base64_encode(base64_encode($cap_arr['capital_id']))); ?>" class="btn btn-primary btn-round"><?php echo $languages['area_page']['All']; ?></a>
                </div>
              </div>
            </div>
        
          

                <?php
}
}
   
   
   ?>
  </div>
<?php

}
?>