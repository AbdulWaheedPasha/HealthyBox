<?php $i = 1; ?>


<?php
  require_once '../Configuration/db.php';
  $startOrder     = $_POST['startOrder'];
  $endOrder       = $_POST['endOrder'];
  $branch_id      = $_POST['branch_id']; 
$total_cash = 0 ;



?>

<div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h3>حساب المصروفات</h3>
                        </div>
                        <div class="panel-body">
                            <p>
                            <?php
                                 $expenses_cost = 0;
                                 require_once '../class_file/leader_class.php';
                                 $current_date = date("Y-m-d");
                                 if(!empty($branch_id) && empty($where_query)){
                                      $where_query  = " where `branch_id` = '$branch_id' ";
                                 }else if(!empty($branch_id) && !empty($where_query)) {
                                    $where_query  = " and `branch_id` = '$branch_id' ";

                                 }
                                 if(!empty($startOrder) && empty($endOrder)  && empty($where_query) ){
                                    $where_query =  " where `expenses_detials_date` =  '$startOrder'  ";
                                } else if(!empty($startOrder) && empty($endOrder)  && !empty($where_query) ){
                                    $where_query =  $where_query . " and `expenses_detials_date` =  '$startOrder'  ";
                                }
                                 if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
                                    $where_query =  " where   `expenses_detials_date`  = '$endOrder'  and `branch_id` = '$branch_id' ";
                                } else if(empty($startOrder) && !empty($endOrder) && !empty($where_query) ){
                                    $where_query =  $where_query . " and   `expenses_detials_date`  = '$endOrder'  and `branch_id` = '$branch_id' ";
                                }
                                if(!empty($startOrder) && !empty($endOrder)){
                                    $where_query =  " where `expenses_detials_date` between '$startOrder' and '$endOrder'  and `branch_id` = '$branch_id' ";
                                }else  if(!empty($startOrder) && !empty($endOrder)){
                                    $where_query =   $where_query . " and  `expenses_detials_date` between '$startOrder' and '$endOrder'  and `branch_id` = '$branch_id' ";
                                }  
                                // $where_sql =  "where `expenses_detials_date` = '$current_date' and `branch_id` =  '$_SESSION[branch_id]'  ";
                                 $leader_class  = new leader_class(); 
                                 $expenses_cost = $leader_class->get_total_expenses($where_query);
                                 //echo $expenses_cost;
                                  echo  "<h1>".$expenses_cost. " دينار  </h1>";
                                 

                                ?> </p>
                        </div>
                    
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h3> عمولات السائقين </h3>
                        </div>
                        <div class="panel-body">
                             <p>
                                <?php
                                $where_query = "";
                                 require_once '../class_file/leader_class.php';
                                 if(!empty($branch_id)  && empty($where_query) ){
                                    $where_query = " where `order_tbl`.`branch_id` = '$branch_id' and `order_administration_tbl`.`order_administration_cost` != '0.000'";
                                }else  if(!empty($branch_id) && !empty($where_query) ){
                                    $where_query =  $where_query . " and `order_tbl`.`branch_id` = '$branch_id' and `order_administration_tbl`.`order_administration_cost` != '0.000'";

                                }
                                 if(!empty($startOrder) && empty($endOrder) && empty($where_query) ){
                                    $where_query =  " where `order_tbl`.`order_created_at` = '$startOrder'  ";
                                 }else if(!empty($startOrder) && empty($endOrder) && !empty($where_query)){
                                    $where_query =  $where_query . " and `order_tbl`.`order_created_at` = '$startOrder'  ";

                                 }
                                if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
                                    $where_query =  " where   `order_tbl`.`order_created_at` = '$endOrder' ";
                                }else if(empty($startOrder) && !empty($endOrder) && !empty($where_query) ){
                                    $where_query = $where_query . " and   `order_tbl`.`order_created_at` = '$endOrder' ";
                                }
                                if(!empty($startOrder) && !empty($endOrder) && empty($where_query)){
                                    $where_query = " where `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                                } else if(!empty($startOrder) && !empty($endOrder) && !empty($where_query)){
                                    $where_query = $where_query  . " and `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                                }      
                                $leader_class  = new leader_class(); 
                                $driver = $leader_class->get_total_cost($where_query);
                                 echo  "<h1>".$driver."دينار </h1>";
                                ?> 
                            </p>

                        </div>
                 
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h3>  حساب الكاش </h3>
                        </div>
                        <div class="panel-body">
                            <p>
                                <?php
                                  $where_query  = "";
                                 require_once '../class_file/leader_class.php';
                                 if(!empty($branch_id) && empty($where_query) ){
                                    $where_query = " where `order_tbl`.`branch_id` = '$branch_id' and `order_tbl`.`order_status_id` = 6";

                                }else if(!empty($branch_id) && !empty($where_query)){
                                    $where_query = $where_query . " and `order_tbl`.`branch_id` = '$branch_id' and `order_tbl`.`order_status_id` = 6";

                                }
                                 if(!empty($startOrder) && empty($endOrder) && empty($where_query) ){
                                     $where_query =  " where `order_tbl`.`order_created_at` =  '$startOrder' ";
                                 }else if(!empty($startOrder) && empty($endOrder) && !empty($where_query)){
                                    $where_query = $where_query  . " and `order_tbl`.`order_created_at` =  '$startOrder' ";

                                 }
                                 if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
                                     $where_query = " where  `order_tbl`.`order_created_at` = '$endOrder' ";
                                 } else if(empty($startOrder) && !empty($endOrder)  && !empty($where_query) ){
                                    $where_query = $where_query  . " and   `order_tbl`.`order_created_at` = '$endOrder' ";
                                 }
                                 if(!empty($startOrder) && !empty($endOrder) && empty($where_query)){
                                     $where_query =  " where `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                                 }  else  if(!empty($startOrder) && !empty($endOrder)  && !empty($where_query)){
                                    $where_query = $where_query  . " and `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                                }                                
                                 $leader_class  = new leader_class();
                                 $cash = $leader_class->get_total_price($where_query);
                                 //echo $cash;
                                 $cash = $cash - ($driver + $expenses_cost);
                                 echo  "<h1> ".$cash." دينار </h1>";

                                ?> 
                            </p>
                        </div>

                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                        حساب الكاش

                        </div>
                        <div class="panel-body">
                            <?php
                            $i = 0;
                              $total_cash = 0 ;
           
                              mysqli_set_charset($con,"utf8");

                             
                              if(!empty($branch_id) && empty($where_query) ){
                                $where_query = " where `order_tbl`.`branch_id` = '$branch_id' and `order_tbl`.`order_status_id` = 6";

                            }else if(!empty($branch_id) && !empty($where_query)){
                                $where_query = $where_query . " and `order_tbl`.`branch_id` = '$branch_id' and `order_tbl`.`order_status_id` = 6";

                            }
                             if(!empty($startOrder) && empty($endOrder) && empty($where_query) ){
                                 $where_query =  " where `order_tbl`.`order_created_at` =  '$startOrder' ";
                             }else if(!empty($startOrder) && empty($endOrder) && !empty($where_query)){
                                $where_query = $where_query  . " and `order_tbl`.`order_created_at` =  '$startOrder' ";

                             }
                             if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
                                 $where_query = " where  `order_tbl`.`order_created_at` = '$endOrder' ";
                             } else if(empty($startOrder) && !empty($endOrder)  && !empty($where_query) ){
                                $where_query = $where_query  . " and   `order_tbl`.`order_created_at` = '$endOrder' ";
                             }
                             if(!empty($startOrder) && !empty($endOrder) && empty($where_query)){
                                 $where_query =  " where `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                             }  else  if(!empty($startOrder) && !empty($endOrder)  && !empty($where_query)){
                                $where_query = $where_query  . " and `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                            }      
                           
                            $order_sql = "Select * FROM `order_tbl`" .$where_query. " GROUP by `order_tbl`.`order_id` DESC ";
                           // echo $order_sql;
                
                               
                             
                            $order_query  = mysqli_query($con,$order_sql);
                            if(mysqli_num_rows($order_query) > 0){  
                                ?>
                                <div id="order_div"></div> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center"> التسلسل</th>
                                            <th style="text-align:center">تغير حالة الدفع </th>
                                            <th style="text-align:center">رقم الطلب</th>
                                          
                                           
                                            <th style="text-align:center">السعر </th>
                                        </tr>
                                        </thead>
                                    <?php
                        while ($arr = mysqli_fetch_array($order_query)) {
                            $color = "";
                            $order_pay_sql = "SELECT `order_pay_id`, `order_id`, `delivery_id` FROM `order_pay_tbl` WHERE `order_id` = '$arr[order_id]' ";
                            //echo  $order_pay_sql;
                            mysqli_set_charset($con, "utf8");
                            $order_pay_rs = mysqli_query($con,$order_pay_sql);
                            $order_fetch  = mysqli_fetch_row($order_pay_rs);
                          
                           
                            if(count($order_fetch) == 0){
                                $color = 'style="background: #f2dede;"';
                                
                            }else{
                                $pay_id    = $order_fetch[2]; 
                                if($pay_id ==  2){
                                    // wasn't pay
                                    $color = 'style="background: #fcf8e3;"';
                                  
                                }else{
                                   
                                    // pay
                                    $color = 'style="background: #dff0d8;"';
                                }
                                 
                            }
                            
                            ?>
                                    <tbody >
                                        <tr <?php echo $color; ?>>
                                        <td style="text-align:center"><?php echo $i++;?></td>
                                        <td>
                                        <?php
  if($arr['payment_status_id'] == 2){
                                        ?>
                                        <input type="radio"   name="order_status_<?php echo $arr['order_id']; ?>"  value="1" > تم الدفع  
                                        <input type="radio"   name="order_status_<?php echo $arr['order_id']; ?>"  value="2"> لم يتم الدفع

                                            <input id="buttoncheck_<?php echo $arr['order_id']; ?>" type="button" name="btn" value="تغيير" class="btn btn btn-success"></input>

                                            <script type="text/javascript">
    $(function() {
        $('#buttoncheck_<?php echo $arr['order_id']; ?>').click(function () {
            var var_name = $("input[name='order_status_<?php echo $arr['order_id']; ?>']:checked").val();
           // $('#btn_get').val(var_name);
            //alert(var_name);
            var myKeyVals = { "order_id" :<?php echo $arr['order_id']; ?>, "value" : var_name }

                var postData = $(this).serializeArray();
                $.ajax({
                    url: "./post/money_post.php",
                    type: "POST",
                    data: myKeyVals,
                    success: function(data, textStatus, jqXHR) {
                        // alert(data);
                        $('#order_div').html(data);
                        // $("#Result_Div").remove();
                        setTimeout(function() { location.reload(); }, 1000);
                    },
                    error: function(jqXHR, status, error) {
                        console.log(status + ": " + error);
                    }
                });
                e.preventDefault();
        });
    });
</script>
<?php
  }
  ?>
                                       </td>
                                        <td style="text-align:center"><?php echo $arr['order_number'];?></td>
                                       

                                       
                                        <td>
                                        <?php
            $order_administration_sql = "SELECT * FROM `order_administration_tbl` WHERE `order_id` =  '$arr[order_id]' and `order_administration_cost` <> '0.000'";
            $order_administration_rs = mysqli_query($con, $order_administration_sql);
            $order_administration_arr = mysqli_fetch_row($order_administration_rs);
            $user_mysqli_query = mysqli_query($con, "SELECT *,(SELECT `administration_type_name` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type  FROM `administration_tbl` as admin where `administration_type_id` = 4 ");
            while ($arr2 = mysqli_fetch_array($user_mysqli_query)) {
                if($order_administration_arr[2] == $arr2['administration_id']){
                    echo $arr2['administration_name'];
                }
            }
        ?>
                        </td>
                        <td>

           <?php
        if ($arr['payment_status_id'] == 2) {
            $price1 = "";
            $product_price ="";
               
            ///echo $price_sql;
                
            $msg_sql = "SELECT  `order_msg_content` FROM `order_msg_tbl` WHERE `order_id` = '$arr[order_id]' ";
            //echo  $msg_sql."<br/>";
            mysqli_set_charset($con, "utf8");
            $msg_rs = mysqli_query($con, $msg_sql);
            $msg_fetch  = mysqli_fetch_row($msg_rs);
            //echo $msg_fetch[0];
              
            //get message by id
            // SELECT  `order_msg_content` FROM `order_msg_tbl` WHERE `order_id` =
        
             
            //echo  $msg_fetch[0];
            if (!empty($msg_fetch[0])) {
                $price_sql   = "SELECT  * ,(`order_lists_tbl`.`product_price`) as list_price, (`additions_item_tbl`.`additions_item_price`) as product_price
            FROM `additions_item_tbl` 
            INNER JOIN `order_lists_tbl` ON `additions_item_tbl`.`additions_item_id` = `order_lists_tbl`.`product_id` 
            where  `order_lists_tbl`.`order_id` =  '$arr[order_id]' ";
                $product_rs = mysqli_query($con, $price_sql);
                while ($product_arr = mysqli_fetch_array($product_rs)) {
                    // print_r($product_arr);
                    $price1 = "";
                    if ($product_arr['list_price'] != 0) {
                        $price1 = $product_arr['list_price'];
                    } else {
                        $price1 = $product_arr['product_price'];
                    }
                    // echo $price1."<br/>";
        
                    $product_price =  $price1 + $product_price;
                }
                echo  $product_price .  " دينار كويتي";
                $order_pay_sql = "SELECT `order_pay_id`, `order_id`, `delivery_id` FROM `order_pay_tbl` WHERE `order_id` =  '$arr[order_id]' ";
                //echo  $order_pay_sql;
                mysqli_set_charset($con, "utf8");
                $order_pay_rs = mysqli_query($con, $order_pay_sql);
                $order_fetch  = mysqli_fetch_row($order_pay_rs);
                if (count($order_fetch) != 0) {
                    $pay_id    = $order_fetch[2];
                    if ($pay_id ==  1) {
                        // pay
                        $total_cash = $product_price + $total_cash;
                    }
                }
            } else {
                $order_id =  $arr['order_id'];
                $order_number = "";
                $order_sql = "SELECT  * ,(`order_lists_tbl`.`product_price`) as list_price,(`product_tbl`.`product_price`) as product_price
            FROM  `product_tbl` 
                INNER JOIN `order_lists_tbl` ON `product_tbl`.`product_id` = `order_lists_tbl`.`product_id` 
            where 
                `order_lists_tbl`.`order_id` =  '$order_id' ";
                // echo $order_sql;
                mysqli_set_charset($con, "utf8");
                $product_query = mysqli_query($con, $order_sql);
                if (mysqli_num_rows($product_query)) {
                    while ($product_arr = mysqli_fetch_array($product_query)) {
                        $price1 = "";
                        // echo "price :".$product_arr['product_price'];
                        if ($product_arr['list_price'] != 0) {
                            $price1 = $product_arr['list_price'];
                        } else {
                            $price1 = $product_arr['product_price'];
                        }
        
                        $product_price =  $price1 + $product_price ;
                        $order_lists_id = $product_arr['order_lists_id'];
                        $additons_sql = "SELECT * FROM `order_additions_item_tbl` INNER JOIN `additions_item_tbl` ON `order_additions_item_tbl`.`additions_item_id` = `additions_item_tbl`.`additions_item_id` where `order_lists_id` =  $order_lists_id ";
                        mysqli_set_charset($con, "utf8");
                        $additons_query  = mysqli_query($con, $additons_sql);
                        if (mysqli_num_rows($additons_query) > 0) {
                            while ($add_arr = mysqli_fetch_array($additons_query)) {?>
                        
                            <?php
                            $product_price = $product_price + $add_arr['additions_item_price'];
                            }
                        }
                    }


                    $fess_query = "SELECT `area_cost_delivery` FROM `area_tbl` LIMIT 1 ";
// echo $query."<br/>";
                    mysqli_set_charset($con,"utf8");
                    $fees_result = mysqli_query($con,$fess_query);
                    $fee_row = mysqli_fetch_row($fees_result);
                    $product_price = $product_price + $fee_row[0];
                    echo  $product_price .  " دينار كويتي";
        
                    $order_pay_sql = "SELECT `order_pay_id`, `order_id`, `delivery_id` FROM `order_pay_tbl` WHERE `order_id` =  '$arr[order_id]' ";
                    //echo  $order_pay_sql;
                    mysqli_set_charset($con, "utf8");
                    $order_pay_rs = mysqli_query($con, $order_pay_sql);
                    $order_fetch  = mysqli_fetch_row($order_pay_rs);
                    if (count($order_fetch) != 0) {
                        $pay_id    = $order_fetch[2];
                        if ($pay_id ==  1) {
                            // pay
                            $total_cash = $product_price + $total_cash;
                        }
                    }
                }
            }
        }
        ?>

        </td>
                                           
                                        </tr>
                                        <?php
                        }?>
                              
                                    </tbody>
                                </table>


        <div class="alert alert-success">
        <h4> <b>  الكاش : <?php echo $total_cash .  " دينار كويتي";    ;  ?>  </b></h4>
                            </div>

                                <?php
             }
             ?>
                           

                         
                        </div>
                      
                    </div>
        </div>
                    
             


            <div class="row">
         
                                <?php
                                 
                               $total_cost = 0;
                               if(!empty($branch_id)  && empty($where_query) ){
                                $where_query = " where `order_tbl`.`branch_id` = '$branch_id' and `order_administration_tbl`.`order_administration_cost` != '0.000'";
                            }else  if(!empty($branch_id) && !empty($where_query) ){
                                $where_query =  $where_query . " and `order_tbl`.`branch_id` = '$branch_id' and `order_administration_tbl`.`order_administration_cost` != '0.000'";

                            }
                             if(!empty($startOrder) && empty($endOrder) && empty($where_query) ){
                                $where_query =  " where `order_tbl`.`order_created_at` = '$startOrder'  ";
                             }else if(!empty($startOrder) && empty($endOrder) && !empty($where_query)){
                                $where_query =  $where_query . " and `order_tbl`.`order_created_at` = '$startOrder'  ";

                             }
                            if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
                                $where_query =  " where   `order_tbl`.`order_created_at` = '$endOrder' ";
                            }else if(empty($startOrder) && !empty($endOrder) && !empty($where_query) ){
                                $where_query = $where_query . " and   `order_tbl`.`order_created_at` = '$endOrder' ";
                            }
                            if(!empty($startOrder) && !empty($endOrder) && empty($where_query)){
                                $where_query = " where `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                            } else if(!empty($startOrder) && !empty($endOrder) && !empty($where_query)){
                                $where_query = $where_query  . " and `order_tbl`.`order_created_at` between '$startOrder' and '$endOrder' ";
                            }                                       
                                 mysqli_query($con,"SET NAMES 'utf8'"); 
                                 mysqli_query($con,'SET CHARACTER SET utf8'); 
                                 $order_sql = "SELECT 
                                 sum(
                                     `order_administration_tbl`.`order_administration_cost`
                                 ) as cost ,`administration_tbl`.`administration_name`
                                 FROM 
                                 `order_administration_tbl` 
                                 Inner JOIN `administration_tbl` on `administration_tbl`.`administration_id` = `order_administration_tbl`.`administration_id` 
                                 INNER JOIN `order_tbl` ON `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`   $where_query
                                 GROUP BY `administration_tbl`.`administration_id`  ";
                               
                               
                                $current_order_query 	= mysqli_query($con,$order_sql);
                                if(mysqli_num_rows($current_order_query) > 0){
                              
                                          echo '  <div class="panel panel-primary">
                                          <div class="panel-heading">
                                          عمولات السائقين </div>
                                          <div class="panel-body"><table style="text-align:center" class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example"
                                          aria-describedby="dataTables-example_info">
                                          <thead>
                                              <tr>
                                                
                                                  <th style="text-align:center">اسم السائق </th>
                                                  <th style="text-align:center">اجمالي العمولة اليومية</th>
                                      
                                      
                                              </tr>
                                          </thead>
                                          <tbody>';
                         
                                 
                                  while ($driver_info_arr = mysqli_fetch_array($current_order_query)) {
                                      
                         
                                         echo '<tr>';
                                         echo '<td style="text-align:center">'.$driver_info_arr['administration_name'].'</td>';
                                         // get all cost per day
                                         echo '<td style="text-align:center"> '.$driver_info_arr['cost'].'</td>';
                         
                                         echo '</tr>';
                                     
                                     $total_cost =  $total_cost + $driver_info_arr['cost'];
                                  }
                                  
                                      echo '</tbody>
                                      </table>
                                      <div class="alert alert-success">
                                <h4> <b> الاجمالي : '.$total_cost.' دينار </b></h4>
                                                    </div></div>
                                      </div>';
                                  
                         
                                }
                                






                                ?> 
                           


            </div>
           


            <div class="row">
                            <?php
                                 $expenses_cost = 0;
                                
                              
         $i          = 0 ;
        $cost       = 0;
        $total_cost = 0;
        $where_query = "";
        if(!empty($branch_id) && empty($where_query)){
            $where_query  = " where `branch_id` = '$branch_id' ";
       }else if(!empty($branch_id) && !empty($where_query)) {
          $where_query  = " and `branch_id` = '$branch_id' ";

       }
       if(!empty($startOrder) && empty($endOrder)  && empty($where_query) ){
          $where_query =  " where `expenses_detials_date` =  '$startOrder'  ";
      } else if(!empty($startOrder) && empty($endOrder)  && !empty($where_query) ){
          $where_query =  $where_query . " and `expenses_detials_date` =  '$startOrder'  ";
      }
       if(empty($startOrder) && !empty($endOrder) && empty($where_query) ){
          $where_query =  " where   `expenses_detials_date`  = '$endOrder'  and `branch_id` = '$branch_id' ";
      } else if(empty($startOrder) && !empty($endOrder) && !empty($where_query) ){
          $where_query =  $where_query . " and   `expenses_detials_date`  = '$endOrder'  and `branch_id` = '$branch_id' ";
      }
      if(!empty($startOrder) && !empty($endOrder)){
          $where_query =  " where `expenses_detials_date` between '$startOrder' and '$endOrder'  and `branch_id` = '$branch_id' ";
      }else  if(!empty($startOrder) && !empty($endOrder)){
          $where_query =   $where_query . " and  `expenses_detials_date` between '$startOrder' and '$endOrder'  and `branch_id` = '$branch_id' ";
      }  
        $expenses_sql = "SELECT (SELECT `branch_arabic_name`FROM `branch_tbl` WHERE `branch_id` =  
        `expenses_detials_tbl`.`branch_id`) as branch_arabic_name,`expenses_detials_id`, 
        `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, 
        `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` $where_query  ";
       //echo $expenses_sql;
       mysqli_query($con,"set names 'utf8'");
       $expenses_query = mysqli_query($con,$expenses_sql);

       $table = '<table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline"
            id="dataTables-example" role="grid" aria-describedby="dataTables-example_info"
            style="width: 100%;">
            <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                        colspan="1" aria-label="Browser: activate to sort column ascending">
                        ملاحظات</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                        colspan="1" aria-label="Platform(s): activate to sort column ascending">التكلفة</th>
                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                        colspan="1" aria-label="Platform(s): activate to sort column ascending">التاريخ</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                        colspan="1" aria-label="CSS grade: activate to sort column ascending">الفرع</th>
                </tr>
            </thead>
            <tbody>';

            
           while ($arr = mysqli_fetch_array($expenses_query)) {
              
               $cost = $arr['expenses_detials_cost'] + $cost; 
                         
               $table = $table. '<tr class="gradeA odd" role="row">
                     <td  valign="center">'.$arr['expenses_detials_name'].'</td>
                     <td  valign="center">'.$arr['expenses_detials_cost'].'</td>
                     <td  valign="center">'.$arr['expenses_detials_date'].'</td>
                     <td  valign="center">'.$arr['branch_arabic_name'].'</td>
                     
                     </tr>';
            }
    


           $table =   $table . '</tbody></table>';
           $total = '<div class="alert alert-success"><h4> <b> الاجمالي : '.$cost.' دينار </b></h4></div></div></div>';
          
        
        
                echo '<div class="col-lg-12">
                <div class="panel panel-default"><div class="panel-heading"> المصروفات اليومية</div>
                <div class="panel-body">'.$table ."<br/> الاجمالي :".$total.'</div>';
                                 

                                ?> 
                       </div>



