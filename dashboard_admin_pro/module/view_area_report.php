<!-- view area report -->
<?php

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

  date_default_timezone_set('Asia/Kuwait');
  $new_date = date('Y-m-d 00:00:00');
  // echo $new_date;

  ?>
<div class="card">
            <div class="card-body">
              <div class="row">
<?php

require_once("./Controller/TodayOrderController.php");
require_once("./Model/ProgramModel.php");
include_once('./lang/' . $_SESSION['lang'] . '.php');
$date_model = new program_model();
$order_controller = new today_order_controller($con);
$pre_arr         =   $order_controller->select_pro();
if(is_array($pre_arr)){
  if(count($pre_arr) > 0){
    for($i=0;$i<count($pre_arr);$i++){
        $date =  date("Y-m-d");
        // $count_num     =   $order_controller->get_num_order_where_area_id($pre_arr[$i]['capital_id'],$date);
        $pre_str       = ($_SESSION['lang'] == "en") ? $pre_arr[$i]['capital_en_title'] : $pre_arr[$i]['capital_ar_title'];
        $counter_order = $order_controller->get_num_order_where_area_id($new_date,$pre_arr[$i]['capital_id']); 
        $capital_id = base64_encode($pre_arr[$i]['capital_id']);
        echo '<div class="col-4">
                    <div class="card">
                        <div class="card-body text-center">

                            <h5 class="card-text">'.$pre_str.'</h5>
                            <p class="description">'.$counter_order['counter'].'</p>
                            <a class="btn btn-primary btn-round btn-fab" href="dashboard.php?type=area_report_detials&&pro_id='.$capital_id.'"><i class="material-icons">table_view</i><div class="ripple-container"></div></a>
                        </div>
                    </div>';
                    echo '</div>';
        }
       
   
}
}


?>  
               


              </div>
       
             
              
            </div>
          </div>

          <?php

}
?>