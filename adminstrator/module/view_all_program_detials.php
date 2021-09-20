<?php
//view_all_program_detials.php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

?>


  <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


  <script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
    $(document).ready(function() {
      $('#table').DataTable();
    });
  </script>
  <?php

  if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);
    
    require_once("./Controller/ProgramController.php");
    require_once("./Model/ProgramModel.php");
    include_once('./lang/' . $_SESSION['lang'] . '.php');
    $date_model = new program_model();
    $controller = new program_controller($date_model, $con);
    $controller->user_id =   $id;
    $fetch_program = $controller->get_all_program();

    
    // echo $fetch_program[0]['user_area_id'];

    # Get the Address START 
    require_once './Configuration/db.php';
    include_once('./lang/' . $_SESSION['lang'] . '.php');
    require_once("./Controller/DayController.php");
    require_once("./Model/AddressModel.php");
    $address_model1 = new address_model();
    $controller      = new day_controller($address_model1, $con);
    $user_area_id = "";
    if (count($fetch_program) > 0) {
      $user_area_id =  $fetch_program[0]['user_area_id'];
    }
    $area            = $controller->get_address_where_program_id($user_area_id);
    $area_type            = ($_SESSION['lang'] == "en") ? $area['area_name_eng'] : $area['area_name_ar'];
    $area_place_name      = ($_SESSION['lang'] == "en") ? $area['place_type_eng'] : $area['place_type_ar'];
    # Get the Address  END 


    $user_sql = " SELECT  DISTINCT admin.`administration_id` ,
                (SELECT `administration_type_name_ar` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id` )as type_ar, 
                (SELECT `administration_type_name_en` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id` ) as type_en,
                admin.administration_active,admin.administration_name,admin.administration_telephone_number,admin.administration_telephone_number1,admin.administration_date_registeration
                FROM  `administration_tbl` as admin  left JOIN `user_area_tbl` on admin.`administration_id` = `user_area_tbl`.`user_id` where admin.`administration_id` =  '$id' 
                and admin.`administration_type_id` = 5 ";

    //  echo  $user_sql;
    // Change character set to utf8
    mysqli_set_charset($con, "utf8");
    $rs = mysqli_query($con, $user_sql);

    while ($arr = mysqli_fetch_array($rs)) {
      $administration_id     = $arr['administration_id'];
      $administration_active = $arr['administration_active'];

      // echo $administration_id;
      $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];
      // if ($arr['administration_active'] == 1) {
      //   // $acive = $languages['driver']['active'];
      //   $acive = "Active";
      // } else if ($arr['administration_active'] == 2) {
      //   // $acive = $languages['driver']['not_active'];
      //   $acive = "Not active";
      // } else if ($arr['administration_active'] == 3) {
      //   // $acive = $languages['driver']['hold'];
      //   $acive = "Hold";
      // }
        // echo $administration_id .'---'. $administration_active;
      if ($arr['administration_active'] == 1) {
        // $acive = $languages['driver']['active'];
        $acive = "Active";
      } else if ($arr['administration_active'] == 2) {
        // $acive = $languages['driver']['not_active'];
        $acive = "Not active";
      } else if ($arr['administration_active'] == 3) {
        // $acive = $languages['driver']['hold'];
        $acive = "Hold";
      }


  ?>


      <?php
      // print_r($arr);
      echo '<div class="card">
            <div class="card-header card-header-text card-header-warning">
              <div class="card-text">
                <h4 class="card-title">' . $languages['program_detials']['program_subtitle'] . '</h4>
                <p class="card-category">' . $languages['program_detials']['program_subtitle'] . '</p>
            
              </div>
            </div>
  <div class="card-body table-responsive">
           <table class="table table-hover" >
           <tbody><tr><td style="widtd:30%">' . $languages['order']['name'] . '</td><td>' . $arr['administration_name'] . '</td></tr>
           <tr><td style="widtd:30%">' .  $languages['driver']['code'] . '</td><td>' . $arr['administration_id'] . '</td></tr>

                  <tr><td style="widtd:30%">' . $languages['order']['tele'] . '</td><td>' . $arr['administration_telephone_number'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['telep1'] . '</td><td>' . $arr['administration_telephone_number1'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['registered'] . '</td><td>' . $arr['administration_date_registeration'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['driver']['status'] . ' : </td><td>' . $_GET['status'] . '</td></tr>

                                

                                <tr><td style="widtd:30%">' . $languages['search']['area'] . ' </td><td >' . $area_type . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['block'] . ' </td><td >' . $area['user_area_block'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['street'] . ' </td><td >' . $area['user_area_street'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['avenue'] . '</td><td >' . $area['user_area_avenue'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['house_no'] . ' </td><td >' . $area['user_area_house_num'] . '</td></tr>
                                <tr><td  style="widtd:30%">' . $languages['order']['floor'] . '</td><td >' . $area['user_area_floor'] . '</td></tr>
                                <tr><td  style="widtd:30%">' . $languages['order']['apart_num'] . '</td><td >' . $area['user_area_apartment_num'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['figure'] . ' </td><td >' . $area['user_area_automated_figure'] . '</td></tr>
                                <tr><td  style="widtd:30%"> ' . $languages['order']['office_num'] . '</td><td >' . $arr['user_area_office_num'] . '</td></tr>
