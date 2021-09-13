<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Product.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate category object
  $product = new Product($db);
  $data = json_decode(file_get_contents("php://input"));
  $product->limit       = $data->limit;
  $product->category_id = $data->category_id;
 
  // Category read query
  $result = $product->getProductWhereCategoryID();
  
  // Get row count
  $num = $product->getProductCountWhereCategoryID();
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
        $cat_arr['product_item'] = array();
        while($row = mysqli_fetch_assoc($result)) {
          $product->product_id = $row['product_id'];
          $image_result = $product->getImageProduct();
          $img_path = "";
          while($img_row = mysqli_fetch_assoc($image_result)){
            $img_path = $img_row['photos_large_path'];
          }
          $product_discount = $row['product_discount'];
          // if($product_discount == "0."){

          // }

          
           $cat_item = array(
            'product_id'        => $row['product_id'],
            'product_title_ar'  => $row['product_title_ar'],
            'product_title_en'  => $row['product_title_en'],
            'product_price'     => $row['product_price'],
            'product_discount'  => $row['product_discount'],
            'product_img'       => $img_path 
          );
          // Push to "data"
          array_push($cat_arr['product_item'], $cat_item);
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