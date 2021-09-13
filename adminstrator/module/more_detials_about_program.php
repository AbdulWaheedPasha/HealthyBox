<?php
//more_detials_about_program
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

  error_reporting(0);
  if (isset($_GET)) {
    $user_area_id =  base64_decode($_GET['id']);
    //echo  $user_area_id;
    // if(is_numeric($user_area_id)){
    require_once './Configuration/db.php';
    include_once('./lang/' . $_SESSION['lang'] . '.php');
    require_once("./Controller/DayController.php");
    require_once("./Model/AddressModel.php");
    $address_model1 = new address_model();
    $controller      = new day_controller($address_model1, $con);
    $arr             = $controller->get_address_where_program_id($user_area_id);

    $type            = ($_SESSION['lang'] == "en") ? $arr['area_name_eng'] : $arr['area_name_ar'];
    $place_name      = ($_SESSION['lang'] == "en") ? $arr['place_type_eng'] : $arr['place_type_ar'];
?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">emoji_transportation</i>
          </div>
          <h4 class="card-title"><?php echo $languages['order']['add']; ?></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <?php
            if (isset($_GET['delete']) && isset($_GET['main_id'])) {
              $message_error = base64_decode($_GET['delete']);
              $Category_ID   = base64_decode($_GET['main_id']);
              switch ($message_error) {

                case "Delete":



                  $select_end_date_sql = "SELECT `program_start_date`,`program_start_end` FROM `program_start_end_date_tbl` WHERE `user_area_id` = $user_area_id";
                  //  echo  $user_sql;
                  // Change character set to utf8
                  mysqli_set_charset($con, "utf8");
                  $select_end_date_rs = mysqli_query($con, $select_end_date_sql);

                  while ($end_date_arr = mysqli_fetch_array($select_end_date_rs)) {


                    $select_delete_date_sql = "SELECT `program_day_date` from `program_day_tbl` WHERE `program_day_id` = $Category_ID ";
                    $select_detete_date_rs  = mysqli_query($con, $select_delete_date_sql);
                    while ($select_date_arr    = mysqli_fetch_array($select_detete_date_rs)) {
                      $selected_date_arr = explode(" 00:00:00", $select_date_arr['program_day_date']);
                      if ($selected_date_arr[0] ==  $end_date_arr['program_start_end']) {
                        $active_mysqli_query = mysqli_query($con, "DELETE FROM `program_day_tbl` WHERE `program_day_id` = $Category_ID ");
                        $last_date_query      = "SELECT max(`program_day_date`) as max_Date FROM `program_day_tbl` WHERE `program_start_end_date_id` = $user_area_id ";
                        $active_mysqli_query  = mysqli_query($con, $last_date_query);
                        while ($max_arr       = mysqli_fetch_array($active_mysqli_query)) {
                          $selected_date_arr  = explode(" 00:00:00", $max_arr['max_Date']);
                          $end_date_query     = "UPDATE `program_start_end_date_tbl` SET `program_start_end` = '$selected_date_arr[0]' WHERE `program_start_end_date_id` = $user_area_id  ";
                          $end_date_rs         = mysqli_query($con, $end_date_query);
                        }
                      } else {
                        $active_mysqli_query = mysqli_query($con, "DELETE FROM `program_day_tbl` WHERE `program_day_id` = $Category_ID ");
                      }
                    }
                  }
                  echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              </b>' . $languages['cap_page']['delete'] . '</b></div>';

                  break;
                case "empty_field":
                  echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> ' . $languages['cap_page']['empty_field'] . '</b></div>';
                  break;
                case "login_again":
                  echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> ' . $languages['cap_page']['empty_field'] . '</b></div>';
                  break;


                default: {
                  }
              }
            }
            ?>


            <h4 class="card-title"><?php echo $languages['order']['more_detials']; ?></h4>
            <?php
            if ($arr['place_id'] == 1) {
              echo '<table class="table"><tr><td style="widtd:30%">' . $languages['search']['area'] . '</td><td > ' . $type . '</td></tr>';
              // echo '<tr><td style="widtd:30%">' . $languages['order']['unit'] . '</td><td >' . $place_name . '</td></tr>';

              echo '<tr><td style="widtd:30%">' . $languages['order']['block'] . ' </td><td >' . $arr['user_area_block'] . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['street'] . ' </td><td >' . $arr['user_area_street'] . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['avenue'] . '</td><td >' . $arr['user_area_avenue'] . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['house_no'] . ' </td><td >' . $arr['user_area_house_num'] . '</td></tr>
  <tr><td  style="widtd:30%">' . $languages['order']['floor'] . '</td><td >' . $arr['user_area_floor'] . '</td></tr>
  <tr><td  style="widtd:30%">' . $languages['order']['apart_num'] . '</td><td >' . $arr['user_area_apartment_num'] . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['figure'] . ' </td><td >' . $arr['user_area_automated_figure'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%"> ' . $languages['order']['note'] . '</td><td >' . $arr['user_area_notes'] . '</td></tr></table>';
            } else if ($arr['place_id'] == 2) {
              echo '<table class="table"><tr><td style="widtd:30%"> ' . $languages['search']['area'] . ' </td><td >' . $area_name . '</td></tr>';
              // echo '<tr><td  style="widtd:30%"> ' . $languages['order']['unit'] . ' </td><td > ' . $place_name . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['figure'] . ' </td><td >' . $arr['user_area_automated_figure'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['block'] . '</td><td >' . $arr['user_area_block'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['street'] . '</td><td >' . $arr['user_area_street'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['avenue'] . '</td><td >' . $arr['user_area_avenue'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['building'] . '</td><td >' . $arr['user_area_building_num'] . '</td></tr>
                                       <tr><td  style="widtd:30%">' . $languages['order']['floor'] . '</td><td >' . $arr['user_area_floor'] . '</td></tr>
                                       <tr><td  style="widtd:30%">' . $languages['order']['apart_num'] . '</td><td >' . $arr['user_area_apartment_num'] . '</td></tr>
                                       <tr><td  style="widtd:30%"> ' . $languages['order']['note'] . '</td><td >' . $arr['user_area_notes'] . '</td></tr>
                                       </table>';
            } else if ($arr['place_id'] == 3) {

              echo '<table class="table"><tr><td style="widtd:30%">' . $languages['search']['area'] . '</td><td >' . $area_name . '</td></tr>';
              // echo '<tr><td style="widtd:30%">' . $languages['order']['unit']   . '</td><td >' . $place_name . '</td></tr>';
              echo '<tr><td style="widtd:30%">' . $languages['order']['figure'] . ' </td><td >' . $arr['user_area_automated_figure'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['block']  . '</td><td >' . $arr['user_area_block'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['street']  . '</td><td >' . $arr['user_area_street'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%">' . $languages['order']['avenue']  . '</td><td >' . $arr['user_area_avenue'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%"> ' . $languages['order']['building'] . '</td><td >' . $arr['user_area_building_num'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%"> ' . $languages['order']['floor'] . '</td><td >' . $arr['user_area_floor'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%"> ' . $languages['order']['office_num'] . '</td><td >' . $arr['user_area_office_num'] . '</td></tr>';
              echo '<tr><td  style="widtd:30%"> ' . $languages['order']['note'] . '</td><td >' . $arr['user_area_notes'] . '</td></tr>';
              echo '</table>';
            }

            ?>
            <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>
            <script>
              // $(document).ready(function() {
              //     $('#example').DataTable();
              // });
              $(document).ready(function() {
                $('#exp').DataTable();
              });
            </script>

            <?php

            echo '<div>
<form action="./post/insert_day.php" method="post" enctype="multipart/form-data" name="form" id="form" >
<div class="form-group" id="Result"></div>
<input class="form-control" name="user_area_id" value="' . $arr['program_start_end_date_id'] . '" type="hidden"> 
</div>
<input type="submit" class="btn btn-primary btn-round" value="' . $languages['cap_page']['add_day'] . '">
</div>
</form>';

            ?>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script>
              $(document).ready(function() {
                $("#form").on("submit", function(e) {

                  var postData = $(this).serializeArray();
                  var formURL = $(this).attr("action");

                  $.ajax({
                    url: formURL,
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                      //  alert(data);
                      var jsonData = JSON.parse(data);
                      if (jsonData.result == "1") {
                        Notify.suc({
                          title: 'OK',
                          text: jsonData.message,
                        });
                        setTimeout(function() {
                          window.location.href = "dashboard.php?type=more_detials_about_program&&id=<?php echo $_GET['id']; ?>";
                        }, 3000);
                      } else {
                        Notify.suc(jsonData.message);
                      }
                    },
                    error: function(jqXHR, status, error) {
                      alert(status + ": " + error);
                      // console.log(status + ": " + error);
                    }
                  });
                  e.preventDefault();
                });

                $("#submitForm").on('click', function() {
                  $("#form").submit();
                });
              });
            </script>
            <?php

            $program_day_arr = $controller->get_program_day_tbl($arr['program_start_end_date_id']);
            if (count($program_day_arr) > 0) {
              echo '<div id="accordion" role="tablist">

                  <div class="card-collapse">
                    <div class="card-header" role="tab" id="headingOne">
                      <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                          ' . $languages['order']['Date'] . '
                          <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                      </h5>
                    </div>
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                      <div class="card-body">';

              echo '<table  id="exp" class="table table-striped table-bordered" style="width:100%">';
              echo '<thead>
            
  <th>' . $languages['program']['title'] . '</th>
  <th>' . $languages['program']['cost'] . '</th>
  <th>' . $languages['program']['date'] . '</th>';

              if ($_SESSION['role_id'] == "1") {
                echo  '<th> ' . $languages['area']['process'] . '</th>';
              }
              echo '</thead>';
              $co = 1;

              foreach ($program_day_arr as $pro_arr) {
             
                echo '<tr><td>' . $pro_arr["program_day_date"] . '</td>
                          <td>' . $pro_arr["program_day_en"] . '</td>
                          <td>' . $pro_arr["program_day_ar"] . '</td>';
                if ($_SESSION['role_id'] == "1") {
                  if ($co != 1) {
                    echo '<td  valign="center"><a href="dashboard.php?type=more_detials_about_program&&id=' . $_GET['id'] . '&&main_id=' . base64_encode($pro_arr["program_day_id"]) . '&&delete=' . base64_encode("Delete") . '" class="btn btn-danger btn-fab"> <i class="material-icons" style="margin: 0;">delete</i></a> </td> ';
                  }
                }
                $co++;

                echo '</tr>';
              }


              echo '</tbody>
                    </table>';
              echo '</div>
                    </div>
                  </div></div>';

            ?>

          </div>
        </div>
      </div>
    </div>


<?php
            }
          } else {
            die(header('location: ../error404.php'));
          }
        }
?>