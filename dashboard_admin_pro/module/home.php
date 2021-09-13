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
   $user_num_total      =  $statistics_cont->get_number_subscriber_where_id(0);
   $active_user_total   =  $statistics_cont->get_number_subscriber_where_id(1);
   $deactive_user_total =  $statistics_cont->get_number_subscriber_where_id(4);
   $hold_user_total     =  $statistics_cont->get_number_subscriber_where_id(3);
   $website_num_user    = $statistics_cont->get_num_user_website_app(1);
   $app_num_user        = $statistics_cont->get_num_user_website_app(2);


?>
<div class="content">
        <div class="content">
          <div class="container-fluid">
          <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">person</i>
                    </div>
                    <p class="card-category"><?php echo $languages['home']['active_user']; ?></p>
                    <h3 class="card-title"><?php echo    $active_user_total["counter"]; ?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
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
                    <h3 class="card-title"><?php echo   $user_num_total["counter"]; ?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      
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
                    <p class="card-category"><?php echo $languages['home']['hold_user']; ?></p>
                    <h3 class="card-title"><?php echo  $hold_user_total["counter"]; ?></h3>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">person_add</i>
                     
                    </div>
                    <p class="card-category"><?php echo $languages['home']['deactive_user']; ?></p>
                    <h6 class="card-title">Website : <?php echo  $website_num_user["counter"]; ?></h6>
                    <h6 class="card-title">App     : <?php echo  $app_num_user["counter"]; ?></h6>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="row">
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
                        <div class="table-responsive table-sales">
                          <table class="table"><tr>
                          
                            <th class="th-description"><?php echo $languages['home']['capital_name']; ?></th>
                            
                            <th class="text-right"><?php echo $languages['home']['all']; ?></th>
                            <th class="text-right"><?php echo $languages['home']['active_user']; ?></th>
                            <th class="text-right"><?php echo $languages['home']['hold_user']; ?></th>
                         
                            <th></th>
                        </tr>
                            <tbody>
                              <?php
                                $capital_model  = new capital_controller($con);
                                $capital_arr  = $capital_model->get_capital_tbl();
                              for($count = 0;$count<count($capital_arr);$count++){
                                $cap_name = ($_SESSION['lang'] == "en") ? $capital_arr[$count]['capital_en_title'] : $capital_arr[$count]['capital_ar_title'];
                             
                                $user_num      =  $statistics_cont->get_number_subscriber($capital_arr[$count]['capital_id']);
                                $active_user   =  $statistics_cont->get_number_subscriber_where_status($capital_arr[$count]['capital_id'],1);
                                $deactive_user =  $statistics_cont->get_number_subscriber_where_status($capital_arr[$count]['capital_id'],4);
                                $hold_user     =  $statistics_cont->get_number_subscriber_where_status($capital_arr[$count]['capital_id'],3);
                                echo '  <tr>
                                           <td>'.$cap_name.'</td>
                                           <td>'.$user_num.'</td>
                                           <td>'.$active_user.'</td>
                                           <td>'.$hold_user.'</td>
                                           
                                           
                                        </tr>'; 
                              }
                              ?>
                            
                         
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6 ml-auto mr-auto">
                          <img src="../assets/img/kw-04.jpg" width="437.5" height="300">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          

            
            
    
          </div>
        </div>
      </div>
<?php
}
?>
