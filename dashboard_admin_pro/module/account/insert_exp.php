<!-- create_new_subscriber -->
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
<div class="col-md-12">
    <form action="./post/insert_expenses_detials.php" method="post" enctype="multipart/form-data" name="form" id="form">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['program']['add_exp']; ?></h4>
            </div>
            <div class="card-body">
                <div class="form-group" id="Result"></div>

                <div class="form-group">
                    <label><?php echo $languages['program']['title']; ?>
                    </label>
                    <input class="form-control" name="type_expenses">
                </div>


                <div class="form-group"></div>





                <div class="form-group">
                    <label><?php echo $languages['program']['cost']; ?></label>
                    <input  class="form-control" name="product_price" type="number"  onkeypress="return validateDollar(this)"   step=".01" >
                </div>

     <script>
       function validateDollar(fld){
           var temp_value = fld.value;
           if (temp_value == ""){
            fld.value = "$0.00";
            return;
        }
            var Chars = "0123456789.,$";
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