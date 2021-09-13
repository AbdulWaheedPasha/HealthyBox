<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

$id = $_SESSION['id']; 
// $update_comment_view  = "UPDATE `comment_driver_tbl` SET `comment_driver_view`= '1' WHERE `comment_driver_view` = 0 " ;
// echo $update_comment_view;
// mysqli_query($con,$update_comment_view);
$comment_query = "SELECT DISTINCT
                            `capital_tbl`.`capital_en_title`,
                            `capital_tbl`.`capital_ar_title`,
                            `capital_tbl`.`capital_id`
                            FROM
                            `capital_tbl`
                            INNER JOIN `driver_capital_tbl` ON `driver_capital_tbl`.`capital_id` = `capital_tbl`.`capital_id`
                            WHERE
                            `driver_capital_tbl`.`driver_id` = $_SESSION[id]  ";
                                           //echo $comment_query;
 mysqli_set_charset($con, "utf8");
$comment_sql = mysqli_query($con,$comment_query);
?>

          


<div class="col-md-12">


            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title"><?php echo $languages['area']['title']; ?></h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-hover" style="width:100%">
                
                      <thead>
                        <th><?php echo $languages['area']['en_name']; ?></th>
                        <th><?php echo $languages['area']['ar_name']; ?></th>

                        <th><?php echo $languages['area']['process']; ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
while ($arr = mysqli_fetch_array($comment_sql)) {
   // print_r($arr);
    ?>
    <tr>
      <td><?php echo  $arr['capital_en_title']; ?></td>
      <td><?php echo  $arr['capital_ar_title']; ?></td>
      <td><a href="dashboard.php?type=view_order_daily&&pro_id=<?php echo base64_encode($arr['capital_id']); ?>" class="btn btn-primary btn-round  btn-fab"><i class="material-icons" style="margin: 0;">visibility</i><div class="ripple-container"></div></a></td>
     
    </tr>
                  
    <?php
  
}
?>
                     
                    </tbody>
                  </table>
                </div>
 
                
              </div>
            </div>
          </div>

<?php
}
?>