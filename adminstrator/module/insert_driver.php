<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
<!-- add_new_driver  -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['driver']['add']; ?></h4>

        </div>
        <div class="card-body">
            <div>
                <form action="./post/insert_new_driver.php" method="post" enctype="multipart/form-data" name="form" id="form">

                    <div class="form-group" id="Result"></div>
                    <div class="form-group">
                        <label><?php echo $languages['driver']['name']; ?>
                        </label>
                        <input class="form-control" name="RealUserName">
                    </div>


                    <div class="form-group">
                        <label><?php echo $languages['driver']['telep']; ?>
                        </label>
                        <input class="form-control" name="Telephone" onkeypress="return isNumberKey(event)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8" >
                    </div>
                    <script type="application/javascript">
                        function isNumberKey(evt) {
                            var charCode = (evt.which) ? evt.which : event.keyCode
                            if (charCode > 31 && (charCode < 48 || charCode > 57))
                                return false;

                            return true;
                        }
                    </script>

                    <div class="form-group">
                        <label><?php echo $languages['login']['username']; ?>
                        </label>
                        <input class="form-control" name="username" type="text" id="username">
                                            </div>
                                              
                                            <div class=" form-group">
                        <label><?php echo $languages['login']['password']; ?>
                        </label>
                        <input class="form-control" name="password"  type="text" id="password">
                    </div>
                    <script>
                $('#username').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                $('#password').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                </script>



                    <div class="form-group">


                        <select id="demo3" multiple="multiple" name="area_id[]" class="form-control" style="direction: rtl;" >
                            <?php
                            $query = "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl`  ";
                            mysqli_set_charset($con, "utf8");
                            $area_query = mysqli_query($con, $query);
                            $area_rows  = mysqli_num_rows($area_query);
                            while ($arr = mysqli_fetch_array($area_query)) {

                                $title = ($_SESSION['lang'] == "en") ? $arr['capital_en_title'] : $arr['capital_ar_title'];
                                echo '<option value="' . $arr['capital_id'] . '">' . $title . '</option>';
                            }
                            ?>

                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitForm" class="btn btn-primary btn-round"><?php echo $languages['bttn_lbl']['save']; ?></button>
            </div>
        </div>


    </div>
</div>
</div>

<script>
    $("#demo3").easySelect({
        buttons: true, //
        search: true,
        placeholder: '<?php echo $languages['area']['pro']; ?>',
        placeholderColor: 'green',
        selectColor: '#524781',
        itemTitle: '<?php echo $languages['area']['pro']; ?>',
        showEachItem: false,
        width: '100%',
        dropdownMaxHeight: '450px',
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                //    alert(data);
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == "1") {
                        Notify.suc({
                            title: 'OK',
                            text: jsonData.message,
                        });
                        $("form").trigger("reset");
                        setTimeout(function(){
                            window.location.href = 'dashboard.php?type=add_new_driver';
                        }, 3000);
                    } else {
                        Notify.suc(jsonData.message);
                    }
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
}
?>