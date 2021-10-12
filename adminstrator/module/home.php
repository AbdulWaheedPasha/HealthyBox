<?php
// home.php

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

  require_once('./Configuration/db.php');
  require_once('./lang/' . $_SESSION['lang'] . '.php');
  require_once("./Controller/DayController.php");
  require_once("./Model/AddressModel.php");
  require_once("./Controller/CapitalController.php");
  require_once("./Controller/StatisticsController.php");

  $statistics_cont     = new statistics_controller($con);
  $type_search         = 3;
  $date                = 3;
  $title = $languages['menu_item']['month'];

  
  // $user_num_total      =  $statistics_cont->get_total_subscriber();
  // $user_num_total      = ($user_num_total > 0) ? $user_num_total : 0;

  // $active_user_total   =  $statistics_cont->get_number_subscriber_where_id(1);
  // $active_user_total   = ($active_user_total > 0) ? $active_user_total : 0;

  // $deactive_user_total =  $statistics_cont->get_number_subscriber_where_id(2);
  // $deactive_user_total = ($deactive_user_total > 0) ? $deactive_user_total : 0;

  // $hold_user_total     =  $statistics_cont->get_number_subscriber_where_id(3);
  // $hold_user_total      = ($hold_user_total > 0) ? $hold_user_total : 0;


  $website_num_user    =  $statistics_cont->get_num_user_website_app(1);
  $app_num_user        =  $statistics_cont->get_num_user_website_app(2);


  $array_of_user       =   $statistics_cont->get_number_subscriber_where_id(1);
  $user_num_total      = ($array_of_user[0] > 0) ? $array_of_user[0] : 0;
  $active_user_total   = ($array_of_user[1] > 0) ? $array_of_user[1] : 0;
  $hold_user_total      = ($array_of_user[2] > 0) ? $array_of_user[2] : 0;
  $non_active_user_total   = ($array_of_user[1] > 0) ? $array_of_user[3] : 0;


?>

<script>

    
$(document).ready(function(){

  console.log("document - ready ");

  $.ajax({
            type:'GET',
            url:'./ajax/dashboard_user_count.php',
            dataType: "json",
            // data:{user_id:user_id},
            success:function(data){

              console.log("T 1");
              // var jsonData = JSON.parse(JSON.stringify(data));
              console.log("T 2");
              console.log("SUCCESSS - data ", data);
              console.log("T 3 user :", data.totaluser);
   
              // document.getElementById("totaluser").innerHTML = jsonData.totaluser;
              // document.getElementById("nonactive").innerHTML = jsonData.nonactive;
              // document.getElementById("active").innerHTML = jsonData.active;
              // document.getElementById("hold").innerHTML = jsonData.hold;



              // console.log("SUCCESSS - data ", data);
              // document.getElementById("totaluser").innerHTML = data['totaluser'];
              // document.getElementById("nonactive").innerHTML = data['nonactive'];
              // document.getElementById("active").innerHTML = data['active'];
              // document.getElementById("hold").innerHTML = data['hold'];
   
            },
            error:function(x,e) {
                if (x.status==0) {
                    alert('You are offline!!\n Please Check Your Network.');
                } else if(x.status==404) {
                    alert('Requested URL not found.');
                } else if(x.status==500) {
                    alert('Internel Server Error.');
                } else if(e=='parsererror') {
                    alert('Error.\nParsing JSON Request failed.');
                } else if(e=='timeout'){
                    alert('Request Time out.');
                } else {
                    alert('Unknow Error.\n'+x.responseText);
                }
            }

        });

});
</script>




<div class="col-lg-3 col-md-6 col-sm-6">
  <div class="card card-stats">
    <div class="card-header card-header-success card-header-icon">
      <div class="card-icon">
        <i class="material-icons">person_add</i>
      </div>
      <p class="card-category"><?php echo $languages['home']['active_user']; ?></p>
      <h3 class="card-title" id="active">
          <div class="fa-3x"> <i class="fas fa-spinner fa-pulse"></i></div>
      </h3>
    </div>
    <div class="card-footer">
      <div class="stats">
      Active Users 
      </div>
    </div>
  </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
  <div class="card card-stats">
    <div class="card-header card-header-danger card-header-icon">
      <div class="card-icon">
        <i class="material-icons">emoji_people</i>
      </div>
      <p class="card-category"><?php echo $languages['home']['all']; ?></p>
    
      <h3 class="card-title" id="totaluser">
          <div class="fa-3x"> <i class="fas fa-spinner fa-pulse"></i></div>
      </h3>

    </div>
    <div class="card-footer">
      <div class="stats">
      Web App : <b id="" style="color:black;"> <?php echo  $website_num_user["counter"]; ?> </b>&nbsp;&nbsp;
      Mobile App : <b id="" style="color:black;"> <?php echo  $app_num_user["counter"]; ?> </b>

      </div>
    </div>
  </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
  <div class="card card-stats">
    <div class="card-header card-header-warning card-header-icon">
      <div class="card-icon">
        <i class="material-icons">person_remove</i>
      </div>
      <p class="card-category"><?php echo $languages['home']['hold_user'] ?></p>


      <h3 class="card-title" id="hold">
          <div class="fa-3x"> <i class="fas fa-spinner fa-pulse"></i></div>
      </h3>

    </div>
    <div class="card-footer">
      <div class="stats">
        Hold Users
      </div>
    </div>
  </div>
</div>


<div class="col-lg-3 col-md-6 col-sm-6">
  <div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
      <div class="card-icon">
        <i class="material-icons">person</i>
      </div>
      <p class="card-category">Not Active</p>

      <h3 class="card-title" id="nonactive">
          <div class="fa-3x"> <i class="fas fa-spinner fa-pulse"></i></div>
      </h3>

    </div>
    <div class="card-footer">
      <div class="stats">
        Not Active Users
      </div>
    </div>
  </div>
</div>




<div class="col-md-12">
            <div class="card ">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons"></i>
                </div>
                <h4 class="card-title"><?php echo $languages['home']['title_1']; ?></h4>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-6">
                  
       
                        <select name="cap" onchange="showStat(this.value)" class="custom-select" id="inputGroupSelect01">
                        echo ' <option value="0">اختر</option>';
                        <?php
                           $capital_model  = new capital_controller($con);
                           $capital_arr  = $capital_model->get_capital_tbl();
                         for ($count = 0; $count < count($capital_arr); $count++) {
                          $cap_name = ($_SESSION['lang'] == "en") ? $capital_arr[$count]['capital_en_title'] : $capital_arr[$count]['capital_ar_title'];
    
                           echo ' <option value="'.$capital_arr[$count]['capital_id'].'">'.$cap_name.'</option>';
                         }
                        ?>
                           
                          </select>
                           <div id="stat_div"></div>


                      
                   
                  </div>
                  <div class="col-md-6 ml-auto mr-auto">
                    <img src="../assets/img/kw-04.jpg" width="437.5" height="300">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script>
    // document.getElementById("test").innerHTML= "123";
    </script>

  <?php
  }
  ?>