<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../config/Database.php';
include_once '../models/OrderLists.php';
include_once '../models/Product.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();



// generate json web token
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';
use \Firebase\JWT\JWT;



// order lists
$orderlist = new OrderLists($db);
$data = json_decode(file_get_contents("php://input"));
$orderlist->order_id = $data->order_id;
$jwt=isset($data->jwt) ? $data->jwt : "";
// Category read query
// if jwt is not empty
if($jwt && !empty($orderlist->order_id)){
 
  // if decode succeed, show user details
  try{
      // decode jwt
      $decoded = JWT::decode($jwt, $key, array('HS256'));


      $result = $orderlist->getOrderDetialsByOrderID();
// Get row count
$num = mysqli_num_rows($result);
// Check if any categories
if ($num > 0) {
    // // Cat array
    $cat_arr = array();
    $cat_arr['order_list'] = array();
    while ($row = mysqli_fetch_assoc($result)) {
        //`order_number`, `order_created_at`, `order_status_id`
        $temp["orders"] = array('order_id' => $row['order_id'], 
                          'order_number' => $row['order_number'],
                          'order_created_at' => $row['order_created_at'], 
                          'order_status_id' => $row['order_status_id'], 
                          'order_status_name'    => $row['order_status_name'], 
                          'order_status_en_name' => $row['order_status_en_name'],
                          'order_time'            => $row['order_time']);
    $orderlist->order_id = $data->order_id;
    $orderlist_result = $orderlist->getOrderlistsByOrderID();
    }
      // get product name
      while ($rowList = mysqli_fetch_assoc($orderlist_result)) {

        //get image for product
        $product = new Product($db);
        $product->product_id = $rowList['product_id'];
        $img_path = "";
        $image_result = $product->getImageProduct();
        while($img_row = mysqli_fetch_assoc($image_result)){
            $img_path = $img_row['photos_large_path'];
          }
        $product_arr["product"] = array('product_img'      => $img_path , 
                                        'product_title_ar' => $rowList['product_title_ar'], 
                                        'product_title_en' => $rowList['product_title_en'],
                                        'product_qty'      => $rowList['order_lists_amount'],
                                        'product_price'    => $rowList['product_price']
                                      );
         $temp["product_List"][] = $product_arr;
    }
    $jsonArray["order_list"][] = $temp;
    // Turn to JSON & output
        // set response code
        http_response_code(200);
    echo json_encode($jsonArray);
} else {
    // set response code
    http_response_code(200);
    // No Categories
    echo json_encode(array('message' => 'No Orders was Found'));
}



  }catch (Exception $e){

  // set response code
  http_response_code(401);

  // tell the user access denied  & show error message
  echo json_encode(array(
      "message" => "Access denied.",
      "error" => $e->getMessage()
  ));
}

  // catch will be here
}// show error message if jwt is empty
else{

  // set response code
  http_response_code(401);

  // tell the user access denied
  echo json_encode(array("message" => "Access denied."));
}
