<?php
// insert new insert_new_subscriber
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
<div class="row">
    <div class="col">
        <a href="dashboard.php?type=new_subscriber" class="btn btn-primary btn-round"><?php echo $languages['sub']['add']; ?><div class="ripple-container"></div></a>

    </div>
</div><br />


<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title "><?php echo $languages['search']['search_advence']; ?></h4>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <form action="./dashboard.php?type=driver" method="get">
                    <input type="hidden" name="type" value="<?php echo 'subs'; ?>">
                    <div class="form-group">
                        <label><?php echo $languages['driver']['name']; ?>
                        </label>
                        <input class="form-control" name="RealUserName">
                    </div>
                    <div class="form-group">
                        <label><?php echo $languages['driver']['telep']; ?>
                        </label>
                        <input class="form-control" name="Telephone" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8" >
                    </div>


                    <div class="form-group">
                        <?php

                        $query = "SELECT * FROM `area_tbl` ";
                        // echo $query; 
                        mysqli_set_charset($con, "utf8");
                        $area_query = mysqli_query($con, $query);
                        $area_rows  = mysqli_num_rows($area_query);
                        ?>


                        <select id="demo3" multiple="multiple" name="area_id[]" class="form-control">
                            <?php

                            while ($arr = mysqli_fetch_array($area_query)) {

                                $title = ($_SESSION['lang'] == "en") ? $arr['area_name_eng'] : $arr['area_name_ar'];
                                echo '<option value="' . $arr['area_id'] . '">' . $title . '</option>';
                            }
                            ?>

                        </select>
                    </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?php echo $languages['sub']['status_user']; ?>
                    </label>
                    <?php

                    $query = "SELECT `user_status_id`, `user_status_ar_name`, `user_status_eng_name` FROM `user_status_tbl`  ";
                    // echo $query; 
                    mysqli_set_charset($con, "utf8");
                    $area_query = mysqli_query($con, $query);
                    $area_rows  = mysqli_num_rows($area_query);
                    ?>


                    <select name="user_status" class="form-control">
                        <?php

                        while ($arr = mysqli_fetch_array($area_query)) {

                            $title = ($_SESSION['lang'] == "en") ? $arr['user_status_eng_name'] : $arr['user_status_ar_name'];
                            echo '<option value="' . $arr['user_status_id'] . '">' . $title . '</option>';
                        }
                        ?>

                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo $languages['sub']['program']; ?>
                    </label>
                    <?php

                    $query = "SELECT `program_id`, `program_title_ar`, `program_title_en`, `program_duration` FROM `program_tbl` ";
                    // echo $query; 
                    mysqli_set_charset($con, "utf8");
                    $area_query = mysqli_query($con, $query);
                    $area_rows  = mysqli_num_rows($area_query);
                    ?>


                    <select name="program_name" class="form-control">
                        <?php

                        while ($arr = mysqli_fetch_array($area_query)) {

                            $title = ($_SESSION['lang'] == "en") ? $arr['program_title_en'] : $arr['program_title_ar'];
                            echo '<option value="' . $arr['program_id'] . '">' . $title . " (" . $arr['program_duration'] . ')</option>';
                        }
                        ?>

                    </select>
                </div>


                <div class="form-group">
                    <label><?php echo $languages['sub']['block']; ?>
                    </label>
                    <input class="form-control" name="block" onkeypress="return isNumberKey(event)">
                </div>

            </div>
        </div>

    </div>
</div>

<script>
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


<?php
$search_qeury = "";
$limit = 0;
$num_counter1 = 10;


if (isset($_GET['limit'])) {
    $limit = $_GET['limit'] * $num_counter1;
}



