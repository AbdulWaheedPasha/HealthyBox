<?php
// required headers
header("Access-Control-Allow-Origin: *");
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
$data     = json_decode(file_get_contents("php://input"));
$token_username      = isset($data->token_username) ? $data->token_username : "";
$token_password      = isset($data->token_password) ? $data->token_password : "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($token_username) && !empty($token_password)){
            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
                'data' => [                  // Data related to the signer user
                    'token_username'   => base64_encode(base64_encode(base64_encode(base64_encode($token_username)))), 
                    'token_password'   => base64_encode(base64_encode(base64_encode(base64_encode($token_password)))), 
                ]
            ];
            http_response_code(200);
            $jwt = JWT::encode($data,$secretKey, 'HS512');
         
            echo json_encode(array("status" => "1","jwt"=> $jwt,"message"=>"Succssfully Token"));
    }else{
        http_response_code(401);
        echo json_encode(array("status" => "0","message"=> "No Useranem and password to create token"));
    }
}else{
    http_response_code(401);
    echo json_encode(array("status" => "0","message"=> "Method wasn't Post"));
}
    ?>