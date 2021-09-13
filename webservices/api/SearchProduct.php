<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../config/Database.php';
  include_once '../models/SearchProduct.php';
  $database = new Database();
  $db = $database->connect();
  $search_product = new SearchProduct($db);
  $data = json_decode(file_get_contents("php://input"));
  $search_product->product_name = $data->product_name;
  $search_product->limit        = $data->limit;
  $result = $search_product->getProductSearchByName();
  $num = mysqli_num_rows($result);
  // Check if any categories
  if($num > 0) {
        // // Cat array
        $cat_arr = array();
        $cat_arr['product_item'] = array();
        while($row = mysqli_fetch_assoc($result)) {
          $cat_item = array(
            'product_id'        => $row['product_id'],
            'product_title_ar'  => $row['product_title_ar'],
            'product_title_en'  => $row['product_title_en'],
            'product_price'     => $row['product_price'],
            'product_discount'  => $row['product_discount']
          );
          // Push to "data"
          array_push($cat_arr['product_item'], $cat_item);
        }
        // Turn to JSON & output
        echo json_encode($cat_arr);
  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Result Found')
        );
  }
  ?>