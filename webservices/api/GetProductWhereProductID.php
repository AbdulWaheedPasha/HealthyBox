<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Product.php';
  include_once '../models/Photos.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $product = new Product($db);
  $photos  = new Photos($db);
  $data = json_decode(file_get_contents("php://input"));
  $product->product_id = $data->product_id;
  $photos->product_id =  $data->product_id;

  // Category read query
  $result        = $product->getProductWhereProductID();
  $result_photos = $photos->getImageProductWhereProductID();

  // Get row count
  $num = mysqli_num_rows($result);
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
        $cat_arr['product_details']  = array();
        $cat_arr['product_images'] = array();
        while($row = mysqli_fetch_assoc($result)) {
           $cat_item = array(
            'product_id'        => $row['product_id'],
            'product_title_ar'  => $row['product_title_ar'],
            'product_title_en'  => $row['product_title_en'],
            'product_price'     => $row['product_price'],
            'product_discount'  => $row['product_discount'],
            'product_code'      => $row['product_code'],
            'product_description_en'  => $row['product_description_en'],
            'product_description_ar'     => $row['product_description_ar'],
            'product_specifications_en'  => $row['product_specifications_en'],
            'product_specifications_ar'  => $row['product_specifications_ar']
            
          );
          // Push to "data"
          array_push($cat_arr['product_details'], $cat_item);
        }

       
        
        while($row_photos = mysqli_fetch_assoc($result_photos)) {
          $cat_item = array(
           'photos_id'    => $row_photos['photos_id'],
           'photos_path'  => $row_photos['photos_path']
         );
         // Push to "data"
         array_push($cat_arr['product_images'], $cat_item);
       }
        // Turn to JSON & output
        echo json_encode($cat_arr);
  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Product Found')
        );
  }
  ?>