if (isset($_GET['submit'])) {
    $where_sql  = "";

    if (!empty($_GET['Telephone'])) {
        $where_sql = $where_sql . " and `administration_tbl`.`administration_telephone_number` = '" . $_GET['Telephone'] . "' ";
    }
    if (!empty($_GET['RealUserName'])) {
        $where_sql = $where_sql . " and  `administration_tbl`.`administration_name` LIKE '%" . $_GET['RealUserName'] . "%'  ";
    }
    if (count($_GET['area_id']) > 0) {
        $str = "";
        $i = 0;
        foreach ($_GET['area_id'] as $key) {
            if ($i != count($_GET['area_id']) - 1) {
                $str = '"' . $key . '"' . "," . $str;
                $i++;
            } else {
                $str = $str . '"' . $key . '"';
            }
        }
        //echo $str."<br/>";



        // $array = $_GET['area_id'];
        $where_sql = $where_sql . " and `user_area_tbl`.`area_id` IN ($str) ";
        // echo  $where_sql."<br/>";;
        $user_sql  = "SELECT *, ( SELECT `administration_type_name_ar` FROM `administration_type_tbl`  WHERE  `administration_type_id` = `administration_tbl`.`administration_type_id`) as type_ar,  ( SELECT  `administration_type_name_en` FROM `administration_type_tbl`  WHERE  `administration_type_id` = `administration_tbl`.`administration_type_id` ) as type_en  FROM `administration_tbl` inner join `user_area_tbl` on `user_area_tbl`.`user_id` = `administration_tbl`.`administration_id`  Where  `administration_tbl`.`administration_type_id` = 5  $where_sql    GROUP by   `administration_tbl`.`administration_id`   ";
        $order_count_sql = $user_sql;
        $user_sql   = $user_sql . " LIMIT  $limit,10 ";
        // echo "Query : ".$user_sql."<br/>";
        // echo "Counter : ".$order_count_sql."<br/>";
    } else {
        $user_sql  = "SELECT *, ( SELECT `administration_type_name_ar` FROM `administration_type_tbl`  WHERE  `administration_type_id` = `administration_tbl`.`administration_type_id`) as type_ar, ( SELECT  `administration_type_name_en` FROM `administration_type_tbl`  WHERE  `administration_type_id` = `administration_tbl`.`administration_type_id` ) as type_en  FROM `administration_tbl`  Where  `administration_tbl`.`administration_type_id` = 5  $where_sql    GROUP by   `administration_tbl`.`administration_id`  ";
        $order_count_sql = $user_sql;
        $user_sql   = $user_sql . " LIMIT  $limit,10 ";
        // echo "Query : ".$user_sql."<br/>";
    }
} else {
    $user_sql        = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` 
    WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en`
     FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en ,
     (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id` ) as user_area_id,
     (SELECT  `program_start_date`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`) ) as start_date,
     (SELECT  `program_start_end`  FROM `program_start_end_date_tbl` WHERE `user_area_id` = (SELECT max(`user_area_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`) ) as  end_date,
     (SELECT  `program_duration`  FROM `program_tbl` WHERE `program_id` =  (SELECT max(`program_id`) FROM `user_area_tbl` where `user_id`  = admin.`administration_id`)) as  program_duration
      FROM `administration_tbl` as admin Where `administration_type_id` = 5  ORDER BY `administration_id` DESC , `administration_active` DESC  LIMIT  $limit,10 ";
    $order_count_sql = "SELECT  * FROM `administration_tbl` as admin Where `administration_type_id` = 5 ";
}

