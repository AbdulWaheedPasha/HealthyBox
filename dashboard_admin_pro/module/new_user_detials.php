<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

?>
<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>

<?php

if (isset($_GET['id'])) {
  $id = base64_decode($_GET['id']);
  echo $id;
  require_once("./Controller/ProgramController.php");
  require_once("./Model/ProgramModel.php");
  include_once('./lang/' . $_SESSION['lang'] . '.php');
  $date_model = new program_model();
  $controller = new program_controller($date_model, $con);
  $controller->user_id =   $id;
//   $fetch_program = $controller->get_all_program();


  $user_sql = " SELECT *,admin.administration_active,admin.administration_name,admin.administration_telephone_number,admin.administration_telephone_number1,admin.administration_date_registeration
                        FROM  `administration_tbl` as admin  left JOIN `user_area_tbl` on admin.`administration_id` = `user_area_tbl`.`user_id` where admin.`administration_id` =  '$id' 
                        and admin.`administration_type_id` = 5 ";
            // echo  $user_sql;
  // Change character set to utf8
  mysqli_set_charset($con, "utf8");
  $rs = mysqli_query($con, $user_sql);
  
  while ($arr = mysqli_fetch_array($rs)) {
    $administration_id     = $arr['administration_id'];
    $administration_active = $arr['administration_active'];


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
                                <tr><td style="widtd:30%">' . $languages['login']['username'] . '</td><td>' . base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_username'])))). '</td></tr>
                                <tr><td style="widtd:30%">' . $languages['login']['password'] . '</td><td>' . base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_password'])))). '</td></tr>


      </tbody>
    </table>
    </div>
  </div>
</div>';
    $active_str = "";
    $hold_str = "";



    




  echo '</div>
        </div>
      </div>
    </div>';
}
}
}


?>