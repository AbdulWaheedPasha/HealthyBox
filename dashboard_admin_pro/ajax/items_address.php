
<meta charset="UTF-8">
<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
// print_r($_REQUEST);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
$lang = $_REQUEST["lang"];
//  echo $lang;
$direction   = ($lang == "en") ? "" : "text-right";
$style       = ($lang == "en") ? "" : "style='direction: rtl;'";
$style_text  = ($lang == "en") ? "" : "style='direction: rtl;float:right;text-align:right'";
echo $_REQUEST['user_area_id'];
include_once('../lang/' . $lang . '.php');
require_once("../Configuration/db.php");
require_once("../Controller/UserAddressController.php");
require_once("../Model/UserModel.php");
$user_model          = new user_model();
$user_controller     = new user_address_controller($user_model,$con);
$user_model->set_user_area_id($_REQUEST['user_area_id']);
$user_controller->select_address_where_program_id();
if ($_REQUEST["address_id"] == "1") {
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
    </div>
<?php
} else if ($_REQUEST["address_id"] == "2") {
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
            <input class="form-control"" type="text" name="avenus_number"  value="<?php echo $user_model->get_user_area_avenue(); ?>">

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
                <input class="form-control" type="text" name="office_num"  value="<?php echo $user_model->get_user_area_apartment_num(); ?>">
            </div>
        </div>
    <?php
}
}
    ?>

