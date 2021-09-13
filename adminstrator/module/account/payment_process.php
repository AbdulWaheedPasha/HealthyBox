
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

//payment_process
$order_sql    = "SELECT `payment_id`, `payment_date`, `payment_time`, `payment_status_id`, `user_area_id`, `paymentId` FROM `payment_tbl` order by `payment_id` DESC ";
// echo $order_sql;
mysqli_set_charset($con,"utf8");
$order_query  = mysqli_query($con,$order_sql);


?>

          


<div class="col-md-12">


            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title "><?php    echo $languages['payment_table']['payment']; ?></h4>
                <p class="card-category"><?php echo $languages['payment_table']['header'];    ?></p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
              
                <?php

if(mysqli_num_rows($order_query) > 0){
  
?>
                <table  id="example" class="display" style="width:100%">

                
                      <thead>
                      <tr>
                        <th><?php echo $languages['payment_table']['name'];       ?></th>
                        <th><?php echo $languages['payment_table']['telephone'];  ?></th>
                        <th><?php echo $languages['payment_table']['process'];     ?></th>
                        <th><?php echo $languages['payment_table']['date'];        ?></th>
                        <th><?php echo $languages['payment_table']['time'];        ?></th>
                        <th><?php echo $languages['payment_table']['process'];     ?></th>
                        <th><?php echo $languages['website']['remenew_date'];     ?></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                    while ($arr = mysqli_fetch_array($order_query)) {
                        $query_user = "SELECT `administration_tbl`.`administration_name`,
                                    `administration_tbl`.`administration_telephone_number` ,
                                    `user_area_tbl`.`user_area_inserted`,`administration_tbl`.`administration_id`,
                                    `administration_tbl`.`administration_updated`  FROM `administration_tbl` INNER JOIN `user_area_tbl`  on `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` where `user_area_tbl`.`user_area_id` = '$arr[user_area_id]' ";
                        
                        $user_sql = mysqli_query($con,$query_user);
                      
                       $user_row = mysqli_fetch_row($user_sql);
                     

                        $payment_sql = mysqli_query($con," SELECT `payment_status_en`, `payment_status_ar` FROM `payment_status_tbl` WHERE `payment_status_id` = '$arr[payment_status_id]' ");
                        $paymeny_row = mysqli_fetch_row($payment_sql);
                        $payment_status_str = ($_SESSION['lang'] == "en") ? $paymeny_row[0] : $paymeny_row[1];
                        
                        $program_sql = mysqli_query($con,"SELECT  `program_duration` FROM `program_tbl` INNER JOIN `user_area_tbl` on `user_area_tbl`.`program_id` = `program_tbl`.`program_id` where `user_area_tbl`.`user_area_id` = '$arr[user_area_id]' ");
                        $program_row = mysqli_fetch_row($program_sql);
                       


                        $bttn_renew = "";
                        // echo $user_row[3];
                        if($arr['payment_status_id'] == 3){
                          $bttn_renew = '<a class="btn btn-danger btn-round btn-fab"  data-val="'.$user_row[3].'"  
                                                                                      data-href="'.$arr['user_area_id'].'" 
                                                                                      data-progress="'.$program_row[0].'" >
                                                                                      <i class="material-icons" style="margin: 0;">autorenew</i></a>';


                        }
                        echo '
                        <tr>
                              <td >'.$user_row[0].'</td>
                              <td>'.$user_row[1].'</td>
                              <td>'.$payment_status_str.'</td>
                              <td>'.$arr['payment_date'].'</td>
                              <td>'.$arr['payment_time'].'</td>
                              <td class="td-actions">
                                    <a href="dashboard.php?type=view_payment_process&&payment_id='.base64_encode($arr['payment_id']).'"  
                                    class="btn btn-primary btn-round btn-fab"><i class="material-icons" style="margin: 0;">table_view</i>
                                    <div class="ripple-container"></div></a>
                                  '.$bttn_renew.'
                              </td>
                              <td>'.$user_row[4].'</td>
                          </tr>';
                      }
                          ?>
                    </tbody>
                  </table>

                  <?php

                    }
                    ?>
                </div>
 
                
              </div>
            </div>
          </div>


<script>
               // renew request 
                   $(document).ready(function() {
                       $(".btn-danger").click(function() {
                           //alert("Clicked");
                           var para = {
                               id: $(this).attr('data-val'),
                               user_area_id: $(this).attr('data-href'),
                               duration_day: $(this).attr('data-progress'),
                           };
                           console.log("here");
                           Notify.confirm({
                               title: '<?php echo $languages['order']['renew']; ?>',
                               html: '<b><?php echo $languages['order']['renew_question']; ?></b>',
                               ok: function() {
                                    $.ajax({
                                       type: 'POST',
                                       url: './ajax/insert_new_program_ajax.php',
                                       data: para,
                                       success: function(data) {
                                          //  alert(data);
                                           var jsonData = JSON.parse(data);
                                           if (jsonData.result == "1") {
                                               Notify.suc({
                                                   title: 'OK',
                                                   text: jsonData.message,
                                               });

                                               setTimeout(function() {
                                                   location.reload();
                                               }, 2000);
                                           } else {
                                               Notify.suc(jsonData.message);
                                           }

                                       }

                                   });
                               },
                               cancel: function() {
                                   Notify.suc('<?php echo $languages['alert']['cancel']; ?>');
                               }
                           });
                       });
                   });
                  
             
               </script>

               <?php
}
?>