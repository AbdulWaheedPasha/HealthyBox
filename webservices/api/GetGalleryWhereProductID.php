<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../config/Database.php';
  include_once '../models/Slider.php';
  include_once '../models/Product.php';
  $database = new Database();
  $db = $database->connect();
  // get data from request
  $slider  = new Slider($db);
  $product  = new Product($db);
  $data = json_decode(file_get_contents("php://input"));
  $slider->product_id  = $data->product_id;
  $product->product_id = $data->product_id;
  $result         = $slider->getProdcutImages();
  $product_result = $product->getProductWhereProductID();
  if(mysqli_num_rows($product_result) > 0) {
    $cat_arr = array();
    $cat_arr['product_info'] = array();
    $cat_arr['slider']       = array();
 
    while($row_photos = mysqli_fetch_assoc($product_result)) {
      $cat_item = array(
       'product_id'             => $row_photos['product_id'],
       'product_title_en'       => $row_photos['product_title_en'],
       'product_title_ar'       => $row_photos['product_title_ar'],
       'product_description_en' => $row_photos['product_description_en'],
       'product_description_ar' => $row_photos['product_description_ar'],
       'product_price'          => $row_photos['product_price'],
       'product_discount'       => $row_photos['product_discount'],
     );
     array_push($cat_arr['product_info'], $cat_item);
   }

   while($row_photos = mysqli_fetch_assoc($result)) {
    $cat_item = array(
     'photos_id'    => $row_photos['photos_id'],
     'photos_path'  => $row_photos['photos_large_path']
   );
   array_push($cat_arr['slider'], $cat_item);
 }
   
      
     echo json_encode($cat_arr);
  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Images Found')
        );
  }
  ?>