$counterQuery    = mysqli_query($con, $order_count_sql);
$counter_num     = mysqli_num_rows($counterQuery);
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
            <div>
                <input id="myInput" type="text" placeholder="Search..">

                <table id="table_format" class="table table-hover">
                    <thead class=" text-primary">
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"> <?php echo $languages['area']['process']; ?></th>

                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                <?php echo $languages['area']['en_name']; ?></th>
                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                <?php echo $languages['driver']['active']; ?></th>

                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"> <?php echo $languages['table_user']['date']; ?></th>
                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"> <?php echo $languages['order']['start']; ?></th>
                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"> <?php echo $languages['order']['end']; ?></th>

                        </tr>
                    <tbody id="myTable">
                        <?php
                        while ($arr = mysqli_fetch_array($rs)) {
                            $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];
                            $active_str = "";
                            if ($arr['administration_active'] == 1) {
                                $acive = $languages['driver']['active'];
                                $hold_str = '<a  class="btn btn-warning btn-round"  data-val="'.base64_encode($arr['administration_id']).'"  data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'" > <i class="material-icons" style="margin: 0;">pause</i></a>';
                                $active_str = '<a class="btn btn-danger btn-round" data-val="'.base64_encode($arr['administration_id']).'" 
                                                                                   data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'" 
                                                                                   data-progress="'.$arr['program_duration'].'"  ><i class="material-icons" style="margin: 0;">autorenew</i></a>';

                            } else if ($arr['administration_active'] == 2) {
                                $acive = $languages['driver']['not_active'];
                                $hold_str = '<a  class="btn btn-warning btn-round"  data-val="'.base64_encode($arr['administration_id']).'"   data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'" > <i class="material-icons" style="margin: 0;">pause</i></a>';
                                $active_str = '<a class="btn btn-danger btn-round" data-val="'.base64_encode($arr['administration_id']).'" 
                                                                                    data-href="' . base64_encode(base64_encode(base64_encode($arr['user_area_id']))).'" 
                                                                                    data-progress="'.$arr['program_duration'].'"  ><i class="material-icons" style="margin: 0;">autorenew</i></a>';


                            }
                            else if ($arr['administration_active'] == 3) {
                                $acive = $languages['driver']['hold'];
                                $hold_str = '<a  class="btn btn-success btn-round" data-val="'.$arr['administration_id'].'" 
                                                                                   data-href="' .$arr['user_area_id'].'" 
                                                                                   data-progress="'.$arr['program_duration'].'" > 
                                                                                   <i class="material-icons" style="margin: 0;">done_all</i></a>';

                            }
 
                            echo '<tr>
                            <td class="td-actions"> 
                            <a href="dashboard.php?type=update_address&&id='.base64_encode($arr['user_area_id']).'&&user_id='.base64_encode($arr['administration_id']).'" class="btn btn-success btn-round"> <i class="material-icons" style="margin: 0;">edit</i></a>
   
                            <a href="dashboard.php?type=user_detials&&id='.base64_encode($arr['administration_id']).'" class="btn btn-info btn-round"> <i class="material-icons" style="margin: 0;">touch_app</i></a>
                            '.$active_str.'
                            '.$hold_str.'
                            </td>
                            <td class="sorting_1" >' . $arr['administration_name'] . '</td>
                            <td class="sorting_1" >' . $acive . '</td>
                            <td class="sorting_1" >' . $arr['administration_date_registeration'] . '</td>
                            <td class="sorting_1" >' . $arr['start_date'] . '</td>
                            <td class="sorting_1" >' . $arr['end_date'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#myInput").on("keyup", function() {
                            var value = $(this).val().toLowerCase();
                            $("#myTable tr").filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
                    $(document).ready(function() {
                        $(".btn-danger").click(function() {
                            //alert("Clicked");
                            var para = {
                                id: $(this).attr('data-val'),
                                user_area_id: $(this).attr('data-href'),
                                duration_day: $(this).attr('data-progress'),
                            };
                            console.log("here");
                            Notify.confirm({
                                title: '<?php echo $languages['order']['renew']; ?>',
                                html: '<b><?php echo $languages['order']['renew_question']; ?></b>',
                                ok: function() {
                                     $.ajax({
                                        type: 'POST',
                                        url: './ajax/renew_program_ajax.php',
                                        data: para,
                                        success: function(data) {
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
                    $(document).ready(function() {
                        $(".btn-warning").click(function() {
                            //alert("Clicked");
                            var para = {
                                id: $(this).attr('data-href'),
                                user_id: $(this).attr('data-val'),
                     
                            };
                            // console.log("here");
                            Notify.confirm({
                                title: '<?php echo $languages['order']['hold_title']; ?>',
                                html: '<b><?php echo $languages['order']['hold_que']; ?></b>',
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
                                    Notify.suc('<?php echo $languages['alert']['cancel']; ?>');
                                }
                            });
                        });
                    });
                    $(document).ready(function() {
                        $(".btn-success").click(function() {
                            //alert("Clicked");
                            var para = {
                                user_id      : $(this).attr('data-val'),
                                user_area_id : $(this).attr('data-href'),
                                duration_day : $(this).attr('data-progress'),
                            };
                            console.log(para);
                            Notify.confirm({
                                title: '<?php echo $languages['order']['unhold_title']; ?>',
                                html: '<b><?php echo $languages['order']['un_hold_que']; ?></b>',
                                ok: function() {
                                     $.ajax({
                                        type: 'POST',
                                        url: './ajax/reactive_user.php',
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
                                    Notify.suc('<?php echo $languages['alert']['cancel']; ?>');
                                }
                            });
                        });
                    });
                </script>

                <script src="../assets/js/ddtf.js"></script>
                <script>
                    jQuery('#table_format').ddTableFilter();
                </script>



            </div>
        </div>

        <?php

        //  echo $counter_num;
        if ($counter_num > 10) {
            $total_sub = round($counter_num / $num_counter1);

            echo '<div class="text-right" > <nav aria-label="Page navigation">
            <ul class="pagination pagination-primary">';

            for ($i = 0; $i < $total_sub; $i++) {
                if (!empty($_SERVER['QUERY_STRING'])) {
                    // echo isset($_GET['limit']);
                    if (isset($_GET['limit'])) {
                        $limit = "limit=" . $_GET['limit'];
                        $OrderType = explode($limit, $_SERVER['QUERY_STRING']);

        ?>
                        <li class="page-item active"><a class="page-link" href="dashboard.php?type=driver&&limit=<?php echo $i; ?><?php echo $OrderType[1]; ?>">
                                <?php echo $i + 1; ?></a></li>
                    <?php
                    } else if (!isset($_GET['limit'])) {

                    ?>
                        <li class="page-item active"><a class="page-link" href="dashboard.php?type=driver&&limit=<?php echo $i; ?>&&<?php echo $_SERVER['QUERY_STRING']; ?>">
                                <?php echo $i + 1; ?></a></li>
                    <?php
                    }
                } else {
                    ?>
                    <li class="page-item active"><a class="page-link" href="dashboard.php?type=driver&&limit=<?php echo $i; ?>">
                            <?php echo $i + 1; ?></a></li>
                <?php
                }
                ?>
        <?php
            }

            echo ' </ul>
</nav></div>';
        }
        ?>



    </div>

</div>
</div>
</div>
<?php

    }
    ?>