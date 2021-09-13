<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
// print_r($_POST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once '../Configuration/db.php';

    echo '<hr/> 
    <div class="panel panel-default panel-table">
    <div class="panel-heading">
        <h5><i class="fa fa-plus-square" aria-hidden="true"></i>اضافة اوقات العمل</h5>
    </div>
    <div class="panel-body">
        <form action="./post/add_slot_time.php" method="post" enctype="multipart/form-data" name="form" id="form" >
            <div class="form-group" id="Result"></div>
            <div class="form-group">
                <label> من :</label>        
                <input type="time"   id="from" name="from" />
            </div>
            <div class="form-group">
                <label> الي :</label>        
                <input type="time"   id="to" name="to" />
            </div>
        </form>   
        <div class="form-group">
            <button type="button" id="submitForm" class="btn btn-default" style="float:left">اضافة</button>
        </div>
    </div>
    </div>
    <hr/>';

?>
 <script>


/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#form").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
                alert(data);
                // $('#Result').html(data);
                // $("#submitForm").remove();

                // setTimeout(function() {
                //     location.reload();
                // }, 1000);
                // $("#submitForm").remove();
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    $("#submitForm").on('click', function() {
        $("#form").submit();
    });
});
</script>
<?php


$delivery_time = "";
// get Product Detials
$product_query = "SELECT `day_time_id`, `day_time_hours_from`, `day_time_hours_to`, `day_id` FROM `day_time_tbl` WHERE `day_id` = '$_GET[day_id]' ";
// echo $product_query;
mysqli_set_charset($con, "utf8");
$rs_time = mysqli_query($con,$product_query);
while ($time_arr = mysqli_fetch_array($rs_time)) {
    // echo $time_arr['day_time_hours_from'];
    echo ' <table style="width:100%" class="table table-striped table-bordered table-list">
            <thead>
            <tr>
                <th scope="col">من</th>
                <th scope="col">الي</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">
                    <input type="time" text="'.$time_arr['day_time_hours_from'].'" value="'.$time_arr['day_time_hours_from'].'" id="from_'.$time_arr['day_time_id'].'" name="from_'.$time_arr['day_time_id'].'" />
                </th>
                <td>
                    <input type="time"   text="'.$time_arr['day_time_hours_to'].'"  value="'.$time_arr['day_time_hours_to'].'" id="to_'.$time_arr['day_time_id'].'" name="to_'.$time_arr['day_time_id'].'" />
                </td>
                <td>
                   <a class="btn btn-default" href="ProductUpdate.php?product_id=OA=="><em class="fa fa-pencil"></em></a>
                   <a href="#" id="delete_bttn_8" class="btn btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>                </td>
            </tr>
            </tbody>
 </table><br/>';


    }

}
?>




 
  