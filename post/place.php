<?php
session_start();
$lang = $_GET["lang"];
//  echo $lang;
$direction   = ($lang == "en") ? "" : "text-right";
$style       = ($lang == "en") ? "" : "style='direction: rtl;'";
$style_text  = ($lang == "en") ? "" : "style='direction: rtl;float:right;text-align:right'";
include_once('../dashboard_admin/lang/' . $_SESSION['lang'] . '.php');
if ($_GET["address_id"] == "1") {
?>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" name="block_number" data-minlength="1" class="form-control field-name" placeholder="<?php echo $languages['website']['block']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" name="street_number" data-minlength="1" class="form-control field-name" placeholder="<?php echo $languages['website']['block']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" name="avenus_number" data-minlength="0" class="form-control" placeholder="<?php echo $languages['website']['avenue']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" name="house_no" data-minlength="1" class="form-control field-name" placeholder="<?php echo $languages['website']['house_no']; ?>">
        </div>
    </div>

<?php
} else if ($_GET["address_id"] == "2") {
?>
    <div class="row">

        <div class="col-12 input-group p-0">
       
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="block_number" placeholder="<?php echo $languages['website']['block']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="street_number" placeholder="<?php echo $languages['website']['street']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="0" class="form-control field-name"  name="avenus_number" placeholder="<?php echo $languages['website']['avenue']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">

            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="building_num" placeholder="<?php echo $languages['website']['building']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <label></label>
            <input class="form-control" type="text" name="floor" data-minlength="0" class="form-control field-name" placeholder="<?php echo $languages['website']['floor']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" name="apart_num" data-minlength="0" class="form-control field-name" placeholder="<?php echo $languages['website']['apart_num']; ?>">
        </div>
    </div>


<?php

} else {
?>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name"  name="block_number" placeholder="<?php echo $languages['website']['block']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="street_number" placeholder="<?php echo $languages['website']['street']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control"" type=" text" data-minlength="0" class="form-control field-name" name="avenus_number" placeholder="<?php echo $languages['website']['avenue']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="building_num" placeholder="<?php echo $languages['website']['building']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="0" class="form-control field-name"  name="floor"  placeholder="<?php echo $languages['website']['floor']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-12 input-group p-0">
            <input class="form-control" type="text" data-minlength="1" class="form-control field-name" name="office_num" placeholder="<?php echo $languages['website']['office_num']; ?>">
        </div>
    </div>

<?php
}
?>