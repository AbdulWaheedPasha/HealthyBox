<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/OrderLists.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $orderlist = new OrderLists($db);
  $data = json_decode(file_get_contents("php://input"));

  $orderlist->user_id = $data->user_id;
  // Category read query
  $result = $orderlist->getOrderList();
  
  // Get row count
  $num = mysqli_num_rows($result);
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
       
        while($row = mysqli_fetch_assoc($result)) {
   //`order_number`, `order_created_at`, `order_status_id`
           $cat_item = array(
            'order_id'      =>  $row['order_id'],
            'order_number'      =>  $row['order_number'],
            'order_created_at'  => $row['order_created_at'],
            'order_status_id'   => $row['order_status_id'],
            'order_status_name' => $row['order_status_name'],
            'order_status_en_name' => $row['order_status_en_name'],
            'order_time'        => $row['order_time']
          );
          // Push to "data"
         $cat_arr[] = $cat_item;
        }
        // Turn to JSON & output
        $order_arr  = array('message' => 'Orders was Found');
        $order_arr['order_items']   = $cat_arr;
        echo json_encode($order_arr);
  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Orders was Found')
        );
  }
  ?>