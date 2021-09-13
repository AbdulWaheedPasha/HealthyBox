<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Area.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $area = new Area($db);
  $data = json_decode(file_get_contents("php://input"));

  $area->area_id = $data->area_id;
  // Category read query
  $result = $area->getArea();
  
  // Get row count
  $num = mysqli_num_rows($result);
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
        $cat_arr['area_info'] = array();
        while($row = mysqli_fetch_assoc($result)) {
   
           $cat_item = array(
            'area_id'            =>  $row['area_id'],
            'area_name_ar'       => $row['area_name_ar'],
            'area_name_eng'      => $row['area_name_eng'],
            'area_cost_delivery' => $row['area_cost_delivery']
          );
          // Push to "data"
          array_push($cat_arr['area_info'], $cat_item);
        }
        // Turn to JSON & output
        echo json_encode($cat_arr);
  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Categories Found')
        );
  }
  ?>