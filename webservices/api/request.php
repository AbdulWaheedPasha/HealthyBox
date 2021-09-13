<?php
// required headers
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/Database.php';
include_once '../models/Order.php';
if (!empty(file_get_contents("php://input"))) {
    $database = new Database();
    $db       = $database->connect();
    $order     = new Order($db);
    $data     = json_decode(file_get_contents("php://input"));
    $product_info = array($data->product_info);
    $total_price = 0 ;
    // get brand id
    $branch_array = array();
    if (count($product_info) > 0) {
        for ($i=0;$i<count($product_info[0]);$i++) {
            //add product id to order
            $additonsArray = array($product_info[0][$i]->additions_items);
            $total_price     = $product_info[0][$i]->product_price;
            for ($item=0;$item<count($additonsArray[0]);$item++) {
                $order->additions_item = $additonsArray[0][$item]->additions_item_id;
                $total_price = $order->get_price_field() +  $total_price;
            }
        }
        echo json_encode(array("price" => ".$total_price."));
    }
}else{
    echo json_encode(array("price" => "0"));
}








?>
