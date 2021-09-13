<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
<!-- create_new_subscriber -->
<div class="form-group" id="Result"></div>
<div class="col-md-12">
    <form action="./post/insert_new_comment_driver.php" method="post" enctype="multipart/form-data" name="form" id="form">

        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['comment']['add']; ?></h4>
            </div>
            <div class="card-body">
                <div class="form-group" id="Result"></div>

                <div class="form-group">
                    <label><?php echo $languages['comment']['comment']; ?>
                    </label>
                    <input class="form-control" name="comment">
                </div>
               
<?php 
   $area_array = Array();
   $i = 0; 
    $area_sql = "SELECT * FROM  `capital_tbl` INNER JOIN `driver_capital_tbl` ON `driver_capital_tbl`.`capital_id` = `capital_tbl`.`capital_id` 
                                              INNER JOIN `area_tbl`           ON `area_tbl`.`capital_id` = `capital_tbl`.`capital_id` 
                    WHERE `driver_capital_tbl`.`driver_id` = $_SESSION[id]  ";
//    echo $area_sql;
    mysqli_set_charset($con, "utf8");
    $area_query = mysqli_query($con, $area_sql);
    while ($arr = mysqli_fetch_array($area_query)) {
        // print_r($arr);
        $area_array[$i] = $arr['area_id'];
        $i++;
    }
?>
            <div class="form-group"></div>


        


                <div class="form-group">
                    <label><?php echo $languages['area']['lbl_title']; 
                    
                     ?></label>
                    <select id="demo3" name="user_id" data-max="1" >
                        <?php
                        // print_r($area_array);
                        for($z=0;$z<count($area_array);$z++){
                                $sub_sql = "SELECT COUNT(`administration_tbl`.`administration_id`),`administration_tbl`.`administration_id`, `administration_tbl`.`administration_name`
                                            FROM  `administration_tbl` INNER JOIN `user_area_tbl` ON `administration_tbl`.`administration_id` = `user_area_tbl`.`user_id`
                                            WHERE `user_area_tbl`.`area_id` = $area_array[$z] AND `administration_tbl`.`administration_type_id` = 5
                                            GROUP BY `administration_tbl`.`administration_id`,`user_area_tbl`.`user_id`  ";
                                //echo $sub_sql."<br/>";
                                mysqli_set_charset($con, "utf8");
                                $sub_query = mysqli_query($con,$sub_sql);
                                while ($sub_arr = mysqli_fetch_array($sub_query)) {
                                    echo '<option value="'.$sub_arr['administration_id'].'">'.$sub_arr['administration_name'].'</option>';
                                }
                        }
                        ?>
                    </select>
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
    $("#demo3").easySelect({
        buttons: true, //
        search: true,
        placeholder: '<?php echo $languages['comment']['username']; ?>',
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
                            window.location.href = "dashboard.php?type=insert_comment_driver";
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