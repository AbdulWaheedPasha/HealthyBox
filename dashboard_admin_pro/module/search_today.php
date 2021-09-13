<!-- search_today -->

<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
//get_today_orders
require_once("./Controller/DayController.php");
require_once("./Model/AddressModel.php");
$address_model1 = new address_model();
$day_controller      = new day_controller($address_model1, $con);
//get_today_orders

require_once("./Controller/TodayOrderController.php");
require_once("./Model/ProgramModel.php");
include_once('./lang/' . $_SESSION['lang'] . '.php');
$date_model = new program_model();
$controller = new today_order_controller($con);
$current_date = date("Y-m-d");
$order_program_arr  = Array();

  $order_program_arr = $controller->search_orders();

if (count($order_program_arr) > 0) {
?>
  <div class="col-md-12">

    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title "><?php echo $languages['menu_item']['search_today']; ?></h4>
        <p class="card-category"><?php echo $languages['today_orders']['search_result']; ?></p>
      </div>
      <div class="card-body">
        <div class="table-responsive">
        <table  id="example" class="display" style="width:100%">
                    <thead>
                          <th><?php echo $languages['today_orders']['subscriber_name']; ?></th>
                          <th><?php echo $languages['today_orders']['driver_name']; ?></th>
                          <th><?php echo $languages['today_orders']['area']; ?></th>
                          <th><?php echo $languages['today_orders']['block']; ?></th>
                          <th><?php echo $languages['today_orders']['street']; ?></th>
                          <th><?php echo $languages['today_orders']['avenue']; ?></th>
                      </thead>

                      <?php
                      unset($_SESSION['order_today']);
                    //   print_r($order_program_arr);
                       for($i=0;$i<count($order_program_arr);$i++){
                        $address = "";
$arr             = $day_controller->get_address_where_program_id($order_program_arr[$i]['user_area_id']);


                            $area_name = ($_SESSION['lang'] == "en") ? $order_program_arr[$i]['area_name_eng'] : $order_program_arr[$i]['area_name_ar'];
                    
                            echo '<tr><td class="sorting_1" >' . $order_program_arr[$i]['name'] . '</td>
                                      <td class="sorting_1" >' . $order_program_arr[$i]['driver_name'] . '</td>
                                      <td class="sorting_1" >' . $area_name . '</td>



                                      <td class="sorting_1" >' . $arr['user_area_block'] . '</td>
                                      <td class="sorting_1" >' . $arr['user_area_street'] . '</td>
                                      <td class="sorting_1" >' . $arr['user_area_avenue'] . '</td>

                             
                            </tr>';
                           
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
?>