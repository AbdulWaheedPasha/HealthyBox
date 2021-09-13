<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $telephone_sql = "";
    $where_sql     = "";
    $price = "";
    $search_order_sql = "SELECT *, sum(
        `order_administration_tbl`.`order_administration_cost`
    ) as cost ,`administration_tbl`.`administration_name`  FROM `order_administration_tbl` Inner JOIN `administration_tbl` 
    on `administration_tbl`.`administration_id` = `order_administration_tbl`.`administration_id` 
    INNER JOIN `order_tbl` ON `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`
    where  `administration_tbl`.`administration_type_id` = 4  ";

    if (!empty($_POST['Telephone'])) {
        $where_sql = $where_sql ." and `administration_tbl`.`administration_telephone_number` = '".$_POST['Telephone']."' ";
    }
    if (!empty($_POST['driver_id'])) {
        if($_POST['driver_id'] != 0){
           $where_sql = $where_sql ." and `administration_tbl`.`administration_id` = '".$_POST['driver_id']."' ";
        }
    }
    
    //endOrder
    if(!empty($_POST['startOrder']) && empty($_POST['endOrder'])){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` = '".$_POST['startOrder']."' ";
    }
    if(empty($_POST['startOrder']) && !empty($_POST['endOrder'])){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` = '".$_POST['endOrder']."' ";
    }  
    if(!empty($_POST['startOrder']) && !empty($_POST['endOrder'])){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` between '".$_POST['startOrder']."' and '".$_POST['endOrder']."' ";
    }
    if(!empty($_POST['orderNum'])){
        $where_sql = $where_sql . " and  `order_tbl`.`order_number` = '".$_POST['orderNum']."' ";
    }


    
    $search_order_sql =  $search_order_sql . $where_sql ." GROUP BY `administration_tbl`.`administration_id`  ";
     //echo $search_order_sql ;
        require_once '../Configuration/db.php';
     

        mysqli_set_charset($con,"utf8");



       // echo  $search_order_sql;
        $order_query 	= mysqli_query($con,$search_order_sql);
      //  echo mysqli_num_rows($order_query);
        if(mysqli_num_rows($order_query) > 0){  

        ?>
<div id="order_div"></div>
<table style="text-align:center" class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example"
    aria-describedby="dataTables-example_info">
    <thead>
        <tr>
          
        <th style="text-align:center">اسم السائق </th>
            <th style="text-align:center">اجمالي العمولة اليومية</th>

        </tr>
    </thead>
    <tbody>
        <?php
            while ($arr = mysqli_fetch_array($order_query)) {
        ?>
         <?php
                echo '<tr>';
                echo '<td style="text-align:center">'.$arr['administration_name'].'</td>';
                // get all cost per day
                echo '<td style="text-align:center"> '.$arr['cost'].'</td>';

                echo '</tr>';
        
        ?>
       
        <?php
                         }
                         ?>











     

    </tbody>
</table>
<?php

} else{
    ?>
<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       لا توجد نتيجة للبحث .
                            </div>
    <?php
}
    
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}

?>
