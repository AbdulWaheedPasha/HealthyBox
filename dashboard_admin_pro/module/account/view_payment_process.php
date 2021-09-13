
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

if(isset($_GET['payment_id'])){
$payment_id = base64_decode($_GET['payment_id']);
$order_sql    = "SELECT `payment_id`, `payment_date`, `payment_time`, `payment_status_id`, `user_area_id`, `paymentId` FROM `payment_tbl` where `payment_id` = '$payment_id'  ";
// echo $order_sql;
mysqli_set_charset($con,"utf8");
$order_query  = mysqli_query($con,$order_sql);


?>

          




                <?php

if(mysqli_num_rows($order_query) > 0){
     while ($arr = mysqli_fetch_array($order_query)) {
       $user_query = "SELECT `administration_tbl`.`administration_name`,
                      `administration_tbl`.`administration_telephone_number` ,
                      `administration_tbl`.`administration_telephone_number1`,
                      `administration_tbl`.`administration_date_registeration`,
                      `user_area_tbl`.`user_area_inserted`,`administration_tbl`.`administration_updated`   FROM `administration_tbl` INNER JOIN `user_area_tbl`  on `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` where `user_area_tbl`.`user_area_id` = '$arr[user_area_id]' ";
        //echo $user_query;
        $user_sql = mysqli_query($con,$user_query);
        //echo "SELECT `administration_tbl`.`administration_name`,`administration_tbl`.`administration_telephone_number` ,`administration_tbl`.`administration_telephone_number`, `administration_tbl`.`administration_telephone_number1`,`user_area_tbl`.`user_area_inserted`  FROM `administration_tbl` INNER JOIN `user_area_tbl`  on `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id` where `user_area_tbl`.`user_area_id` = '$arr[user_area_id]' ";
        $user_row = mysqli_fetch_row($user_sql);
        // print_r($user_row);
        
        echo '<div class="card">
        <div class="card-header card-header-text card-header-warning">
          <div class="card-text">
            <h4 class="card-title">'   . $languages['program_detials']['program_header'] . '</h4>
            <p class="card-category">' . $languages['program_detials']['program_subtitle'] . '</p>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover" >
            <tbody>
            <tr><td style="widtd:30%">' . $languages['order']['name'] . '</td><td>' . $user_row[0] . '</td></tr>
                                      <tr><td style="widtd:30%">' . $languages['order']['tele'] . '</td><td>' . $user_row[1] . '</td></tr>
                                      <tr><td style="widtd:30%">' . $languages['order']['telep1'] . '</td><td>' . $user_row[2] . '</td></tr>
                                      <tr><td style="widtd:30%">' . $languages['order']['registered'] . '</td><td>' . $user_row[3] . '</td></tr>';
                                  


          
        $program_query  = "SELECT * FROM  `user_area_tbl` INNER JOIN `program_tbl` on `user_area_tbl`.`program_id` = `program_tbl`.`program_id` INNER JOIN `payment_tbl` ON `payment_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id` WHERE `user_area_tbl`.`user_area_id` = '$arr[user_area_id]' " ;
        //echo $program_query;
        $program_result = mysqli_query($con,$program_query);
        while($fetch_program = mysqli_fetch_array($program_result)){
            //print_r($fetch_program);
          $payment_sql = mysqli_query($con," SELECT `payment_status_en`, `payment_status_ar` FROM `payment_status_tbl` WHERE `payment_status_id` = '$arr[payment_status_id]' ");
          $paymeny_row = mysqli_fetch_row($payment_sql);
          $payment_status_str = ($_SESSION['lang'] == "en") ? $paymeny_row[0] : $paymeny_row[1];


            echo  '<tr> <td>' . $languages['area']['program_en_name'].' :</td><td>'.  $fetch_program['program_title_en']."(" . $fetch_program['program_duration'].")".'</td></tr>
            <tr><td>' . $languages['area']['program_ar_name'] .':</td><td>' . $fetch_program['program_title_ar']."(" . $fetch_program['program_duration'].")".'</td></tr> ';
            echo '  <tr><td style="widtd:30%">'.$languages['payment_table']['date'].'</td><td>' . $fetch_program['payment_date'] . '</td></tr>
                    <tr><td style="widtd:30%">'.$languages['payment_table']['time'].'</td><td>' . $fetch_program['payment_time'] . '</td></tr>
                    <tr><td style="widtd:30%">'.$languages['payment_table']['process'].'</td><td>' .  $payment_status_str . '</td></tr>
                    <tr><td style="widtd:30%">'.$languages['payment_table']['price'].'</td><td>' . $fetch_program['payment_price'] . ' K.D </td></tr>

                    <tr><td style="widtd:30%">Order ID</td><td>' . $fetch_program['user_area_order_id'] . '</td></tr>
                    <tr><td style="widtd:30%">Payment ID   </td><td>' . $fetch_program['paymentId'] . '</td></tr>
                    <tr><td style="widtd:30%">Transaction ID</td><td>' . $fetch_program['payment_Tran_Id'] . '</td></tr>
                 
                    <tr><td style="widtd:30%">Track ID</td><td>' . $fetch_program['payment_TrackID'] . '</td></tr>';

                    if(!empty($user_row[5])){
                        echo '<tr><td style="widtd:30%">'.$languages['website']['remenew_date'].'</td><td>' . $user_row[5] . '</td></tr>';
                    }
             



                    
        }
    
    
        echo '    </tbody>
        </table> 
          </div>
        </div>
      </div>';



  
  
     }
     
}

}
}
?>

