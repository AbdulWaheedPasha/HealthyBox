<?php

include_once '../models/JWT.php';
include_once '../models/BeforeValidException.php';
include_once '../models/ExpiredException.php';
include_once '../models/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

include_once '../config/Database.php';
include_once '../models/Payment.php';
include_once '../config/core.php';
$database = new Database();
$db = $database->connect();
$payment = new Payment($db);
$data = json_decode(file_get_contents("php://input"));
$jwt = isset($data->jwt) ? $data->jwt : "";
if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $payment->order_number = $data->order_number;
        $payment->user_id      = $data->user_id;
        $payment->area_id      = $data->area_id;
        if ($payment->insertNewOrder()) {
            if (count($data->order) > 0) {
                for ($i=0;$i<count($data->order);$i++) {
                    //$data->order[$i]->product_id
                    $payment->order_lists_amount = $data->order[$i]->order_lists_amount;
                    $payment->product_id         = $data->order[$i]->product_id;
                    $payment->product_price      = $data->order[$i]->product_price;
                    $payment->insertOrderItem();
                }
                echo json_encode(
                    array(
                        "message" => "Insert New order was successfully.",
                    )
                );
            }else{
                http_response_code(401);
                echo json_encode(array("message" => "Unable to insert order."));  
            }
         
        
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Unable to insert order."));
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}

?>