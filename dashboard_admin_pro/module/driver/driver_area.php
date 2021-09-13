<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
$id = $_SESSION['id']; 
// $update_comment_view  = "UPDATE `comment_driver_tbl` SET `comment_driver_view`= '1' WHERE `comment_driver_view` = 0 " ;
// echo $update_comment_view;
// mysqli_query($con,$update_comment_view);
$comment_query  = "SELECT `comment_driver_id`, `comment_driver_text`,(SELECT `administration_name` FROM `administration_tbl` WHERE `administration_id` = `comment_driver_driver_id`) as driver_name , `comment_driver_user_id`,(SELECT `administration_name` FROM `administration_tbl` WHERE `administration_id` = `comment_driver_user_id` ) as sub_name , `comment_driver_date` FROM `comment_driver_tbl` where  `comment_driver_driver_id` = '$id' ";
// echo $comment_query;
 mysqli_set_charset($con, "utf8");
$comment_sql = mysqli_query($con,$comment_query);
?>

          
<a href="dashboard.php?type=insert_comment_driver" class="btn btn-primary btn-round"><?php echo $languages['comment']['add']; ?><div class="ripple-container"></div></a>


<div class="col-md-12">


            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title"><?php echo $languages['comment']['comment_title']; ?></h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-hover" style="width:100%">
                
                      <thead>
                   
                        <th><?php echo $languages['comment']['username']; ?></th>
                        <th><?php echo $languages['comment']['date']; ?></th>
                        <th><?php echo $languages['comment']['comment_title']; ?></th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php
while ($arr = mysqli_fetch_array($comment_sql)) {
    // print_r($arr);
    ?>
    <tr>
      <td><?php echo  $arr['sub_name']; ?></td>
      <td><?php echo  $arr['comment_driver_date']; ?></td>
      <td><a href="dashboard.php?type=view_comment&&comment_id=<?php echo base64_encode($arr['comment_driver_id']); ?>"  class="btn btn-primary btn-round"><i class="material-icons" style="margin: 0;">visibility</i></a>
</td>
     
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