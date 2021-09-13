<?php
// update address user 
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if (isset($_GET['id'])) {
    require_once('./lang/' . $_SESSION['lang'] . '.php');
    require_once("./Controller/UserAddressController.php");
    require_once("./Model/UserModel.php");
     $user_area_id        = base64_decode($_GET['id']);
     $user_id             = base64_decode($_GET['user_id']);
     $user_model          = new user_model();
     $user_controller     = new user_address_controller($user_model,$con);
     $user_model->set_user_area_id($user_area_id);
     $user_model->set_user_id($user_id);
     $user_controller->select_address_where_program_id();
     $user_controller->select_user_personal_info_where_id();
     
            ?>
            <div class="form-group" id="Result"></div>
<div class="col-md-12">
    <form action="./post/update_subscriber.php" method="post" enctype="multipart/form-data" name="form" id="form">

        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['sub']['update']; ?></h4>
            </div>
            <div class="card-body">
                <div class="form-group" id="Result"></div>
                <input class="form-control" name="user_id" value="<?php echo $user_id;?>" type="hidden">
                <input class="form-control" name="user_area_id" value="<?php echo $user_area_id;?>" type="hidden">
                <input class="form-control" name="old_area_id" value="<?php echo $user_model->get_user_area_id(); ?>" type="hidden">
                <div class="form-group">
                    <label><?php echo $languages['driver']['name']; ?>
                    </label>
                    <input class="form-control" name="RealUserName" value="<?php echo $user_model->get_administration_name(); ?>">
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['driver']['telep']; ?>
                    </label>
                    <input class="form-control" name="Telephone" id="Telephone"  onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8"   value="<?php echo $user_model->get_administration_telephone_number(); ?>">
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['sub']['telep']; ?>
                    </label>
                    <input class="form-control" name="Telephone2" id="Telephone2" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8"  value="<?php echo $user_model->get_administration_telephone_number1(); ?>">
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['login']['username']; ?>
                    </label>
                    <input class="form-control" name="username" value="<?php echo $user_model->get_administration_username(); ?>">
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['login']['password']; ?>
                    </label>
                    <input class="form-control" name="password" value="<?php echo $user_model->get_administration_password(); ?>">
                </div>
                
             

            </div>
            <div class="form-group"></div>


            <div class="card-header card-header-primary">
                <h4 class="card-title"><?php echo $languages['sub']['address_header']; ?></h4>
            </div>
            <div class="card-body">

            <?php 
               $area_id = $user_model->get_user_area_id();
               $query = "SELECT * FROM `area_tbl` where  `area_id` = '$area_id' ";
               mysqli_set_charset($con, "utf8");
               $area_query = mysqli_query($con, $query);
               $area_rows  = mysqli_num_rows($area_query);
               while ($arr = mysqli_fetch_array($area_query)) {
                   $title = ($_SESSION['lang'] == "en") ? $arr['area_name_eng'] : $arr['area_name_ar'];
               }
               
                   ?>
               <div class="alert alert-success" role="alert">
  <strong><?php echo $languages['area']['lbl_title']; ?> <?php   echo $title;?> </strong>
</div>
                <div class="form-group">
                    <label><?php echo $languages['area']['lbl_title']; ?></label>
                    <select class="form-control" name="area_id"  >
                        <?php
                         echo '<option value="0" >'.$languages['area']['select'].'</option>';
                        $query = "SELECT * FROM `area_tbl` ";
                        mysqli_set_charset($con, "utf8");
                        $area_query = mysqli_query($con, $query);
                        $area_rows  = mysqli_num_rows($area_query);
                        while ($arr = mysqli_fetch_array($area_query)) {

                            $title = ($_SESSION['lang'] == "en") ? $arr['area_name_eng'] : $arr['area_name_ar'];
                            echo '<option value="'.$arr['area_id'].'">'.$title .'</option>';
                        }
                        ?>
                    </select>
                </div>

       <!-- 
                <div class="form-group"> -->
                    <!-- <label><?php //echo $languages['sub']['place']; ?></label> -->
                    <!-- <select class="form-control" name="place_id" onchange="showAddresssDetials(this.value,'<?php //echo $_SESSION['lang']; ?>')"> -->
                    <?php
                        mysqli_set_charset($con, "utf8");
                        $place_rs  = mysqli_query($con, "SELECT `place_type_id`, `place_type_eng`, `place_type_ar` FROM `place_type_tbl`");
                        $place_num = mysqli_num_rows($place_rs);
                        while ($place_arr = mysqli_fetch_array($place_rs)) {
                            $title = ($_SESSION['lang'] == "en") ? $place_arr["place_type_eng"] : $place_arr["place_type_ar"];
                            //echo '<option value="' . $place_arr['place_type_id'] . '">' . $title . '</option>';
                            echo '<input  type="hidden" id="place_id" name="place_id" value="'.$place_arr['place_type_id'].'">';
                        }

                        ?>
                    <!-- </select> -->
                    
                <!-- </div> -->
              


                <div id="address">
                <?php
if ($user_model->get_place_id() == "1") {
?>
    <div class="card-body">
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number" value="<?php echo $user_model->get_user_area_block(); ?>">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number" value="<?php echo $user_model->get_user_area_street(); ?>">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control" type="text" name="avenus_number" value="<?php echo $user_model->get_user_area_avenue(); ?>">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['house_no']; ?></label>
            <input class="form-control" type="text" name="house_no"  value="<?php echo $user_model->get_user_area_house_num(); ?>">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['floor']; ?></label>
            <input class="form-control" type="text" name="floor"  value="<?php echo $user_model->get_user_area_floor(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['apart_num']; ?></label>
            <input class="form-control" type="text" name="apart_num"  value="<?php echo $user_model->get_user_area_apartment_num(); ?>">
        </div>
    </div>
<?php
} else if ($user_model->get_place_id() == "2") {
?>
    <div class="card-body">
        
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number" value="<?php echo $user_model->get_user_area_block(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number" value="<?php echo $user_model->get_user_area_street(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control" type="text" name="avenus_number" value="<?php echo $user_model->get_user_area_avenue(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['building']; ?></label>
            <input class="form-control" type="text" name="building_num" value="<?php echo $user_model->get_user_area_building_num(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['floor']; ?></label>
            <input class="form-control" type="text" name="floor"  value="<?php echo $user_model->get_user_area_floor(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['apart_num']; ?></label>
            <input class="form-control" type="text" name="apart_num"  value="<?php echo $user_model->get_user_area_apartment_num(); ?>">
        </div>
    </div>

<?php

} else {
?>
    <div class="card-body">
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number" value="<?php echo $user_model->get_user_area_block(); ?>">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number" value="<?php echo $user_model->get_user_area_street(); ?>">
        </div>


        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control" type="text" name="avenus_number"  value="<?php echo $user_model->get_user_area_avenue(); ?>">

            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['building']; ?></label>
                <input class="form-control" type="text" name="building_num" value="<?php echo $user_model->get_user_area_building_num(); ?>">
            </div>


            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['floor']; ?></label>
                <input class="form-control"  type="text" name="floor" value="<?php echo $user_model->get_user_area_floor(); ?>">
            </div>

            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['office_num']; ?></label>
                <input class="form-control" type="text" name="office_num"  value="<?php echo $user_model->get_user_area_office_num(); ?>">
            </div>
        </div>
    <?php
}
    ?>


                </div>
             
                <div class="form-group bmd-form-group">
                    <label><?php echo $languages['order']['figure']; ?></label>
                    <input class="form-control" type="text" name="figure" value="<?php echo $user_model->get_user_area_automated_figure(); ?>">
                </div>
                
                <div class="form-group">
                    <label><?php echo $languages['order']['note']; ?></label>
                    <div class="form-group bmd-form-group">
                        <textarea class="form-control" name="note" rows="5" ><?php echo $user_model->get_user_area_notes(); ?></textarea>
                    </div>
                </div>

    </form>
    <div class="modal-footer">
        <button type="button" id="submitForm" class="btn btn-primary btn-round"><?php echo $languages['bttn_lbl']['save']; ?></button>
    </div>
</div>

</div>


</div>






</div>

</div>

<script>
$(document).ready(function(){
  $('#Telephone').bind("paste",function(e) {
      e.preventDefault();
  });
  $('#Telephone2').bind("paste",function(e) {
      e.preventDefault();
  });
});

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
                    if(jsonData.result == "1"){
                        Notify.suc(jsonData.message);
                        setTimeout(function() {
                            window.location.href = "dashboard.php?type=update_address&&id=<?php echo $_GET['id'] ?>&&user_id=<?php echo $_GET['user_id']; ?>";
                            }, 3000);
           
                        // location.reload(true);
                     }else if(jsonData.result == "2"){
                         Notify.suc(jsonData.message);
                     }else if(jsonData.result == "3"){
                         Notify.suc(jsonData.message);
                     }else if(jsonData.result == "4"){
                         Notify.suc(jsonData.message);
                     }else if(jsonData.result == "5"){
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


?>