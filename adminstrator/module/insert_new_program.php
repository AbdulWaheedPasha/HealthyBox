<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once './Controller/Program.php';
    $program_controller =  new all_program_controller($con);
    $program_arr =  $program_controller->fetc_cat();
    $color_arr   = $program_controller->fetc_color();
    //print_r($program_arr);
?>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title"><?php echo $languages['program']['home']; ?></h4>
        <p class="card-category"><?php echo $languages['program']['describe']; ?></p>
    </div>
    <div class="card-body" >

        <div id="Result"></div>
        <form action="./post/insert_new_program.php" method="post" enctype="multipart/form-data" name="form" id="form" >

            <div class="form-group" id="Result"></div>

            <div class="form-group">
                <label><?php echo $languages['cap_page']['name_en']; ?>
                </label>
                <input class="form-control" name="category_title_en">
            </div>
            <div class="form-group">
                <label> <?php echo $languages['cap_page']['name_ar']; ?>
                </label>
                <input class="form-control" name="category_title_ar">
            </div>

            <div class="form-group">
                <label> <?php echo $languages['cap_page']['desc_en']; ?>
                </label>
                <input class="form-control" name="dec_title_en">
            </div>
            <div class="form-group">
                <label> <?php echo $languages['cap_page']['desc_ar']; ?>
                </label>
                <input class="form-control" name="dec_title_ar">
            </div>
            <div class="form-group">
                <label> <?php echo $languages['program']['dur']; ?>
                </label>
                <input class="form-control" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" name="Duration" onkeypress="return isNumber(event)">
            </div>
            



<div class="form-group">
                <label> <?php echo $languages['category']['category']; ?>
                </label>
                <select class="form-control"  id="first"  name="cate_id">                                                           
                         <?php
                        for($i=0;$i<count($program_arr);$i++){
                                $title = ($_SESSION['lang'] == "en") ? $program_arr[$i]['type_en'] : $program_arr[$i]['type_ar'];
                                echo '<option  value="'.$program_arr[$i]['program_id'].'">'.$title.'</option>';

                            }
                            ?>

                        </select>
            </div>


            <div class="form-group">
                <label> <?php echo $languages['category']['color']; ?>
                </label>
                <select class="form-control"  id="color_list"  name="color_list">                                                           
                         <?php
                        for($i=0;$i<count($color_arr);$i++){
                                // $title = ($_SESSION['lang'] == "en") ? $color_arr[$i]['type_en'] : $program_arr[$i]['type_ar'];
                                echo '<option  value="'.$color_arr[$i]['color_id'].'">'.$color_arr[$i]['color_name'].'</option>';

                            }
                            ?>

                        </select>
            </div>


            <div class="form-group">
                <label> <?php echo $languages['program']['price']; ?>
                </label>
                <input class="form-control" name="price" id="price" >
            </div>

            <div class="form-group">
                <label> <?php echo $languages['program']['discount']; ?>
                </label>
                <input class="form-control" name="discount" id="discount" >
            </div>


            <script>
         $("#price").on("keypress keyup blur", function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $("#discount").on("keypress keyup blur", function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });


            </script>

            <div class="form-group">
                <label> <?php echo $languages['program']['img']; ?>
                </label>
                
            </div>

            <input type="file" name="file" id="file">



            <br />



            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-round" value="<?php echo $languages['cap_page']['submit']; ?>">
            </div>

        </form>



       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
   
            $(document).ready(function() {
                // File type validation
                $("#file").change(function() {
                    var file = this.files[0];
                    var fileType = file.type;
                    var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
                    if(!( (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
                        Notify.suc('<?php echo $languages['cap_page']['not_allowed'] ;?>');
                        $("#file").val('');
                        return false;
                    }
                });


                $("#form").on("submit", function(e) {

                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data, textStatus, jqXHR) {
                            //    alert(data);
                            var jsonData = JSON.parse(data);
                            if (jsonData.result == "1") {
                                Notify.suc({
                                    title: 'OK',
                                    text: jsonData.message,
                                });
                                setTimeout(function() { window.location.href = "dashboard.php?type=insert_new_program";}, 3000);
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