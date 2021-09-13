<?php

require_once '../Configuration/db.php';
if (isset($_POST['view'])) {
    if ($_POST["view"] != '') {
        $update_query = "UPDATE `product_out_stock_tbl` SET `product_out_stock_view`= '1' ";
        mysqli_query($con, $update_query);
    }
}
    $counter = 0 ;
    $sql_all_product = "SELECT * FROM `product_out_stock_tbl` inner JOIN  `additions_item_tbl`
                      on `product_out_stock_tbl`.`product_id` = `additions_item_tbl`.`additions_item_id`  
                      where `product_out_stock_tbl`.`product_out_stock_view` = 0  group by `additions_item_id` ";
                    // echo $sql_all_product ."<br/>";
    $prod_query   = mysqli_query($con, $sql_all_product);
    while ($prod_arr = mysqli_fetch_array($prod_query)) {

      //total amount daily for product
      $sql = "SELECT  IFNULL(sum(`product_amount_value`),0) FROM `product_amount_tbl` WHERE `product_id` = '$prod_arr[product_id]'  ";
      //echo $sql."<br/>";
      $product_counter = mysqli_query($con, $sql);
      $row_product = mysqli_fetch_row($product_counter);
      $total = $row_product[0];
   

      if( $total  > 0){
          //product was paid
          $sql = "SELECT  IFNULL(sum(`product_amount`),0) FROM `product_out_stock_tbl` WHERE `product_id` = '$prod_arr[product_id]' ";
         //echo $sql."<br/>";
          $product_counter = mysqli_query($con, $sql);
          $row_product     = mysqli_fetch_row($product_counter);
          $pay_num         = $row_product[0];
          if (($total - $pay_num) < 5 || ($total - $pay_num) == 5) {
              $counter++;
          }
      }
    }
  
    if($counter <= 9){
      $data = array('notification' => $counter);
    }else if($counter > 9){
      $data = array('notification' => "9+");
    }else{
      $data = array('notification' => "0");
    }
     echo json_encode($data);
  

  

   
     
               
 ?>
