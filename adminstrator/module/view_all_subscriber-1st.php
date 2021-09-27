<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if ($_SESSION['role_id'] == "1" || $_SESSION['role_id'] == "2" ) {
?>
    <div class="row">
        <div class="col">
            <a href="dashboard.php?type=new_subscriber" class="btn btn-primary btn-round"><?php echo $languages['sub']['add']; ?><div class="ripple-container"></div></a>

        </div>
    </div><br />



    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script>
  
    $(document).ready(function() {
        $(".btn-warning").click(function() {
            //alert("Clicked");
            var para = {
                id: $(this).attr('data-href'),
                user_id: $(this).attr('data-val'),

            };
            // console.log("here");
            Notify.confirm({
                title: "<?php echo $languages['order']['hold_title']; ?>",
                html: "<b><?php echo $languages['order']['hold_que']; ?></b>",
                ok: function() {
                    $.ajax({
                        type: 'POST',
                        url: './ajax/hold_user.php',
                        data: para,
                        success: function(data) {
                             //alert(data);
                            var jsonData = JSON.parse(data);
                            if (jsonData.result == "1") {
                                Notify.suc({
                                    title: 'OK',
                                    text: jsonData.message,
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else {
                                Notify.suc(jsonData.message);
                            }

                        }

                    });
                },
                cancel: function() {
                    Notify.suc("<?php echo $languages['alert']['cancel']; ?>");
                }
            });
        });
    });
    // reactive request 
    $(document).ready(function() {
        $(".btn-success").click(function() {
            //alert("Clicked");
            var para = {
                user_id: $(this).attr('data-val'),
                user_area_id: $(this).attr('data-href'),
                duration_day: $(this).attr('data-progress'),
            };
            console.log(para);
            Notify.confirm({
                title: "<?php echo $languages['order']['unhold_title']; ?>",
                html: "<b><?php echo $languages['order']['un_hold_que']; ?></b>",
                ok: function() {
                    $.ajax({
                        type: 'POST',
                        url: './ajax/reactive_user_v2.php',
                        data: para,
                        success: function(data) {
                            // alert(data);
                            var jsonData = JSON.parse(data);
                            if (jsonData.result == "1") {
                                Notify.suc({
                                    title: 'OK',
                                    text: jsonData.message,
                                });

                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else {
                                Notify.suc(jsonData.message);
                            }

                        }

                    });
                },
                cancel: function() {
                    Notify.suc('<?php echo $languages['alert']['cancel']; ?>');
                }
            });
        });
    });

     // reactive request 
     $(document).ready(function() {
        $(".btn-danger").click(function() {
            //alert("Clicked");
            var para = {
                user_area_id: $(this).attr('data-href'),
                user_id     : $(this).attr('data-val'),
            };
            console.log(para);
            Notify.confirm({
                title: "<?php echo $languages['order']['delete_subscriber']; ?>",
                html: "<b><?php echo $languages['order']['delete_subscriber_question']; ?></b>",
                ok: function() {
                    $.ajax({
                        type: 'POST',
                        url: './ajax/delete_scubscriber_date.php',
                        data: para,
                        success: function(data) {
                            // alert(data);
                            var jsonData = JSON.parse(data);
                            if (jsonData.result == "1") {
                                Notify.suc({
                                    title: 'OK',
                                    text: jsonData.message,
                                });

                                setTimeout(function() { location.reload();  }, 3000);
                            } else {
                                Notify.suc(jsonData.message);
                            }

                        }

                    });
                  
                },
                cancel: function() {
                    Notify.suc('<?php echo $languages['alert']['cancel']; ?>');
                }
            });
        });
    });
</script>
<?php
}
?>


<link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>
        <script>
            // $(document).ready(function() {
            //     $('#example').DataTable();
            // });
            $(document).ready(function() {
                $('#sub').DataTable();
            });
        </script>

<?php
//view_all_subscriber
// $user_sql  = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` 
//                         WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en`
//                         FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en ,
//                         (SELECT  `program_active`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`) ) as program_active,
//                         (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id` ) as user_area_id,
//                         (SELECT  `program_start_date`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`) ) as start_date,
//                         (SELECT  `program_start_end`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`) ) as  end_date,
//                         (SELECT  `program_duration`  FROM `program_tbl` WHERE `program_id` =  (SELECT max(`program_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`)) as  program_duration
//                         FROM `administration_tbl` as admin Where `administration_type_id` = 5  ORDER BY `admin`.`administration_id`  ASC ";

$user_sql  = "SELECT *, (SELECT  `program_duration`  FROM `program_tbl` WHERE `program_id` = `user_area_tbl`.`program_id` )  as  program_duration
                    FROM
                    `user_area_tbl`
                    INNER JOIN `administration_tbl` AS admin
                    ON
                    `user_area_tbl`.`user_id` = `admin`.`administration_id`
                    INNER JOIN  `program_start_end_date_tbl`
                    ON
                    `program_start_end_date_tbl`.`user_area_id`  = `user_area_tbl`.`user_area_id`
                    
                    WHERE
                    `admin`.`administration_type_id` = 5 AND `user_area_tbl`.`user_area_id` =(
                    SELECT
                        MAX(`user_area_id`)
                    FROM `user_area_tbl` WHERE `user_id` = `admin`.`administration_id` )";


// echo $user_sql;

// Change character set to utf8
mysqli_set_charset($con, "utf8");
$rs = mysqli_query($con, $user_sql);
$all_num_rows = mysqli_num_rows($rs);

?>




<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['menu_item']['subs']; ?></h4>
            <p class="card-category"><?php echo $languages['sub']['describe']; ?></p>
        </div>
        <div class="card-body">


            <table id="sub" class="table table-hover ddtf-processed">
                <thead>

                <th> <?php echo $languages['driver']['code']; ?></th>
                <th><?php echo $languages['area']['name']; ?></th>
                <th><?php echo $languages['website']['telephone']; ?></th>
                <th><?php echo $languages['driver']['status']; ?></th>

                    <th> <?php echo $languages['table_user']['date']; ?></th>
                    <th> <?php echo $languages['order']['start']; ?></th>
                    <th> <?php echo $languages['order']['end']; ?></th>
                    <th> <?php echo $languages['order']['days']; ?></th>

                    <th class="text-align:center"> <?php echo $languages['area']['process']; ?></th>
                    </thead>
                <tbody>
                    <?php
                    
                    while ($arr = mysqli_fetch_array($rs)) {
                   
                        
                        // $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];
                        $active_str = "";
                        $hold_str  = "";
                        $acive = "";
                        $delete_str = "";
                        $diff =  0;
                        if($arr['program_active'] != 3){
                        date_default_timezone_set('Asia/Kuwait');
                        $current_date = date('Y-m-d')." 00:00:00";
                        
                        $day_num_sql = "SELECT COUNT(*) AS day_num FROM `program_day_tbl` WHERE `program_start_end_date_id` = (SELECT `program_start_end_date_id` FROM  
                                        `program_start_end_date_tbl` INNER JOIN `user_area_tbl` USING(`user_area_id`)  WHERE `user_area_id` = '$arr[user_area_id]' ) 
                                        AND `program_day_date` >= '$current_date' ";
                       // echo $day_num_sql."<br/>";

                        if ($day_result = mysqli_query($con, $day_num_sql)) {
                            // Fetch one and one row
                            while ($day_row = mysqli_fetch_row($day_result)) {
                             // printf ("%s \n", $day_row[0]);
                              $diff =  ($day_row[0] > 0) ? $day_row[0] : 0;
                            }
                          }
                        }else{
                            $day_num_sql = "SELECT  `hold_date_num_days` FROM `hold_date_tbl` WHERE `user_area_id` =  $arr[user_area_id] ";
                            // echo   $day_num_sql;
                            if ($day_result = mysqli_query($con, $day_num_sql)) {
                                // Fetch one and one row
                                while ($day_row = mysqli_fetch_row($day_result)) {
                                 // printf ("%s \n", $day_row[0]);
                                  $diff =  $day_row[0];
                                }
                              }

                        }
                          


                        if ($arr['program_active'] == 1) {
                            $acive = $languages['driver']['active'];
                            $hold_str = '<a  class="btn btn-warning btn-round"  data-val="' . base64_encode($arr['administration_id']) . '"  data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))) . '" > <i class="material-icons" style="margin: 0;">pause</i></a>';
                            $active_str = '<a class="btn btn-secondary btn-round" href="dashboard.php?type=renew_subscriber&&id=' . base64_encode($arr['user_area_id']) . '&&user_id=' . base64_encode($arr['administration_id']) . '&&delete_user=this" ><i class="material-icons" style="margin: 0;">autorenew</i></a>';
                            $delete_str = '<a href="#"  data-val="' . base64_encode($arr['administration_id']) . '" data-href="'.base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'"  class="btn btn-danger btn-round"> <i class="material-icons" style="margin: 0;">delete</i></a>';

                        } else if ($arr['program_active'] == 2) {
                            $acive = $languages['driver']['not_active'];
                           //  $hold_str = '<a  class="btn btn-warning btn-round"  data-val="' . base64_encode($arr['administration_id']) . '"   data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))) . '" > <i class="material-icons" style="margin: 0;">pause</i></a>';
                            $active_str = '<a class="btn btn-secondary btn-round" href="dashboard.php?type=renew_subscriber&&id=' . base64_encode($arr['user_area_id']) . '&&user_id=' . base64_encode($arr['administration_id']) . '&&delete_user=this" ><i class="material-icons" style="margin: 0;">autorenew</i></a>';

                            $delete_str = '<a href="#"  data-val="'.base64_encode($arr['administration_id']).'" data-href="'.base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'"  class="btn btn-danger btn-round"> <i class="material-icons" style="margin: 0;">delete</i></a>';

                        } else if ($arr['program_active'] == 3) { 
                            $acive     = $languages['driver']['hold'];
                            $hold_str = '<a  class="btn btn-success btn-round" data-val="' . $arr['administration_id'] . '" 
                                                                                   data-href="' . $arr['user_area_id'] . '" 
                                                                                   data-progress="' . $arr['program_duration'] . '" > 
                                                                                   <i class="material-icons" style="margin: 0;">done_all</i></a>';
                            $delete_str = '<a href="#"  data-val="'.base64_encode($arr['administration_id']).'" data-href="'.base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'"  class="btn btn-danger btn-round"> <i class="material-icons" style="margin: 0;">delete</i></a>';


                        } else if ($arr['program_active'] == 5){
                            $acive     =  $languages['driver']['delete'];
                            $hold_str = '<a  class="btn btn-dark btn-round" href="dashboard.php?type=renew_subscriber&&user_id='.base64_encode($arr['administration_id']).'&&id=' . base64_encode($arr['user_area_id']) . '" > <i class="material-icons" style="margin: 0;">update</i></a>';
                            $diff     = "0";
                        }else{
                            $acive     =  $languages['driver']['delete'];
                            $hold_str = '<a  class="btn btn-dark btn-round" href="dashboard.php?type=renew_subscriber&&user_id='.base64_encode($arr['administration_id']).'&&id=' . base64_encode($arr['user_area_id']) . '" > <i class="material-icons" style="margin: 0;">update</i></a>';
                            $diff     = "0";
                        }


                   
                    
                    // Formulate the Difference between two dates 
                  
                        echo '<tr>
                                <td>' . $arr['administration_id'] . '</td>
                                <td >' . $arr['administration_name'] . '</td>
                                <td>' . $arr['administration_telephone_number'] . '</td>
                                <td>' . $acive . '</td>
                                <td>' . $arr['administration_date_registeration'] . '</td>
                                <td>' . $arr['program_start_date'] . '</td>
                                <td>' . $arr['program_start_end'] . '</td>
                                <td>' . $diff . '</td>';

                        echo ' <td class="td-actions"> ';
                        if ($_SESSION['role_id'] == "1" || $_SESSION['role_id'] == "2") {
                            if($arr['administration_active'] != 5){
                                echo '<a href="dashboard.php?type=update_address&&id=' . base64_encode($arr['user_area_id']) . '&&user_id=' . base64_encode($arr['administration_id']) . '" class="btn btn-secondary btn-round"> <i class="material-icons" style="margin: 0;">edit</i></a>'; 
                            }
                       echo $active_str . $hold_str . $delete_str;
                        }
                        echo '<a href="dashboard.php?type=user_detials&&id=' . base64_encode($arr['administration_id']) . '" class="btn btn-info btn-round"> <i class="material-icons" style="margin: 0;">touch_app</i></a></td></tr>';
                    }
                    ?>
                </tbody>
            </table>




        </div>
    </div>



</div>

</div>
</div>
</div>

<?php

                }
                ?>
