<!-- order_today -->
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

//get_today_orders
require_once("./Controller/DayController.php");
require_once("./Model/AddressModel.php");
$address_model1 = new address_model();
$day_controller      = new day_controller($address_model1, $con);

$i = 0;

require_once("./Controller/TodayOrderController.php");
require_once("./Model/ProgramModel.php");
include_once('./lang/' . $_SESSION['lang'] . '.php');
$date_model = new program_model();
$controller = new today_order_controller($con);
$current_date = date("Y-m-d");
// echo $current_date;
// // echo $today_date;
$order_program_arr = $controller->get_today_orders();
// print_r($order_program_arr);
if(is_array($order_program_arr)){
if (count($order_program_arr) > 0) {
  if ($_SESSION['role_id'] == "1") {
?>

  <?php
  }
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
          <table id="example" class="display" style="width:100%">
            <thead>
              <th><?php echo $languages['today_orders']['subscriber_name']; ?></th>
              <th><?php echo $languages['today_orders']['tele']; ?></th>
              <th><?php echo $languages['today_orders']['driver_name']; ?></th>
              <th><?php echo $languages['today_orders']['area']; ?></th>
              <th><?php echo $languages['today_orders']['block']; ?></th>
              <th><?php echo $languages['today_orders']['street']; ?></th>
              <th><?php echo $languages['today_orders']['avenue']; ?></th>
              <th><?php echo $languages['today_orders']['date']; ?></th>
            </thead>

            <?php
            // unset($_SESSION['order_today']);
              //print_r($order_program_arr);
            if (is_array($order_program_arr) || is_object($order_program_arr)) {
              for ($i = 0; $i < count($order_program_arr); $i++) {
                $address = "";
                $driver_name = "";
               // echo $order_program_arr[$i]['area_id'];
              //  print_r();
                $arr             = $day_controller->get_address_where_program_id($order_program_arr[$i]['user_area_id']);
                $driver_name     = $controller->get_driver_name_where_area_id($order_program_arr[$i]['area_id']);
                // echo "driver_name $driver_name <br/>";
                echo '<pre>'; print_r($driver_name); echo '</pre>';
                $user_name       = $controller->get_user_info_where_id($order_program_arr[$i]['user_area_id']);
                $area_name = ($_SESSION['lang'] == "en") ? $order_program_arr[$i]['area_name_eng'] : $order_program_arr[$i]['area_name_ar'];

                echo '<tr><td class="sorting_1" >' . $user_name["name"] . '</td>
                                     <td class="sorting_1" >' . $user_name["telep"] . '</td>
                                      <td class="sorting_1" >' . $area_name. '</td>
                                      <td class="sorting_1" >' . $area_name. '</td>
                                      <td class="sorting_1" >' . $arr['user_area_block'] . '</td>
                                      <td class="sorting_1" >' . $arr['user_area_street'] . '</td>
                                      <td class="sorting_1" >' . $arr['user_area_avenue'] . '</td>
                                      <td class="sorting_1" >' . $order_program_arr[$i]['program_day_date'] . '</td>

                             
                            </tr>';
              }
            }
            ?>


          </table>
        </div>

      </div>
    </div>
  </div>




<?php

}
}
}
?>