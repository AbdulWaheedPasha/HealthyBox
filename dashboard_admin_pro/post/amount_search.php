
<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
   // print_r($_POST);
    if(!empty($_POST) ){
        require_once '../Configuration/db.php';
        $startOrder     = $_POST['startOrder'];
        $endOrder       = $_POST['endOrder'];
        $branch_id      = $_POST['branch_id']; 

        $query  = "SELECT  *,`additions_item_ar_name` as  product_title_ar ,`additions_item_id` as product_id  FROM `additions_item_tbl` ";
     
        $where_query = " where  `additions_id` IN (SELECT `additions_id` FROM `additions_tbl` WHERE `additions_haveqty` = 0) ";
       if(isset($branch_id) && !empty($where_query)){
           $where_query = $where_query   . " and `branch_id` = '$branch_id' ";
        }else  if(isset($branch_id) && empty($where_query)){
            $where_query = "where  `branch_id` = '$branch_id' ";

        } 
        if(!empty($startOrder) && empty($endOrder) ){
            $where_query = $where_query  . " and `additions_item_id`  IN (SELECT `product_id` FROM `product_amount_tbl` WHERE `product_amount_date` =  '$startOrder' )";
        }
        if(empty($startOrder) && !empty($endOrder) ){
            $where_query = $where_query  . " and  `additions_item_id` IN (SELECT `product_id` FROM `product_amount_tbl` WHERE `product_amount_date` = '$endOrder' )";
        }
        if(!empty($startOrder) && !empty($endOrder)){
            $where_query = $where_query  . " and `additions_item_id` IN (SELECT `product_id` FROM `product_amount_tbl` WHERE `product_amount_date`  between '$startOrder' and '$endOrder' )";
        } 
        $query_str  =  $query . $where_query; 
        //echo   $query_str ;
        mysqli_set_charset($con,"utf8");
        $rs = mysqli_query($con,$query_str);

        $counter_num = mysqli_num_rows($rs);
        if ($counter_num > 0){
         ?>
   <div class="panel-body">
                                <table class="table table-striped table-bordered table-list">
                                    <thead>
                                        <tr>
                                           
                                               <th> اسم المنتج</th>
                                               <th>الكمية المتوافرة</th>
                                               <th>الكمية المباعة </th>
                                               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                        while ($arr = mysqli_fetch_array($rs)) {
                            // deactive product  
                           // mysqli_query($con,"UPDATE `product_tbl` SET `product_active` = '0' WHERE `product_id` = '$arr[product_id]' ");

                            ?>
                            <?php
                                            // decative any product out of stock from out side 
                                            // current number of  payement 
                                             $sql = "SELECT  IFNULL(sum(`product_amount`),0) 
                                             FROM `product_out_stock_tbl` WHERE 
                                             `product_id` = '$arr[product_id]' ";
                                             // echo  $sql."<br/>";
                                             $product_counter = mysqli_query($con, $sql);
                                              if (false === $product_counter) {
                                                   die("Select sum failed: ".mysqli_error);
                                             }

                                            mysqli_set_charset($con,"utf8");
                                            $row_product = mysqli_fetch_row($product_counter);
                                             
                                            $pay_num = $row_product[0];
                                             // total of product 
                                             $sql = "SELECT  sum(`product_amount_value`) FROM `product_amount_tbl` WHERE `product_id` = '$arr[product_id]' ";
                                             //echo $sql; 
                                             $product_counter = mysqli_query($con,$sql);
                                             if (FALSE === $product_counter) die("Select sum failed: ".mysqli_error);
                                             $row_product = mysqli_fetch_row($product_counter);
                                             $product_num = $row_product[0];
 
                                             $diff = $product_num  - $pay_num;
                                             
                                             ?>
                                        <tr>
                                        

                                            <td>
                                                <?php  
                                                    echo $arr['product_title_ar'];
                                                ?>
                                            
                                            </td>
                                            <td>
                                            <h4><?php  echo $diff; ?></h4>
                                            </td>
                                           
                                      

                                            <td>
                                                <?php  
                                                echo  $pay_num;
                                          ?>
                                            </td>



                                        </tr>
                                        <?php
                        }
                        ?>

                                    </tbody>
                                </table>

                            </div>
 


<?php
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> لا توجد نتيجة للبحث.</b></div>';
        }
       
   

    } else {
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> من فضلك اختار حقول للبحث.</b></div>';
    }
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>