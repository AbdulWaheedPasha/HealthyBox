<?php

include_once '../models/JWT.php';
include_once '../models/BeforeValidException.php';
include_once '../models/ExpiredException.php';
include_once '../models/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

include_once '../config/Database.php';
include_once '../models/User.php';
include_once '../config/core.php';
$database = new Database();
$db       = $database->connect();
$user     = new User($db);
$data     = json_decode(file_get_contents("php://input"));
$jwt      = isset($data->jwt) ? $data->jwt : "";
 // if jwt is not empty
if($jwt){
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $user->user_token_device     = $data->user_token_device;
        $user->user_id               = $data->user_id;
      
            // create the product
            if ($user->updateTokenUserDevice()) {
                echo json_encode(
                    array(
                       "message" => "Token was Updated."
                    )
                );
              
                
               
            }
        
            // message if unable to update user
            else {
                // set response code
                http_response_code(401);
        
                // show error message
                echo json_encode(array("message" => "Unable to update Token."));
            }
     
 
        // set user property values here
    }// if decode fails, it means jwt is invalid
    catch (Exception $e){    // set response code
    http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}
 
    // catch failed decoding will be here
}// show error message if jwt is empty
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}

?>