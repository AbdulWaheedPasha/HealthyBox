<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if(isset($_GET['user_id'])){
    $area_id_arr = array();
    $counter = 0;
    $driver_id = base64_decode($_GET['user_id']);
    $user_sql = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en FROM `administration_tbl` as admin Where `administration_id`  = $driver_id  ";
    // echo $user_sql ;
    mysqli_set_charset($con,"utf8");
    $rs = mysqli_query($con,$user_sql);
    $all_num_rows = mysqli_num_rows($rs);
    while ($arr = mysqli_fetch_array($rs)) {
        // print_r($arr);

?>
<!-- add_new_driver  -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['menu_item']['update_user_info']; ?></h4>

        </div>
        <div class="card-body">
            <div>
            <form action="./post/update_user_admin.php" method="post" enctype="multipart/form-data"  name="form" id="form">

                    <div class="form-group" id="Result"></div>
                    <div class="form-group">
                        <label><?php echo $languages['driver']['name']; ?>
                        </label>
                        <input class="form-control" name="RealUserName" value="<?php echo $arr['administration_name']; ?>">
                    </div>

                    <input class="form-control" type="hidden" name="id" value="<?php echo $arr['administration_id']; ?>">

                    <input class="form-control" type="hidden" name="administration_type_id" value="<?php echo $arr['administration_type_id']; ?>">

                    <div class="form-group">
                        <label><?php echo $languages['login']['username']; ?>
                        </label>
                        <input class="form-control" name="username" type="text" value="<?php echo base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_username'])))); ?>" id="username">
                                            </div>
                                              
                                            <div class=" form-group">
                        <label><?php echo $languages['login']['password']; ?>
                        </label>
                        <input class="form-control" name="password"  type="text"  value="<?php echo base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_password'])))); ?>" id="password">
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

                    <?php
                            $title1 = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];

                         echo  '<div class="alert alert-danger alert-dismissable"><b> '.$title1.'</b></div>';
                         ?>
                    <div class="form-group">


                        <select id="demo3" multiple="multiple" name="area_id[]" class="form-control" data-max="1">
                            <?php
                            $query = "SELECT `administration_type_id`, `administration_type_name_en`, `administration_type_name_ar` FROM `administration_type_tbl` where `administration_type_id` IN (1,2,3)  ";
                            mysqli_set_charset($con, "utf8");
                            $area_query = mysqli_query($con, $query);
                            $area_rows  = mysqli_num_rows($area_query);
                            while ($role_arr = mysqli_fetch_array($area_query)) {

                                $title_role = ($_SESSION['lang'] == "en") ? $role_arr['administration_type_name_en'] : $role_arr['administration_type_name_ar'];
                                echo '<option value="' . $role_arr['administration_type_id'] . '">' . $title_role . '</option>';
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
        placeholder: '<?php echo $languages['area']['role']; ?>',
        placeholderColor: 'green',
        selectColor: '#524781',
        itemTitle: 'Role selected',
        showEachItem: true,
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
                 // alert(data);
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == "1") {
                        Notify.suc({
                            title: 'OK',
                            text: jsonData.message,
                        });
                        $("form").trigger("reset");
                        setTimeout(function(){
                            window.location.href = 'dashboard.php?type=update_user&&user_id=<?php echo $_GET['user_id']; ?>';
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

}
}

?>