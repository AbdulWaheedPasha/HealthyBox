<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
// area_report_detials
if(isset($_GET['pro_id'])){
    $capital_id = base64_decode($_GET['pro_id']);
    require_once("./Controller/TodayOrderController.php");
    require_once("./Controller/DayController.php");
    require_once("./Model/AddressModel.php");
    $address_model1 = new address_model();
    $day_controller      = new day_controller($address_model1, $con);
    $order_controller = new today_order_controller($con);
    $pre_arr         =   $order_controller->select_pro();
    $date            =  date("Y-m-d");

    // get area id 
    $user_area_ids_arr  = $order_controller->get_program_start_end_date_tbl($date,$capital_id);
    // print_r($user_area_ids_arr);
    $id_area_arr = Array();
    $counter  = 0;
    // set area id in array
    foreach ($user_area_ids_arr as $value) {
      $id_area_arr[$counter]  = $value['user_area_id'];
      $counter++;
    }
    // print_r($id_area_arr);
  
?>

<div class="col-md-12">

              <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['menu_item']['order']; ?></h4>
                  <p class="card-category"><?php echo $languages['today_orders']['describe']; ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">

<div class="card-body">


                

            
                </div>
                  <table  id="example" class="display" style="width:100%">
                    <thead>
                        <?php
echo '    <th >'.$languages['today_orders']['subscriber_name'].'</th>
<th >'.$languages['today_orders']['tele'].'</th>
<th >'.$languages['today_orders']['area'].'</th>
<th >'.$languages['today_orders']['block'].'</th>
<th >'.$languages['today_orders']['street'].'</th>
<th >'.$languages['today_orders']['avenue'].'</th>
<th >'.$languages['today_orders']['house_no'].'</th>
<th >'.$languages['today_orders']['building'].'</th>
<th >'.$languages['today_orders']['floor'].'</th>
<th >'.$languages['today_orders']['apart_num'].'</th>
<th >'.$languages['today_orders']['office_num'].'</th>
<th >'.$languages['today_orders']['subscriber_notes'].'</th>';


?>
                      </thead>

                      <?php
                         unset($_SESSION['order_today']);
                         $counter = 0;
                         for($i=0;$i<count($id_area_arr);$i++){
                          //  echo $value;
                          $order_program_arr  = $order_controller->get_all_order_where_user_area_id($id_area_arr[$i]);
                          $subscriber_name    = $order_controller->get_subscriber_name($id_area_arr[$i]);
                          $arr                = $day_controller->get_address_where_program_id($id_area_arr[$i]);
                          $driver_info_arr    = $order_controller->get_driver_name($capital_id);
              
                    
                          $counter++;
                          $area_name = ($_SESSION['lang'] == "en") ?  $arr['area_name_eng'] : $arr['area_name_ar'];
                      

                        echo '<tr><td >'.$subscriber_name['name'].'</td>
                        
                        <td >'.$subscriber_name['telep'].'-'.$subscriber_name['telep1'].'</td>
                        <td >'.$area_name.'</td>
                        <td >'.$arr['user_area_block'].'</td>
                        <td >'.$arr['user_area_street'].'</td>
                        <td >'.$arr['user_area_avenue'].'</td>
                        <td >'.$arr['user_area_house_num'].'</td>
                        <td >'.$arr['user_area_building_num'].'</td>
                        <td >'.$arr['user_area_floor'].'</td>
                        <td >'.$arr['user_area_apartment_num'].'</td>
                        <td >'.$arr['user_area_office_num'].'</td>
                        <td >'.$arr['user_area_notes'].'</td></tr>';
                      
                           
                        
                      }
                      // print_r($_SESSION['order_today']);
                        ?>

                    

                 
                    </table>
                  </div>
            
                </div>
              </div>
            </div>




<?php

                }
              }
                ?>