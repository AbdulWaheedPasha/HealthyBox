<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $category = new Category($db);
  $data = json_decode(file_get_contents("php://input"));

  $category->level = $data->level;
  // Category read query
  $result = $category->getCategory();
  
  // Get row count
  $num = mysqli_num_rows($result);
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
        $cat_arr['category_item'] = array();
        while($row = mysqli_fetch_assoc($result)) {
   
           $cat_item = array(
            'category_id' =>  $row['category_id'],
            'category_icon' => $row['category_icon'],
            'category_title_ar' => $row['category_title_ar'],
            'category_title_en' => $row['category_title_en']
          );
          // Push to "data"
          array_push($cat_arr['category_item'], $cat_item);
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