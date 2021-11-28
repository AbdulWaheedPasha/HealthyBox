<!-- create_new_subscriber -->
<?php
// session_start();
// error_reporting(0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
// error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_NOTICE);

if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $id  = base64_decode($_GET['id']);
    require_once("./Configuration/db.php");
    require_once './lang/' . $_SESSION['lang'] . '.php';
    mysqli_set_charset($con, "utf8");
    $query   = "SELECT `expenses_detials_id`, `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` WHERE  `expenses_detials_id` =  '$id' ";
  //  echo $query;
    $rs 	 = mysqli_query($con, $query);
    if(mysqli_num_rows($rs) > 0){
        if ($rs) {
            while ($arr = mysqli_fetch_array($rs)) {
  
?>
<div class="col-md-12">
    <form action="./post/update_expenses.php" method="post" enctype="multipart/form-data" name="form" id="form">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title"><?php echo $languages['sub']['update_exp']; ?></h4>
                <h6 class="card-title"><?php echo $languages['sub']['describe_update']; ?></h6>
            </div>
            <div class="card-body">
                <div class="form-group" id="Result"></div>
                <input class="form-control" name="expenses_detials_id" type="hidden" value="<?php echo $arr['expenses_detials_id']; ?>" >
                <div class="form-group">
                    <label><?php echo $languages['program']['title']; ?>
                    </label>
                    <input class="form-control" name="type_expenses"  value="<?php echo $arr['expenses_detials_name']; ?>" >
                </div>


                <div class="form-group"></div>

                <div class="form-group">
                    <label><?php echo $languages['program']['cost']; ?></label>
                    <input  class="form-control" name="product_price"   onkeypress="return validateDollar(this)"    value="<?php echo $arr['expenses_detials_cost']; ?>" >
                </div>

                <div class="form-group">
                    <label><?php echo "Date and Time" ?></label>
                    <input class="form-control"  type="datetime-local" id="expenses_detials_date" name="expenses_detials_date" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($arr['expenses_detials_date'])) ?>">
                </div>


     <script>
       function validateDollar(fld){
           var temp_value = fld.value;
           if (temp_value == ""){
            fld.value = "$0.00";
            return;
        }
            var Chars = "0123456789.,KD";
            for (var i = 0; i < temp_value.length; i++)
            {
                if (Chars.indexOf(temp_value.charAt(i)) == -1)
                {
                    alert("Invalid Character(s)\n\nOnly numbers (0-9), a dollar sign, a comma, and a period are allowed in this field.");
                    fld.focus();
                fld.select();
                    return;
                }
            }
        } 
    </script>


    </form>
    <div class="modal-footer">
        <button type="button" id="submitForm" class="btn btn-primary btn-round"><?php echo $languages['bttn_lbl']['save']; ?></button>
    </div>
</div>

<?php
            }
        }
    }
            ?>


<script>
    /* must apply only after HTML has loaded */
    $(document).ready(function() {
        $("#form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus,
                    jqXHR) {
                    $('#Result').html(data);
                    $("#form").trigger('reset');
                    // $("#submitForm").remove();

                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                    // $("#submitForm").remove();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " +
                        error);
                }
            });
            e.preventDefault();
        });

        $("#submitForm").on('click', function() {
            $("#form").submit();
        });
    });
</script>
</div>


</div>






</div>

</div>

<?php
}
?>