</tbody>
    </table>
    </div>
  </div>
</div>';
      $active_str = "";
      $hold_str = "";

      if (isset($_GET['delete_pro'])) {
        if ("Delete_program_user" == base64_decode($_GET['delete_pro'])) {
          $program_id = base64_decode($_GET['program_id']);
          $program_start_end_date_id = base64_decode($_GET['program_start_end_date_id']);


          $page_sql = "DELETE FROM `user_area_tbl` WHERE `user_area_tbl`.`user_area_id` = " . $program_start_end_date_id . "; ";
          mysqli_query($con, $page_sql);

          $page_sql = "DELETE  FROM `program_start_end_date_tbl` WHERE    `program_start_end_date_id`   =  " . $program_start_end_date_id . "; ";
          mysqli_query($con, $page_sql);

          $page_sql = "DELETE  FROM `program_day_tbl` WHERE `program_start_end_date_id` =   " . $program_start_end_date_id . "; ";
          mysqli_query($con, $page_sql);
         
          echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               </b>' . $languages['cap_page']['delete'] . '</b></div>';
      ?>
          <script>
            setTimeout(function() {
              window.location.href = 'dashboard.php?type=user_detials&&id=<?php echo $_GET['id']; ?>'
            }, 3000);
          </script>
<?php


        }
      }



      echo '<div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">' . $languages['program_detials']['all_program_title'] . '</h4>    
          </div>
      
        <div class="card-body">
        <p class="card-category">' . $languages['program_detials']['msg'] . '</p> 
          <div class="table-responsive">';

      if (count($fetch_program) > 0) {
        echo '<table id="example" class="table table-hover display" style="width:100%">
                <thead>
                  <tr>
                      <th>' . $languages['area']['en_name'] . '</th>
                      <th>' . $languages['area']['ar_name'] . '</th>
                      <th>' . $languages['order']['start'] . '</th>
                      <th>' . $languages['order']['end'] . '</th>
                      <th>' . $languages['area']['process'] . '</th>
                  </tr>
                </thead>
              <tbody>';
        for ($i = 0; $i < count($fetch_program); $i++) {

          $url = "dashboard.php?type=subscriber_time_table&&user_area_id=" . base64_encode($fetch_program[$i]['user_area_id']);
          echo  '
            <tr>
              <td>
              ' . $fetch_program[$i]['program_title_en'] . "(" . $fetch_program[$i]['program_duration'] . ")" . '
              </td>
              <td>
                ' . $fetch_program[$i]['program_title_ar'] . "(" . $fetch_program[$i]['program_duration'] . ")" . '
              </td>
              <td>
              ' . $fetch_program[$i]['program_start_date'] . '
              </td>
              <td>
              ' . $fetch_program[$i]['program_start_end'] . '
              </td>
              <td class="td-actions">';
          echo  $active_str . $hold_str . '<a class="btn btn-info btn-round" href="dashboard.php?type=more_detials_about_program&&id=' . base64_encode($fetch_program[$i]['user_area_id']) . '&&" ><i class="material-icons" style="margin: 0;">visibility</i></a>';
            if(count($fetch_program) > 1) {
             echo '<a href="dashboard.php?type=user_detials&&id=' . $_GET['id'] . '&&delete_pro=' . base64_encode("Delete_program_user") . '&&program_id=' . base64_encode($fetch_program[$i]['user_area_id']) . '&&program_start_end_date_id=' . base64_encode($fetch_program[$i]['program_start_end_date_id']) . '" class="btn btn-danger btn-round"> <i class="material-icons" style="margin: 0;">delete</i><div class="ripple-container"></div></a>';
            }
             echo '</td></tr>';
        }


        echo ' </tbody></table>';
      }


      echo '</div>
        </div>
      </div>
    </div>';
    }


    echo '<div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">' . $languages['program_detials']['hold'] . '</h4>
  <p class="card-category">' . $languages['program_detials']['hold_program'] . '</p>   </div>
        <div class="card-body">
          <div class="table-responsive">';
    $hold_array    = $controller->get_all_hold_status();
    if (count($hold_array) > 0) {
      echo '<table id="table" class="table table-hover display" style="width:100%">
                <thead>
                  <tr>
                  <th>
                  ' . $languages['program_detials']['day'] . '
                  </th>
                  <th>
                  ' . $languages['program_detials']['hold_program'] . '
                  </th>
                  <th>
                  ' . $languages['program_detials']['resume_program'] . '
                  </th>
                  </tr>
                </thead>
              <tbody>';
      for ($i = 0; $i < count($hold_array); $i++) {
        // echo $hold_array[$i]['hold_date_id'];
        $resume_date = $controller->resume_date_from_hold($hold_array[$i]['hold_date_id']);

        echo  '
            <tr>
              <td>
              ' . $hold_array[$i]['hold_date_num_days'] . '
              </td>
              <td>
              ' . $hold_array[$i]['hold_date_num_date'] . '
             </td>
              <td>
              ' . $resume_date['program_start_date'] . '
              </td>
            </tr>';
      }


      echo ' </tbody></table>';
    }


    echo '</div>
        </div>
      </div>
    </div>';
  }
}
?>