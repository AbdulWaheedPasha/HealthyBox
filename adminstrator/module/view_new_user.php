<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if ($_SESSION['role_id'] == "1") {
?>
    <div class="row">
        <div class="col">
            <a href="dashboard.php?type=new_subscriber" class="btn btn-primary btn-round"><?php echo $languages['sub']['add']; ?><div class="ripple-container"></div></a>

        </div>
    </div><br />
<?php
}
?>

<?php
//view_all_subscriber
$user_sql  = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` 
                        WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en`
                        FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en 

                        FROM `administration_tbl` as admin Where `administration_type_id` = 5 and `administration_active` = 4   ORDER BY `administration_id` DESC , `administration_active` DESC  ";


// echo $user_sql;

// Change character set to utf8
mysqli_set_charset($con, "utf8");
$rs = mysqli_query($con, $user_sql);
$all_num_rows = mysqli_num_rows($rs);

?>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>


<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['menu_item']['subs']; ?></h4>
            <p class="card-category"><?php echo $languages['sub']['describe']; ?></p>
        </div>
        <div class="card-body">



            <table id="example" class="display" style="width:100%">
                <thead>

                <th>
                        <?php echo $languages['driver']['code']; ?></th>
                    <th><?php echo $languages['area']['en_name']; ?></th>
                       

                    <th> <?php echo $languages['table_user']['date']; ?></th>
                    
                    

                    <th class="text-align:center"> <?php echo $languages['area']['process']; ?></th>

                </thead>
                <tbody>
                    <?php
                    while ($arr = mysqli_fetch_array($rs)) {
                        $type = ($_SESSION['lang'] == "en") ? $arr['type_en'] : $arr['type_ar'];
                        $active_str = "";
                        $hold_str  = "";
                        $acive = "";
                   
                        echo '<tr><td>'.$arr['administration_id'].'</td>
                                  <td>'.$arr['administration_name'].'</td>
                                  <td>'.$arr['administration_date_registeration'].'</td>';
                        echo ' <td> ';
                        if ($_SESSION['role_id'] == "1") {
                            echo '<a href="dashboard.php?type=new_user_detials&&id=' . base64_encode($arr['administration_id']) . '" class="btn btn-success btn-round btn-fab"> <i class="material-icons" style="margin: 0;">edit</i></a> 
                               ' .$active_str . $hold_str;
                        }

                   
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