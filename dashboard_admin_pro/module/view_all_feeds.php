<!-- view_all_comments -->
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

$comment_query  = "SELECT `feed_id`, `feed_name`, `feed_title`, `feed_message` FROM `feed_tbl` ";
// echo $comment_query;
 mysqli_set_charset($con, "utf8");
$comment_sql = mysqli_query($con,$comment_query);
?>

          


<div class="col-md-12">


            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title"><?php echo $languages['feed']['title']; ?></h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-hover" style="width:100%">
                
                      <thead>
                        <th><?php echo $languages['feed']['table_first_row']; ?></th>
                        <th><?php echo $languages['feed']['table_second_row']; ?></th>
                        <th><?php echo $languages['feed']['table_third_row']; ?></th>
                  
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php
while ($arr = mysqli_fetch_array($comment_sql)) {
    // print_r($arr);
    ?>
    <tr>
      <td><?php echo  $arr['feed_name']; ?></td>
      <td><?php echo  $arr['feed_title']; ?></td>
 
      <td><a href="dashboard.php?type=feed_detials&&feed_id=<?php echo base64_encode($arr['feed_id']); ?>"  class="btn btn-primary btn-round"><i class="material-icons" style="margin: 0;">visibility</i></a>
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