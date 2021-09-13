<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if(isset($_GET)){
if(isset($_GET['comment_id'])){
$comment_id = base64_decode($_GET['comment_id']);


$comment_query  = "SELECT `comment_driver_id`, `comment_driver_text`,(SELECT `administration_name` FROM `administration_tbl` WHERE `administration_id` = `comment_driver_driver_id`) as driver_name , `comment_driver_user_id`,(SELECT `administration_name` FROM `administration_tbl` WHERE `administration_id` = `comment_driver_user_id` ) as sub_name , `comment_driver_date` FROM `comment_driver_tbl` where  `comment_driver_id` = $comment_id";
// echo $comment_query;
 mysqli_set_charset($con, "utf8");
$comment_sql = mysqli_query($con,$comment_query);
?>


          


<div class="col-md-12">


            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title "><?php echo $languages['comment']['comment']; ?></h4>
               
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table  class="table table-hover" style="width:100%">
                
                <thead>
                  <th><?php echo $languages['comment']['driver_name']; ?></th>
                  <th><?php echo $languages['comment']['username']; ?></th>
                  <th><?php echo $languages['comment']['date']; ?></th>
                 
                </tr>
              </thead>
              <tbody>
              <?php
while ($arr = mysqli_fetch_array($comment_sql)) {
// print_r($arr);
?>
<tr>
<td><?php echo  $arr['driver_name']; ?></td>
<td><?php echo  $arr['sub_name']; ?></td>
<td><?php echo  $arr['comment_driver_date']; ?></td>


</tr>
<tr>
<td colspan="4"><?php echo $languages['comment']['comment']; ?> : <?php echo  $arr['comment_driver_text']; ?></td>


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

                    }

                  }
                    ?>
