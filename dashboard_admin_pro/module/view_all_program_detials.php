<?php
//view_all_program_detials.php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

?>


<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


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
    if ($arr['administration_active'] == 1) {
      $acive = $languages['driver']['active'];
    } else if ($arr['administration_active'] == 2) {
      $acive = $languages['driver']['not_active'];
    } else if ($arr['administration_active'] == 3) {
      $acive = $languages['driver']['hold'];
    }

    ?>


    <?php
    // print_r($arr);
    echo '<div class="card">
            <div class="card-header card-header-text card-header-warning">
              <div class="card-text">
                <h4 class="card-title">'.$languages['program_detials']['program_subtitle'].'</h4>
                <p class="card-category">'.$languages['program_detials']['program_subtitle'].'</p>
              </div>
            </div>
  <div class="card-body table-responsive">
           <table class="table table-hover" >
           <tbody><tr><td style="widtd:30%">' . $languages['order']['name'] . '</td><td>' . $arr['administration_name'] . '</td></tr>
           <tr><td style="widtd:30%">' .  $languages['driver']['code'] . '</td><td>' . $arr['administration_id'] . '</td></tr>

                  <tr><td style="widtd:30%">' . $languages['order']['tele'] . '</td><td>' . $arr['administration_telephone_number'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['telep1'] . '</td><td>' . $arr['administration_telephone_number1'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['order']['registered'] . '</td><td>' . $arr['administration_date_registeration'] . '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['driver']['active'] . '</td><td>' . $acive . '</td></tr>


      </tbody>
    </table>
    </div>
  </div>
</div>';
    $active_str = "";
    $hold_str = "";

    if(isset($_GET['delete_pro'])){
      if("Delete_program_user" == base64_decode($_GET['delete_pro'])){
        $program_id = base64_decode($_GET['program_id']);
        $program_start_end_date_id = base64_decode($_GET['program_start_end_date_id']);
        // echo $program_start_end_date_id;
       // echo program_id
       // get id for days 
    

      //  $page_sql = "DELETE FROM  `user_area_tbl` where `user_area_id` = 10 ";
        $page_sql  = "DELETE  FROM  `user_area_tbl`  WHERE        `user_area_id` =  ". $program_id."; ";
       // echo   $page_sql."<br/>";
        mysqli_query($con, $page_sql);
        $page_sql = "DELETE  FROM `program_day_tbl` WHERE `program_start_end_date_id` =   ".$program_start_end_date_id."; ";
        //echo   $page_sql."<br/>";
        mysqli_query($con, $page_sql);
        $page_sql = "DELETE  FROM `program_start_end_date_tbl` WHERE    `program_start_end_date_id`   =  ".$program_start_end_date_id."; ";
      //  echo   $page_sql."<br/>";
        mysqli_query($con, $page_sql);
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
               </b>'.$languages['cap_page']['delete'].'</b></div>';   
         
        
      }

    }



    echo '<div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-icon card-header-rose">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">' . $languages['program_detials']['all_program_title'] . '</h4>
          <p class="card-category">' . $languages['program_detials']['all_program'] . '</p>        </div>
        <div class="card-body">
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
        // if ($_SESSION['role_id'] == 1) {
        //   if ($administration_active == 1) {
        //     $acive = $languages['driver']['active'];
        //     $hold_str = '<a  class="btn btn-warning btn-round btn-fab"  data-val="' . base64_encode($administration_id) . '"  data-href="' . base64_encode(base64_encode(base64_encode($fetch_program[$i]['user_area_id']))) . '" > <i class="material-icons" style="margin: 0;">pause</i></a>';
        //     $active_str = '<a class="btn btn-danger btn-round btn-fab" data-val="' . base64_encode($administration_id) . '" 
        //                                                                   data-href="' . base64_encode(base64_encode(base64_encode($fetch_program[$i]['user_area_id']))) . '" 
        //                                                                   data-progress="' . $fetch_program[$i]['program_duration'] . '"  ><i class="material-icons" style="margin: 0;">autorenew</i></a>';
        //   } else if ($administration_active == 2) {
        //     $acive      = $languages['driver']['not_active'];
        //     $hold_str   = '<a  class="btn btn-warning btn-round btn-fab"  data-val="' . base64_encode($administration_id) . '"   data-href="' . base64_encode(base64_encode(base64_encode($fetch_program[$i]['user_area_id']))) . '" > <i class="material-icons" style="margin: 0;">pause</i></a>';
        //     $active_str = '<a class="btn btn-danger btn-round btn-fab" data-val="' . base64_encode($administration_id) . '" 
        //                                                                     data-href="' . base64_encode(base64_encode(base64_encode($fetch_program[$i]['user_area_id']))) . '" 
        //                                                                     data-progress="' . $fetch_program[$i]['program_duration'] . '"  ><i class="material-icons" style="margin: 0;">autorenew</i></a>';
        //   }
        // }
        
        echo  $active_str . $hold_str . '<a class="btn btn-info btn-round" href="dashboard.php?type=more_detials_about_program&&id='.base64_encode($fetch_program[$i]['user_area_id']).'&&" ><i class="material-icons" style="margin: 0;">visibility</i></a>
        <a href="dashboard.php?type=user_detials&&id='.$_GET['id'].'&&delete_pro='.base64_encode("Delete_program_user").'&&program_id='.base64_encode($fetch_program[$i]['user_area_id']).'&&program_start_end_date_id='.base64_encode($fetch_program[$i]['program_start_end_date_id']).'" class="btn btn-danger btn-round"> <i class="material-icons" style="margin: 0;">delete</i><div class="ripple-container"></div></a>';
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