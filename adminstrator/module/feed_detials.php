<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if(isset($_GET)){
if(isset($_GET['feed_id'])){
$comment_id = base64_decode($_GET['feed_id']);


$comment_query  = "SELECT `feed_id`, `feed_name`, `feed_title`, `feed_message` FROM `feed_tbl` WHERE `feed_id` =  $comment_id order by `feed_id` DEC";
// echo $comment_query;
 mysqli_set_charset($con, "utf8");
$comment_sql = mysqli_query($con,$comment_query);
?>


          


<div class="col-md-12">
<?php
while ($arr = mysqli_fetch_array($comment_sql)) {
// print_r($arr);
?>

            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title "><?php echo $arr['feed_name']; ?></h4>
               
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table  class="table table-hover" style="width:100%">
                
                <thead>
                <th><?php echo $languages['feed']['table_second_row']; ?></th>
                <th>
                <?php echo $languages['feed']['table_first_row']; ?></th>
                  
                    
                 
                </tr>
              </thead>
              <tbody>
   
<tr>
<td><?php echo  $arr['feed_name']; ?></td>
      <td><?php echo  $arr['feed_title']; ?></td>


</tr>

            

               
              </tbody>
            </table>
            <?php echo $languages['feed']['table_third_row']; ?> :  <?php echo $arr['feed_message']; ?>
                </div>
 
                
              </div>
            </div>
          </div>

          <?php

}
?>
<?php
}

                    }

                  }
                    ?>
