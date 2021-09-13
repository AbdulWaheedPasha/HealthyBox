<?php
session_start();
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
$lang = $_REQUEST["lang"];
//  echo $lang;
$direction   = ($lang == "en") ? "" : "text-right";
$style       = ($lang == "en") ? "" : "style='direction: rtl;'";
$style_text  = ($lang == "en") ? "" : "style='direction: rtl;float:right;text-align:right'";
include_once('../lang/' . $lang . '.php');
if ($_REQUEST["address_id"] == "1") {
?>
    <div class="card-body">
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number" >
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control" type="text" name="avenus_number">
        </div>
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['house_no']; ?></label>
            <input class="form-control" type="text" name="house_no">
        </div>
    </div>
<?php
} else if ($_REQUEST["address_id"] == "2") {
?>
    <div class="card-body">
        
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control" type="text" name="avenus_number">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['building']; ?></label>
            <input class="form-control" type="text" name="building_num">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['floor']; ?></label>
            <input class="form-control" type="text" name="floor">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['apart_num']; ?></label>
            <input class="form-control" type="text" name="apart_num">
        </div>
    </div>

<?php

} else {
?>
    <div class="card-body">
        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['block']; ?></label>
            <input class="form-control" type="text" name="block_number">
        </div>

        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['street']; ?></label>
            <input class="form-control" type="text" name="street_number">
        </div>


        <div class="form-group bmd-form-group">
            <label ><?php echo $languages['order']['avenue']; ?></label>
            <input class="form-control"" type="text" name="avenus_number">

            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['building']; ?></label>
                <input class="form-control" type="text" name="building_num">
            </div>


            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['floor']; ?></label>
                <input class="form-control"  type="text" name="floor">
            </div>

            <div class="form-group bmd-form-group">
                <label ><?php echo $languages['order']['office_num']; ?></label>
                <input class="form-control" type="text" name="office_num">
            </div>
        </div>
    <?php
}
}
    ?>

