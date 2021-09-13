<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
 
require_once("./Model/UserModel.php");
$user_model          = new user_model();
?>
<!-- create_new_subscriber -->
<div class="form-group" id="Result"></div>
<div class="col-md-12">
    <form action="./post/insert_new_subscriber.php" method="post" enctype="multipart/form-data" name="form" id="form">

        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['sub']['new']; ?></h4>
            </div>
            <div class="card-body">
                <div class="form-group" id="Result"></div>

                <div class="form-group">
                    <label><?php echo $languages['driver']['name']; ?>
                    </label>
                    <input class="form-control" name="RealUserName">
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['driver']['telep']; ?>
                    </label>
                    <input class="form-control" name="Telephone"  id="Telephone" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8" >
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['sub']['telep']; ?>
                    </label>
                    <input class="form-control" name="Telephone2" id="Telephone2" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8" >  
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['login']['username']; ?>
                    </label>
                    <input class="form-control" name="username" id="username">
                </div>
              
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['login']['password']; ?>
                    </label>
                    <input class="form-control" name="password"  id="password">
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
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['program_detials']['date_program']; ?>
                    </label>
                    <input class="form-control" name="date_start" type="date" >
                </div>
                <div class="form-group bmd-form-group">
                    <label ><?php echo $languages['sub']['program']; ?></label>
                </div>
               
                

                <div class="form-group bmd-form-group">
                     
               
                    <?php
                    $query = "SELECT `program_id`, `program_title_ar`, `program_title_en`, `program_duration` FROM `program_tbl` ";
                    // echo $query; 
                    mysqli_set_charset($con, "utf8");
                    $area_query = mysqli_query($con, $query);
                    $area_rows  = mysqli_num_rows($area_query);
                    ?>
                    <select name="program_name" class="form-control">
                        <option value="0"><?php echo $languages['sub']['select']; ?></option>
                        <?php


                        while ($arr = mysqli_fetch_array($area_query)) {

                            $title = ($_SESSION['lang'] == "en") ? $arr['program_title_en'] : $arr['program_title_ar'];
                            echo '<option value="'.$arr['program_id'] .'&&'.$arr['program_duration'].'">' . $title . " (" . $arr['program_duration'] . ')</option>';
                        }
                        ?>
                    </select> 
                </div>

            </div>
            <div class="form-group"></div>


            <div class="card-header card-header-primary">
                <h4 class="card-title"><?php echo $languages['sub']['address_header']; ?></h4>
            </div>
            <div class="card-body">


                <div class="form-group">
                    <label><?php echo $languages['area']['lbl_title']; ?></label>
                    <select id="demo3" name="area_id" data-max="1" >
                        <?php
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
                    <!-- <label><?php echo $languages['sub']['place']; ?></label> -->
                    <!-- <select class="form-control" name="place_id" onchange="showAddresssDetials(this.value,'<?php echo $_SESSION['lang']; ?>')"> -->
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
                    <div class="card-body">

                        <div class="form-group bmd-form-group">
                            <label><?php echo $languages['order']['block']; ?></label>
                            <input class="form-control" type="text" name="block_number">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label><?php echo $languages['order']['street']; ?></label>
                            <input class="form-control" type="text" name="street_number">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label><?php echo $languages['order']['avenue']; ?></label>
                            <input class="form-control" type="text" name="avenus_number">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label><?php echo $languages['order']['house_no']; ?></label>
                            <input class="form-control" type="text" name="house_no">
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
                </div>

                <div class="form-group bmd-form-group">
                    <label><?php echo $languages['order']['figure']; ?></label>
                    <input class="form-control" type="text" name="figure">
                </div>

                <div class="form-group">
                    <label><?php echo $languages['order']['note']; ?></label>
                    <div class="form-group bmd-form-group">
                        <textarea class="form-control" name="note" rows="5"></textarea>
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
			function isNumericKey(evt)
			{
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31 
				&& (charCode < 48 || charCode > 57))
				return true;
				return false;
			} 
    $("#demo3").easySelect({
        buttons: true, //
        search: true,
        placeholder: '<?php echo $languages['area']['lbl_title']; ?>',
        placeholderColor: 'green',
        selectColor: '#524781',
        itemTitle: 'Area selected',
        showEachItem: true,
        width: '100%',
        dropdownMaxHeight: '450px',
    })
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
                    if(jsonData.result == "1"){
                        Notify.suc(jsonData.message);
                        setTimeout(function() {
                            window.location.href = "dashboard.php?type=new_subscriber";
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
?>