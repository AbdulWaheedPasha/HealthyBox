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


// // database connection will be here
// // files needed to connect to database
// include_once '../config/Database.php';
// include_once '../models/Payment_Method.php';


// $database                      = new Database();
// $db                            = $database->connect();
// $payment                       = new Payment_Method($db);
// $data                          = json_decode(file_get_contents("php://input"));
// $payment->payment_date         = $data->payment_date;
// $payment->payment_type_text    = $data->payment_type_text;
// $payment->order_id             = $data->order_id;
// $payment->paymentId            = $data->paymentId;
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->payment_date)){
// set response code
http_response_code(200);

$token = array(
    "iss" => $iss,
    "aud" => $aud,
    "iat" => $iat,
    "nbf" => $nbf,
    "data" => array(
        $data->payment_date,
    )
 );
 
// generate jwt
$jwt = JWT::encode($token, $key);
echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );




}else{
     // set response code
     http_response_code(401);
 
     // tell the user login failed
     echo json_encode(array("message" => "Login failed.")); 
}
  

?>
