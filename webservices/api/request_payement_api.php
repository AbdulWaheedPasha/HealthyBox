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
include_once '../models/User.php';
include_once '../models/Order.php';
$database = new Database();
$db       = $database->connect();
$user     = new User($db);
$order    = new Order($db);
$data     = json_decode(file_get_contents("php://input"));

if(empty($data->order_id)){
        http_response_code(401);
        echo json_encode(array("message" => "Please fill empty field"));

}else{

    $order->invoice_id       = $data->invoice_id;
    $order->status           = $data->status;
    $jwt                     = isset($data->jwt) ? $data->jwt : "";
        try {
            http_response_code(200);
            $order->invoice_id             = $data->invoice_id;
            $order->status                 = $data->status;
            $order->order_id               =  $data->order_id;
            $order->payment_process_error  =  $data->error;
            if(empty($order->payment_process_error)){
                $result = $order->update_order_payment();
            }
            $result = $order->insert_invoice();
            if($result){
                echo json_encode(array("status" => "1","message" => "order updated."));
            }else{
                 // set response code
                http_response_code(401);
                echo json_encode(array("status" => "0","message" => "Unable to update order."));
            }
                
        }catch (Exception $e){    // set response code
                http_response_code(401);
                echo json_encode(array("status" => "-1","message" => "Access denied.","error" => $e->getMessage()));
        }
}
?>