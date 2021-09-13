<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $telephone_sql = "";
    $where_sql     = "";
    if (!empty($_POST['Telephone'])) {
        $telephone_sql = " and `administration_tbl`.`administration_telephone_number` = '".$_POST['Telephone']."' ";
    }
    //endOrder
    if((!empty($_POST['startOrder']) && empty($_POST['endOrder'])) &&  empty($where_sql)){
        $where_sql = " where `order_tbl`.`order_created_at` = '".$_POST['startOrder']."' ";
    }else  if((!empty($_POST['startOrder']) && empty($_POST['endOrder'])) && !empty($where_sql)){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` = '".$_POST['startOrder']."' ";
    }

    if((empty($_POST['startOrder']) && !empty($_POST['endOrder'])) && empty($where_sql)){
        $where_sql = " where `order_tbl`.`order_created_at` = '".$_POST['endOrder']."' ";
    }else  if((empty($_POST['startOrder']) && !empty($_POST['endOrder'])) && !empty($where_sql)){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` = '".$_POST['endOrder']."' ";
    }


    if((!empty($_POST['startOrder']) && !empty($_POST['endOrder'])) && empty($where_sql)){
        $where_sql = " where   `order_tbl`.`order_created_at` between '".$_POST['startOrder']."' and '".$_POST['endOrder']."' ";
    }else  if((!empty($_POST['startOrder']) && !empty($_POST['endOrder'])) && !empty($where_sql)){
        $where_sql = $where_sql . " and `order_tbl`.`order_created_at` between '".$_POST['startOrder']."' and '".$_POST['endOrder']."' ";
    }


    if($_POST['order_status_id'] != 0){
        if(isset($_POST['order_status_id']) && empty($where_sql)){
            $where_sql = " where `order_tbl`.`order_status_id` = ".$_POST['order_status_id'];
        }else if(isset($_POST['order_status_id']) && !empty($where_sql)){
            $where_sql = $where_sql . " and `order_tbl`.`order_status_id` = '".$_POST['order_status_id']."' ";
        }
    }
    ///echo  $where_sql;
        require_once '../Configuration/db.php';
     

        mysqli_set_charset($con,"utf8");

        $search_order_sql = "Select *,(SELECT `administration_tbl`.`administration_telephone_number`
                      FROM  `order_administration_tbl` 
                      INNER JOIN `administration_tbl` ON
                     `order_administration_tbl`.`administration_id` =  `administration_tbl`.`administration_id`
                      where  `administration_tbl`.`administration_type_id` = '5'  
                      $telephone_sql and `order_administration_tbl`.`order_id` = `order_tbl`.`order_id`) as Tele FROM `order_tbl`
                      INNER JOIN  `order_lists_tbl`  ON  
                      `order_lists_tbl`.`order_id`  = `order_tbl`.`order_id` " .$where_sql. "  
                       group by `order_lists_tbl`.`order_id` order by `order_lists_tbl`.`order_id`   DESC ";

      //  echo  $search_order_sql;
        $order_query 	= mysqli_query($con,$search_order_sql);
        if(mysqli_num_rows($order_query) > 0){  

        ?>
<div id="order_div"></div>
<table style="text-align:center" class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example"
    aria-describedby="dataTables-example_info">
    <thead>
        <tr>
            <th style="text-align:center"> تغيير حالة الطلب</th>
            <th style="text-align:center">رقم الطلب</th>

            <th style="text-align:center">خصائص آخري</th>

        </tr>
    </thead>
    <tbody>
        <?php
                        while ($arr = mysqli_fetch_array($order_query)) {

                            $order_administration_sql = "SELECT * FROM `order_administration_tbl` WHERE `order_id` =  '$arr[order_id]' and `order_administration_cost` <> '0.000'";
                            // echo  $order_administration_sql;
                             $order_administration_rs = mysqli_query($con, $order_administration_sql);
                             $order_administration_arr = mysqli_fetch_row($order_administration_rs);
                             //echo count($order_administration_arr);
                        
                               
                             $order_administration_sql = "SELECT * FROM `order_administration_tbl` WHERE `order_id` =  '$arr[order_id]' and `order_administration_cost` <> '0.000'";
                             // echo  $order_administration_sql;
                              $order_administration_rs = mysqli_query($con, $order_administration_sql);
                              $order_administration_arr = mysqli_fetch_row($order_administration_rs);
                              //echo count($order_administration_arr);
                         
                              $color = "";
                              if($arr['order_status_id'] == 1){
                                  $color = 'style="background:#FFF"';
                              }else if($arr['order_status_id'] == 6 ){
                                  $color = 'style="background:#fcf8e3"';
                              }else if(count($order_administration_arr) > 0 && $arr['order_status_id'] != 5 ){
                                  $color = 'style="background:#dff0d8"';
  
                              }else if($arr['order_status_id'] == 4 &&  count($order_administration_arr) == 0){
                                  $color = 'style="background:#A5A5A5"';
                                  
                              }else if($arr['order_status_id'] == 5 ){
                                  $color = 'style="background:#f1a7a5"';
                              }

                            ?>
        <tr <?php echo $color; ?>>
            <td>
                <div class="form-group">


                    <input type="radio" name="order_status_<?php echo $arr['order_id']; ?>" value="4"> جاري التوصيل
                    <input type="radio" name="order_status_<?php echo $arr['order_id']; ?>" value="5"> الغاء الطلب
                    <input type="radio" name="order_status_<?php echo $arr['order_id']; ?>" value="6"> تم التسليم
                    <input id="buttoncheck_<?php echo $arr['order_id']; ?>" type="button" name="btn" value="تغيير"
                        class="btn btn btn-success"></input>

                    <script type="text/javascript">
                        $(function () {
                            $('#buttoncheck_<?php echo $arr['
                                order_id ']; ?>').click(function () {
                                var var_name = $(
                                    "input[name='order_status_<?php echo $arr['order_id']; ?>']:checked"
                                ).val();
                                // $('#btn_get').val(var_name);
                                //alert(var_name);
                                var myKeyVals = {
                                    "order_id": <?php echo $arr['order_id']; ?>,
                                    "value": var_name
                                }

                                var postData = $(this).serializeArray();
                                $.ajax({
                                    url: "./post/order_status.php",
                                    type: "POST",
                                    data: myKeyVals,
                                    success: function (data, textStatus, jqXHR) {
                                        // alert(data);
                                        $('#order_div').html(data);
                                        // $("#Result_Div").remove();
                                        //setTimeout(function() { location.reload(); }, 1000);
                                    },
                                    error: function (jqXHR, status, error) {
                                        console.log(status + ": " + error);
                                    }
                                });
                                e.preventDefault();
                            });
                        });

                    </script>



                </div>
            </td>
            <td>
                <?php echo $arr['order_number'];?>
            </td>



            <td>
                <div class="panel-body">
                    <!-- View Modal -->
                    <a target="_blank" href="./report_page/index.php?order_id=<?php echo base64_encode($arr['order_id']); ?>"
                        class="btn btn btn-success">طباعة<i class="fa fa-print"></i></a>
                  

                    <!-- /.View Modal -->

                    <!-- View Product Detials  -->
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#view_Modal_<?php echo $arr['order_id']; ?>">تفاصيل
                        الطلب<i class="fa fa-info-circle"></i></a>
                    </a>
                    <!-- Modal -->
                    <div class="modal fade printable" id="view_Modal_<?php echo $arr['order_id']; ?>" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-body">
                                    <?php require('./order_detials.php'); ?>
                                </div>
                                <div class="d-none">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.View Product Detials -->
                  
                    <!-- /.View Modal -->

                    
    
 <a class="btn btn-info" class="btn btn-primary" data-toggle="modal" data-target="#assign_driver_Modal_<?php echo $arr['order_id']; ?>">تحديد السائق<i class="fa fa-car"></i></a>

<!-- Assign Driver Modal -->
<div class="modal fade printable" id="assign_driver_Modal_<?php echo $arr['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اختر السائق</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
      <form action="./post/insert_driver_order.php" method="post" enctype="multipart/form-data" 
      name="form" id="form_<?php echo $arr['order_id']; ?>">
<div id="Result_Div_<?php echo $arr['order_id']; ?>"></div>
    <div class="modal-body">
        <input class="form-control" type="hidden" name="order_id" value="<?php echo $arr['order_id']; ?>">
        <?php
            $order_administration_sql = "SELECT * FROM `order_administration_tbl` WHERE `order_id` =  '$arr[order_id]' and `order_administration_cost` <> '0.000'";
            $order_administration_rs = mysqli_query($con, $order_administration_sql);
            $order_administration_arr = mysqli_fetch_row($order_administration_rs);
        ?>
        <div class="form-group">
            <label>تكلفة السائق : </label>
            <?php
            echo '<div class="row"  >';
        mysqli_set_charset($con, "utf8");
        $user_mysqli_query = mysqli_query($con, "SELECT `driver_cost_id`, `driver_cost_list` FROM `driver_cost_tbl` ");
        while ($arr1 = mysqli_fetch_array($user_mysqli_query)) {
           if($order_administration_arr[3] == $arr1['driver_cost_list']){
            echo '<div class="col-xs-2"> <label class="checkBox">
            <div class="myButton">'.$arr1['driver_cost_list'].'<input type="radio" value="'.$arr1['driver_cost_list'].'" name="Driver_Cost" checked="checked"
/>  <span class="checkmark"></span>
            </div>
         </label></div>';           }
        }
        $user_mysqli_query = mysqli_query($con, "SELECT `driver_cost_id`, `driver_cost_list` FROM `driver_cost_tbl` ");

        while ($arr1 = mysqli_fetch_array($user_mysqli_query)) {
            if($order_administration_arr[3] != $arr1['driver_cost_list']){
                echo '<div class="col-xs-2"> <label class="checkBox">
                <div class="myButton">'.$arr1['driver_cost_list'].'<input type="radio" value="'.$arr1['driver_cost_list'].'" name="Driver_Cost" />  <span class="checkmark"></span>
                </div>
             </label></div>';
            }
         }

        ?>    
        
    </div>
        <div class="form-group">
            <label>اسم السائق : </label>
            <div class="row show-grid">
                <?php
                $value_active = "";
        mysqli_set_charset($con, "utf8");
        $user_mysqli_query = mysqli_query($con, "SELECT *,(SELECT `administration_type_name` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type  FROM `administration_tbl` as admin where `administration_type_id` = 4 ");
        while ($arr2 = mysqli_fetch_array($user_mysqli_query)) {
            if($order_administration_arr[2] == $arr2['administration_id']){
                $value_active = "checked";

            }else{
                $value_active = "";
            }
            echo '<div class="col-md-4"><div class="myButton" >
            <label>
            <input name="Driver_selection" type="radio"  '.$value_active.'
            value="'.$arr2['administration_id'].'" >'.$arr2['administration_name'].'</label>
            </div></div>';
        }
        ?>
            </div>
        </div>
    </div>
</form>


      </div>
      <div class="d-none">
      <div class="modal-footer">
        <button type="button" id ="submitForm_<?php echo $arr['order_id']; ?>" class="btn btn-default">حفظ</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>

        <script>
        $(document).ready(function () {
            $("#form_<?php echo $arr['order_id']; ?>").on("submit", function(e) {
                var postData = $(this).serializeArray();
                var formURL = $(this).attr("action");
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function(data, textStatus, jqXHR) {
                        // alert(data);
                        $('#Result_Div_<?php echo $arr['order_id']; ?>').html(data);
                        // $("#Result_Div").remove();
                        setTimeout(function() { location.reload(); }, 1000);
                    },
                    error: function(jqXHR, status, error) {
                        console.log(status + ": " + error);
                    }
                });
                e.preventDefault();
            });
            $("#submitForm_<?php echo $arr['order_id']; ?>").on('click', function() {
                $("#form_<?php echo $arr['order_id']; ?>").submit();
            });

        });
        </script>
    </div>
      </div>
    </div>
  </div>
</div>
<!-- /.update Driver Modal -->
  




                </div>


            </td>
        </tr>

        <?php
                         }
                         ?>











        <?php
                        }?>

    </tbody>
</table>

<?php

    
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}

?>
