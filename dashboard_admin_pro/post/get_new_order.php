
<?php
  require_once '../Configuration/db.php';
  
  if (isset($_POST['view'])) {
      if ($_POST["view"] != '') {
          $update_query = "UPDATE `order_tbl` SET `order_view` = '1' ";
          mysqli_query($con, $update_query);
      }
  }
  $current_date = date("Y-m-d");
      //get counter of order doesn't seen
      $sql = "SELECT count(`order_status_id`) FROM `order_tbl` WHERE
       `order_status_id` = 1 and `order_view` = 0 ";
     // echo $sql;
      if ($result=mysqli_query($con,$sql)){
        $row = mysqli_fetch_row($result);
        $notification = $row[0];
        $data = array(
          'notification' => $notification
        );
        echo json_encode($data);;
    }


?>