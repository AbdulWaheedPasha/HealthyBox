<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$mesg_error = " ";

// print_r($_POST)."<br/>";
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once '../Configuration/db.php';
   // require_once '../Configuration/db.php';
    $user_id = "";
    $noProduct = "0";
    $noPrice   = "0";
    for ($i=0;$i<$_POST['Amount'];$i++) {
       
        if(isset($_POST["category_checkbox".$i]) || !empty($_POST["category_checkbox".$i]) ){
            $noProduct = "1";
        }
        if(!empty($_POST["price_".$i])){
            $noPrice  =  "1";
        }
    }
 
    if( empty($_POST['DateOrder'])   && empty($_POST['payment_status'])
     && empty($_POST['order_from']) && empty($_POST['msg_txtBox'])  
     && empty($_POST['order_time']) && ($noPrice == "0") && ($noProduct == "1") ){
        echo json_encode(array('success' => 2,'message' => '<h2>من فضلك املا الحقول الفارغة</h2>'));
                       
    }else if(!empty($_POST['DateOrder'])  && !empty($_POST['payment_status']) 
    && !empty($_POST['order_from']) && !empty($_POST['order_time']) && !empty($_POST['msg_txtBox']) 
     && !empty($_POST['payment_status']) && $noProduct && $noPrice ) {
        // check if date greater than or equal date
        if(!empty($_POST['DateOrder'])){
            $curdate = date("Y-m-d");
            $mydate  = $_POST['DateOrder'];

            // echo  $curdate."<br/>";
            // echo  $mydate."<br/>";
            
       

          if($curdate == $mydate){    // compare current date with post date
             date_default_timezone_set("Asia/Kuwait");
             $date = date("h:i:sa");
            //  echo $date;
                for ($i=0;$i<$_POST['Amount'];$i++) {
                    $category_name = "category_checkbox".$i;
                    // echo $category_name;
                    // get if have qty or no 
                    $parent_id     = $_POST[$category_name];
                    $qty_row   = 1;


                   
                     $order_time1 = explode("-",$_POST[order_time]);
                     // in-stock
                     $sql = "SELECT  IFNULL(sum(`product_amount_value`),0) FROM `product_amount_tbl` 
                     WHERE `product_id` = '$parent_id' and `product_amount_date` = CURDATE() and 
                     `product_amount_time` <=  '$order_time1[0]' ";
                     // echo  $sql."<br/>";
                     $product_counter = mysqli_query($con, $sql);
                     if (false === $product_counter) {
                         die("Select sum failed: ".mysqli_error);
                     }
                     mysqli_set_charset($con,"utf8");
                     $row_product = mysqli_fetch_row($product_counter);
                     $total = $row_product[0];
                     //echo  $total;
                      // get product name 
                    $sql = "SELECT  `additions_item_ar_name`,`additions_item_qty` FROM `additions_item_tbl` WHERE  `additions_item_id`=  '$parent_id ' ";
                    //echo $sql;
                    mysqli_set_charset($con,"utf8");
                    $product_query = mysqli_query($con,$sql);
                    $row_product  = mysqli_fetch_row($product_query);
                    $product_name = $row_product[0]; 
                    $product_qty  = $row_product[1];
                  
                    if($total == 0){
                        $all_products_bool =  false;
                        $mesg_error = $mesg_error."$num - <b> المنتج  : <b> ". $product_name ." </b> الكمية الموجودة في المخزن لا تكفي <b><h5>$total</h5></b><br/>";
                    }else if($total > 0){
                        $all_products_bool =  false;
                         // out-of- stock
                    $sql = "SELECT  IFNULL(sum(`product_amount`),0) FROM `product_out_stock_tbl` WHERE `product_id` = '$parent_id' and `product_out_stock_date` = CURDATE()  ";
                   // echo  $sql."<br/>";
                    $product_counter = mysqli_query($con, $sql);
                    if (false === $product_counter) {
                        die("Select sum failed: ".mysqli_error);
                    }
                    $row_product = mysqli_fetch_row($product_counter);
                    $outOfStock = $row_product[0];
                   

                    $diff =  $total - $outOfStock ;

                   // echo $diff;
                    if($diff < 0 || $diff == 0 ){
                        if($diff <  $product_qty ){
                            $all_products_bool =  false;
                            $diff =  $total - $outOfStock;
                            $mesg_error = $mesg_error."$num - <b> المنتج  : <b> ". $product_name ." </b> الكمية الموجودة في المخرن لا تكيف - الكمية : $diff </b><br/>";
                        }else{
                            $all_products_bool = true;
                        }
                       
                    }else{
                        $all_products_bool = true;
                    }

                    }
               
              }

              if(!$all_products_bool){
                  $insert_pointer = "Product_num";
                }else{
                    $insert_pointer = "YouCan";
                }

              
                    
            }else{
                $insert_pointer = "YouCan";
            }
            switch ($insert_pointer) {
             
                case "YouCan":{
                    // insert order
                   // echo "check for user information "."<br/>";
                          // check for user information 
                        if(!empty($_POST['msg_txtBox'])){
                              // insert new user
                              mysqli_set_charset($con, "utf8");
                              $query = "INSERT INTO `administration_tbl` VALUES (NULL, '', '', '', '','','','',  '5', '1', '0');";
                               //echo $query;
                              $rs = mysqli_query($con, $query);
                              $user_id = mysqli_insert_id($con);
                             // echo $user_id;
                            
                          
                              
                                    
                            

                            //get branch id
                            $branch_array = Array();
                            for ($i=0;$i<$_POST['Amount'];$i++) {
                                $product_name = "category_checkbox".$i;
                                $parent_id    = $_POST[$product_name];
                               
                                // print_r($quantity_row);
                                $quantity_num    = 1;
                        
                                 
                          
                                
                                $query = "SELECT `branch_id` FROM `additions_item_tbl`  WHERE `additions_item_id` = $parent_id ";
                                //  echo $query."<br/>";;
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_row($result);
                                $branch_id  = $row[0];
                                $branch_array[$i] = $branch_id;
                                //echo $branch_array[$i]."<br/>";
                            }
                            if (count(array_unique($branch_array)) === 1 || end($branch_array) === 'true') {
                                $branch_id = $branch_array[0];
                        
                        
                        
                            } else {
                                $branch_id = "2";
                            }

                              //get last id 
                            $result = mysqli_query($con, "SELECT * FROM `order_tbl` ORDER BY `order_id` DESC LIMIT 1");
                            $row    = mysqli_fetch_array($result);
                        
             

                            $order_status_id    = 1;
                            $order_created_at   = $_POST['DateOrder'];
                            $order_time         = $_POST['order_time'];
                            $payment_status_id  = $_POST['payment_status'];
                            $order_from_id      = $_POST['order_from'];

       //get last id 
                                      $result = mysqli_query($con, "SELECT `order_number` FROM `order_tbl` where  DATE(`order_created_at`) = CURDATE() ORDER BY `order_id`  DESC LIMIT 1");
                                      $row    = mysqli_fetch_array($result);
                               
                                               
        
                                   
                                    if(count($row) > 1){
                                        $id_max = $row['order_number']+1; 
                                    }else{
                                     
                                        $id_max = 1;
                                    }
                           
                            mysqli_set_charset($con,"utf8");
                            $order_query = "INSERT INTO `order_tbl`(`order_id`, `order_number`, `order_status_id`  , `order_created_at`  , `branch_id` ,  `order_time`  , `payment_status_id`  , `order_from_id`, `order_driver_notes`,`order_kitchan_notes`, `order_card_notes`,`order_view`) 
                                            VALUES (NULL,       '$id_max',      '$order_status_id' , '$order_created_at' , '$branch_id' , '$order_time' , '$payment_status_id' , '$order_from_id','','','$_POST[order_card_notes]','0')";
                            
                            //echo $order_query."<br/>";
                            $rs = mysqli_query($con, $order_query);

                             //get max Order id
                             $order_id           = mysqli_insert_id($con);



                             for ($i=0;$i<$_POST['Amount'];$i++) {
                                 $product_name = "category_checkbox".$i;
                                 $parent_id    = $_POST[$product_name];

                                 $sql = "SELECT  `additions_item_ar_name`,`additions_item_qty` FROM `additions_item_tbl` WHERE  `additions_item_id`=  '$parent_id ' ";
                                 //echo $sql;
                                 mysqli_set_charset($con,"utf8");
                                 $product_query = mysqli_query($con,$sql);
                                 $row_product  = mysqli_fetch_row($product_query);
                                
                               
                                 // print_r($quantity_row);
                                 $quantity_num    = $row_product[1];


                                 $query = "INSERT INTO `product_out_stock_tbl` VALUES ('NULL','$parent_id','$quantity_num','$_POST[DateOrder]','0','$order_id')";
                                 //$query."<br/>";
                                 $result = mysqli_query($con, $query);
                             }




                             // set msg for table message 
                             //$_POST[msg_txtBox]

                             $order_msg_sql = "INSERT INTO `order_msg_tbl` (`order_msg_content`, `order_id`) VALUES ('$_POST[msg_txtBox]','$order_id')";
                             $order_msg_rs  = mysqli_query($con, $order_msg_sql);


                              //     mysqli_set_charset($con,"utf8");
                             // echo $_SESSION['user_id'];
                              $order_user_query = "INSERT INTO `order_user_tbl` (`order_id`, `user_id`) 
                              VALUES ('$order_id', '$_SESSION[user_id]')";
                             // echo $order_user_query."<br/>";
                              $order_user_rs = mysqli_query($con, $order_user_query);




                             $order_status_id    = 1;

                          
                            // echo " user insert "."<br/>";
                            mysqli_set_charset($con,"utf8");
                            $order_adminstratoir_query = "INSERT INTO `order_administration_tbl`(`order_administration_id`, `order_id`, `administration_id`, `order_administration_cost`) 
                            VALUES (NULL,'$order_id','$user_id','0.000')";
                            $rs = mysqli_query($con,$order_adminstratoir_query);


                            for ($i=0;$i<$_POST['Amount'];$i++) {
                                $product_name = "category_checkbox".$i;
                                $price = $_POST['price_'.$i];
                                $cat_value = $_POST[$product_name];
                                mysqli_set_charset($con,"utf8");
                                $product_order_query = "INSERT INTO `order_lists_tbl`  VALUES (NULL,'1','$order_id','$cat_value','$price','','')";
                                $product_order_rs    = mysqli_query($con,$product_order_query);
                                $rs = mysqli_query($con,$product_order_rs);
                            }echo json_encode(array('success' => 1,'message' => '<h1> تمت اضافة الطلب بنجاح رقم الطلب هو : <b>'.$id_max.'</b></h1>'));
                                             
                            
            
                        }else{
                            echo json_encode(array('success' => 2,'message' => '<b>يرجى ملء رقم الهاتف.</b>'));

                        
                        }
                }
                    break;
                case "You_Cannot":
                    // echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    // <b>The number of products in the inventory is not enough for your order.</b></div>';
                    break;

                 case "Product_num":
                    echo json_encode(array('success' => 2,'message' => '<b>عدد المنتجات في المخزون لا يكفي لطلبك :</b><br/>'.$mesg_error.''));
                   
                    break;
                    
                default:
                echo json_encode(array('success' => 2,'message' => 'Error'));

            }

            

           
            
         
        
          




    






        }else{
            echo json_encode(array('success' => 2,'message' =>'<b> يرجى تحديد تاريخ الطلب</b>'));
        }
    }else {
        echo json_encode(array('success' => 2,'message' => '<h2>من فضلك املا الحقول الفارغة</h2>'));
      
     }
       
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
 
}



?>