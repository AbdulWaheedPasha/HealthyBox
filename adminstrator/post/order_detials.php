<?php
// session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password']) ) {
    require_once '../Configuration/db.php';
    $product_price = 0;
    $order_detials_sql = "Select 
	*, 
	(
		SELECT 
			`administration_tbl`.`administration_telephone_number` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '4' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Driver_Tele, 
	(
		SELECT 
			`administration_tbl`.`administration_name` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '4' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Driver_name, 
	(
		SELECT 
          `order_administration_tbl`.`order_administration_cost`
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '4' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Driver_Cost, 
	(
		SELECT 
			`administration_tbl`.`administration_telephone_number` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '5' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Tele, 
	(
		SELECT 
			`administration_tbl`.`administration_telephone_number1` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '5' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Tele1,
	(
		SELECT 
			`administration_tbl`.`administration_name` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '5' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Name, 
	(
		SELECT 
			`administration_tbl`.`administration_address` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '5' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Address , 
	(
		SELECT 
			`administration_tbl`.`administration_addres1` 
		FROM 
			`order_administration_tbl` 
			INNER JOIN `administration_tbl` ON `order_administration_tbl`.`administration_id` = `administration_tbl`.`administration_id` 
		where 
			`administration_tbl`.`administration_type_id` = '5' 
			and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
	) as Address1 
FROM 
	`order_tbl` 
	INNER JOIN `order_lists_tbl` ON `order_lists_tbl`.`order_id` = `order_tbl`.`order_id` 
where 
	`order_tbl`.`order_id` = '$arr[order_id]' GROUP BY `order_tbl`.`order_id`";
   
echo  $order_detials_sql;
  $order_detials_query  = mysqli_query($con,$order_detials_sql);
  if (mysqli_num_rows($order_detials_query) > 0) {
    while ($order_detials_arr = mysqli_fetch_array($order_detials_query)) {
        ?>
        <input type="hidden" value="<?php echo $arr['order_id']; ?>" id="order_id_txt" name="order_id_txt" />
        <div class="panel panel-primary">
            <div class="panel-heading">الطلب</div>
            <div class="panel-body">
            <table class="table table-striped">
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">رقم الطلب :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_arr['order_number']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right"><label for="exampleFormControlSelect2"> اسم الزبون :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_arr['Name']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right"><label for="exampleFormControlSelect2"> رقم التليفون :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_arr['Tele']; ?> 
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right"><label for="exampleFormControlSelect2"> العنوان :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_arr['Address']; ?> 
                    </td>
                </tr>
                <tr>
                <td style="text-align:right"><label for="exampleFormControlSelect2"> ملاحظات سواق :</label></td>

                    <td style="text-align:right">
                        <?php echo $order_detials_arr['order_driver_notes']; ?> 
                    </td>
                </tr>
                <tr>
                <td style="text-align:right"><label for="exampleFormControlSelect2"> ملاحظات مطبخ :</label></td>

                    <td style="text-align:right">
                        <?php echo $order_detials_arr['order_kitchan_notes']; ?> 
                    </td>
                </tr>
                <tr>
                <td style="text-align:right"><label for="exampleFormControlSelect2">  الكارت :</label></td>

                    <td style="text-align:right">
                        <?php echo $order_detials_arr['order_card_notes']; ?> 
                    </td>
                </tr>
            </table>
            </div>
                        
        </div>


        <div class="panel panel-primary">
            <div class="panel-heading">بيانات السائق</div>
            <div class="panel-body">
            <?php
               if(!empty($order_detials_arr['Driver_name'])){
            ?>
                <table class="table table-striped">
                    <tr>
                        <td style="text-align:right"><label for="exampleFormControlSelect2">السائق : </label></td>
                        <td style="text-align:right">
                            <?php echo $order_detials_arr['Driver_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right"><label for="exampleFormControlSelect2"> تليفون السائق :</label></td>
                        <td style="text-align:right">
                            <?php echo $order_detials_arr['Driver_Tele']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right"><label for="exampleFormControlSelect2">التكلفة :</label></td>
                        <td style="text-align:right">
                            <?php
                        echo "<b>".$order_detials_arr['Driver_Cost'] . "  دينار كويتي </b>";
                         ?>
                        </td>
                    </tr>

                </table>
                <?php
               }else{
                   echo "<h3>لم يتم تحديد السائق بعد</h3>";
               }

               ?>
            </div>
                        
        </div>

        <?php
         //get order detials
         $order_detials_query  = "SELECT * FROM `order_tbl` inner JOIN `branch_tbl` 
         on `order_tbl`.`branch_id` = `branch_tbl`.`branch_id`
         inner JOIN `order_status_tbl` on `order_tbl`.`order_status_id` =  `order_status_tbl`.`order_status_id`
         inner JOIN `payment_status_tbl` on `order_tbl`.`payment_status_id` =  `payment_status_tbl`.`payment_status_id`
          where `order_tbl`.`order_id`  = '$arr[order_id]' ";      
             $order_detials_result = mysqli_query($con, $order_detials_query);
         $order_detials_row    = mysqli_fetch_row($order_detials_result);
        ?>
         <div class="panel panel-primary">
            <div class="panel-heading">بيانات الفرع</div>
            <div class="panel-body">
            <table class="table table-striped">
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">الفرع :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_row[11]; ?>
                    </td>
                </tr>
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">تاريخ الطلب :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_row[2]; ?>
                    </td>
                </tr>
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">حالة الطلب :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_row[15]; ?>
                    </td>
                </tr>
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">وقت التسليم  :</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_row[6]; ?>
                    </td>
                </tr>
                <tr class="table-active">
                    <td style="text-align:right"><label for="exampleFormControlSelect2">الدفع:</label></td>
                    <td style="text-align:right">
                        <?php echo $order_detials_row[19]; ?>
                    </td>
                </tr>
            </table>
            </div>
                        
        </div>


        <div class="panel panel-primary">
            <div class="panel-heading">المنتجات</div>
            <div class="panel-body">
            <?php
         
         $product_sql   = "SELECT  *, `additions_item_ar_name` as  product_title_ar ,(`order_lists_tbl`.`product_price`) as list_price, (`additions_item_tbl`.`additions_item_price`) as product_price 
                           FROM  `additions_item_tbl` 
                            INNER JOIN `order_lists_tbl` ON `additions_item_tbl`.`additions_item_id` = `order_lists_tbl`.`product_id`  where 
                            `order_lists_tbl`.`order_id` =  '$order_detials_arr[order_id]' ";
        // echo $product_sql;
         $product_query = mysqli_query($con,$product_sql);
         if (mysqli_num_rows($product_query)) {
             while ($product_arr = mysqli_fetch_array($product_query)) {
 ?>


          <div class="table-responsive" style="text-align:right">
              <table class="table table-striped" style="text-align:right">
                  <thead>
                      <tr><td><h4><b><?php echo $product_arr['product_title_ar']; ?></b></h4></td>
                          <td>
                                  <?php 
                                      $price1 = "";
                                     // echo "price :".$product_arr['product_price'];
                                      if($product_arr['list_price'] != 0){
                                          $price1 = $product_arr['list_price'];
                                      }else{
                                          $price1 = $product_arr['product_price'];
                                      }

                                      $product_price =  $price1 + $product_price ;
                                      echo $price1; ?>
                                  دينار كويتي</td>



                      </tr>
              <?php 
               $order_lists_id = $product_arr['order_lists_id'];
               $additons_sql = "SELECT * FROM `order_additions_item_tbl` INNER JOIN `additions_item_tbl` ON `order_additions_item_tbl`.`additions_item_id` = `additions_item_tbl`.`additions_item_id` where `order_lists_id` =  $order_lists_id ";
               mysqli_set_charset($con, "utf8");
               $additons_query  = mysqli_query($con,$additons_sql);
               if(mysqli_num_rows($additons_query) > 0){ 
                   while ($add_arr = mysqli_fetch_array($additons_query)) {?>
                      <tr>
                          <td><?php echo $add_arr['additions_item_ar_name']; ?></td>
                          <td><b><?php echo $add_arr['additions_item_price'];?>دينار كويتي</b></td>
                      </tr>
                      <?php
                      $product_price = $product_price + $add_arr['additions_item_price'];
                      }
                  }

              ?>
                  </thead>
                
              </table>


          </div>

          <?php
             }

             ?>
            </div>
                        
        </div>
       
      
        <p class="text-primary"> <h3> السعر :<?php echo $product_price; ?> دينار كويتي</h3></p>



            <?php
           }
           ?>

<?php
    } 
  }
}

?>
