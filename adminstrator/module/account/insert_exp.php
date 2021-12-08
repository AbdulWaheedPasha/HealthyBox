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
                    <input  class="form-control" name="product_price" type="textfield" id="product_price" >
                </div>


                <div class="form-group">
                    <label><?php echo "Date and Time" ?></label>
                    <!-- <input class="form-control"  type="text"  id="expenses_detials_date" name="expenses_detials_date"/> -->
                    <input class="form-control"  type="date" id="expenses_detials_date" name="expenses_detials_date">
                </div>


  <script>
         $("#product_price").on("keypress keyup blur", function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
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
            console.log(postData);
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