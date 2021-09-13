<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// generate json web token
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';
use \Firebase\JWT\JWT;


// database connection will be here
// files needed to connect to database
include_once '../config/Database.php';
include_once '../models/Order.php';
function areSame($arr){ 
    $first = $arr[0];
    for ($i=1;$i<count($arr);$i++){
        if ($arr[$i] != $first) 
                return false; 
    }
       return true; 
} 

$database = new Database();
$db       = $database->connect();
$order     = new Order($db);
$data     = json_decode(file_get_contents("php://input"));
 
// get jwt
$jwt                        = isset($data->jwt) ?    $data->jwt : "";
$order->area_id             = isset($data->area_id)? $data->area_id: "" ;
$order->order_number        = $order->generateRandomString();
$order->branch_id           = "2";
$order->order_created_at    = isset($data->order_date) ? $data->order_date : "";
$order->order_time          = isset($data->order_time) ? $data->order_time : "";
$order->user_id             = isset($data->client_id) ?  $data->client_id : "";
$order->payment_status_id   = isset($data->payment_status_id) ? $data->payment_status_id : "";
$order->driver_notes        =  "";
$order->kitchan_notes       =  "";
$order->card_notes          =  "";
$order->user_address        = isset($data->client_address) ? $data->client_address : "";
$product_info               = array($data->product_info);
if(  $jwt && !empty($order->order_number)
          && !empty($order->order_created_at)
          && !empty($order->payment_status_id) 
          && !empty($order->user_id)
          && !empty($order->area_id) 
          && !empty($order->user_address) ){

    try{
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        // set response code
        http_response_code(200);
        if(!empty($data->client_address)){
           
            $order->update_address_customer();
        }
        if($order->payment_status_id == 1) {
            $order->AddNewOrder();
        }else if($order->payment_status_id == 2){
            $order->AddNewOrderStillPayemnt();
            
        }
      
        $order->order_id = $order->getLastOrderID();
        //print_r($order->order_id);
        $order->AddUserOrder(); 
        // insert product to OrderList
      
        for($i=0;$i<count($product_info[0]);$i++){
            //add product id to order 
            $order->product_id      = $product_info[0][$i]->product_id;   
            $order->product_price   = $product_info[0][$i]->product_price; 
            $order->product_qty     = $product_info[0][$i]->product_quantity;
            $order->order_lists_id  = $order->InsertProducOrderList();
        }
        http_response_code(200);
      
            echo json_encode(array("message" => "Order was Inserted",
                    "order_num" => $order->order_number,
                    "delivery_time"=>$order->getDeliveryTimeTbl()));
     
 
    }catch (Exception $e){
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied  & show error message
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}
 
 
}
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
