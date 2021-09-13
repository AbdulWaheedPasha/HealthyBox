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
$db       = $database->connect();
$payment     = new Payment($db);
$data     = json_decode(file_get_contents("php://input"));
$jwt      = isset($data->jwt) ? $data->jwt : "";

if($jwt){
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $payment->area_id     = $data->area_id;
        $result = $payment->getAreaCostDelivery();
        $cat_arr = array();
        $cat_arr['area'] = array();
        
        while($row = mysqli_fetch_assoc($result)) {
   
           $cat_item = array(
            'area_cost_delivery'        => $row['area_cost_delivery']
          );
          // Push to "data"
          array_push($cat_arr['area'], $cat_item);
        }
        // Turn to JSON & output
        echo json_encode($cat_arr);
      
    }
    catch (Exception $e){    
    http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}

}
else{

    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}

?>