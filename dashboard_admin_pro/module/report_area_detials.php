<?php
// area_report_detials

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

if(isset($_GET['pro_id'])){
    $capital_id = base64_decode($_GET['pro_id']);
    require_once("./Controller/TodayOrderController.php");
    require_once("./Controller/DayController.php");
    require_once("./Model/AddressModel.php");
    $address_model1      = new address_model();
    $day_controller      = new day_controller($address_model1, $con);
    $order_controller    = new today_order_controller($con);
    $pre_arr             = $order_controller->select_pro();
    date_default_timezone_set('Asia/Kuwait');
    $new_date = date('Y-m-d 00:00:00');
 

    // get area id 
    $user_area_ids_arr  = $order_controller->get_program_start_end_date_tbl($new_date,$capital_id);
    // print_r($user_area_ids_arr);
    $id_area_arr = Array();
    $counter  = 0;
    // set area id in array
    foreach ($user_area_ids_arr as $value) {
      $id_area_arr[$counter]  = $value['user_area_id'];
      $counter++;
    }
    // print_r($id_area_arr);
  

    if($_SESSION['role_id'] == "1" || $_SESSION['role_id'] == "2" || $_SESSION['role_id'] == "6") {
?>

<div class="col">
              <div class="card card-profile">
               
                <div class="card-body">
                  <h4 class="card-title">Print- الطباعة</h4>
                  <p class="card-description">
                  <select name="print_type" onChange="redirectUrl()" id="print_type" style="width:100%" >
                  <option value="0">اختر - select</option>
  <option value="1"><?php echo $languages['menu_item']['print_k']; ?>-English</option>
  <option value="2"><?php echo $languages['menu_item']['print_d']; ?>-English</option>
  <option value="3"><?php echo $languages['menu_item']['print_m']; ?>-English</option>
  <option value="4"><?php echo $languages['menu_item']['print_k']; ?>-Arabic</option>
  <option value="5"><?php echo $languages['menu_item']['print_d']; ?>-Arabic</option>
  <option value="6"><?php echo $languages['menu_item']['print_m']; ?>-Arabic</option>
</select>                   </p>
                
                </div>
              </div>
            </div>
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
                  <table   class="display" style="width:100%;text-align:center;">
                    <tr  style="width:100%;text-align:center;">
                          <th style="text-align:center;"><?php echo $languages['driver']['code']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['subscriber_name']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['website']['telephone']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['driver_name']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['area']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['block']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['street']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['avenue']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['today_orders']['house_no']; ?></th>
                          <th style="text-align:center;"><?php echo $languages['order']['figure1']; ?></th>
                      </tr>

                      <?php
                         unset($_SESSION['order_today']);
                         $counter = 0;
                         $_SESSION['order_today']['date']               = $new_date;
                         $_SESSION['count'] = count($id_area_arr);
                         for($i=0;$i<count($id_area_arr);$i++){
                          // print_r($id_area_arr);
                          $_SESSION['order_today']['capital_id'] = $capital_id;
                      
                          $order_program_arr  = $order_controller->get_all_order_where_user_area_id($id_area_arr[$i]);
                          $subscriber_name    = $order_controller->get_subscriber_name($id_area_arr[$i]);
                          $arr                = $day_controller->get_address_where_program_id($id_area_arr[$i]);
                          $driver_info_arr    = $order_controller->get_driver_name($capital_id);
                          $program_arr        = $order_controller->get_program_day($order_program_arr[0]['program_id']);

              
                          $address = "";
                          $_SESSION['order_today'][$i]['color']                         = $order_program_arr['color'] ;
                          $_SESSION['order_today'][$i]['user_id']                       = $subscriber_name['administration_id'] ;
                          $_SESSION['order_today'][$i]['user_area_automated_figure']    = $arr['user_area_automated_figure'] ;
                          $_SESSION['order_today'][$i]['user_area_block']               = $arr['user_area_block'] ;
                          $_SESSION['order_today'][$i]['user_area_street']              = $arr['user_area_street'] ;
                          $_SESSION['order_today'][$i]['user_area_avenue']              = $arr['user_area_avenue'] ;
                          $_SESSION['order_today'][$i]['user_area_house_num']           = $arr['user_area_house_num'] ;
                          $_SESSION['order_today'][$i]['user_area_floor']               = $arr['user_area_floor'] ;
                          $_SESSION['order_today'][$i]['user_area_apartment_num']       = $arr['user_area_apartment_num'] ;
                          $_SESSION['order_today'][$i]['user_area_notes']               = $arr['user_area_notes'] ;
                          $_SESSION['order_today'][$i]['user_area_building_num']        = $arr['user_area_building_num'] ;
                          $_SESSION['order_today'][$i]['user_area_office_num']          = $arr['user_area_office_num'] ;
                          $_SESSION['order_today'][$i]['user_area_notes']               = $arr['user_area_notes'] ;
                          $_SESSION['order_today'][$i]['user_area_block']               = $arr['user_area_block'] ;
                          $_SESSION['order_today'][$i]['area_name_eng']                 = $arr['area_name_eng'] ;
                          $_SESSION['order_today'][$i]['area_name_ar']                  = $arr['area_name_ar'] ;
                          $_SESSION['order_today'][$i]['user_area_notes']               = $arr['user_area_notes'];
                          $_SESSION['order_today'][$i]['user_area_driver_notes']        = $arr['user_area_driver_notes'];
                          $_SESSION['order_today'][$i]['name']                          = $subscriber_name['name'] ;
                          $_SESSION['order_today'][$i]['tele']                          = $subscriber_name['telep'] ;
                          $_SESSION['order_today'][$i]['telep1']                        = $subscriber_name['telep1'] ;
                          $_SESSION['order_today'][$i]['program_title_ar']              = $program_arr['program_title_ar'] ;
                          $_SESSION['order_today'][$i]['program_title_en']              = $program_arr['program_title_en'] ;
                          
                          $counter++;
                          $area_name = ($_SESSION['lang'] == "en") ?  $arr['area_name_eng'] : $arr['area_name_ar'];
                          echo '<tr style="text-align:center; border: 0.1px solid gray;color:'.$order_program_arr['color'].'">
                                   <td class="sorting_1"  >' . $subscriber_name['administration_id'] . '</td>
                                    <td class="sorting_1" >' . $subscriber_name['name'] . '</td>
                                    <td class="sorting_1" > ' . $subscriber_name['telep'] . '-'.$subscriber_name['telep1'].'</td>
                                   
                                    
                                    <td class="sorting_1" >' . $driver_info_arr['name'] . '</td>
                                    <td class="sorting_1" >' . $area_name . '</td>
                                    <td class="sorting_1" >' . $arr['user_area_block'] . '</td>
                                    <td class="sorting_1" >' . $arr['user_area_street'] . '</td>
                                    <td class="sorting_1" >' . $arr['user_area_avenue'] . '</td>
                                    <td class="sorting_1" >' . $arr['user_area_house_num'] . '</td>
                                    <td class="sorting_1" >' . $arr['user_area_automated_figure'] . '</td>
                                  </tr>';
                      
                           
                        
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