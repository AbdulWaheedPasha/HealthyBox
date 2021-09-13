<?php
header("Access-Control-Allow-Origin: ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config/Database.php';
include_once '../models/User.php';
            $database = new Database();
$db       = $database->connect();
$user     = new User($db);

if (isset($_SERVER['REQUEST_METHOD'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        try {
            $data = json_decode(file_get_contents("php://input"));
            $token = JWT::decode($data->jwt, $secretKey, array('HS512'));
            http_response_code(200);


            if( empty($data->user_email)         &&
                empty($data->user_old_password)  &&
                empty($data->user_new_password)  &&
                empty($data->user_id)            &&
                empty($data->jwt) ){
                
                http_response_code(401);
                echo json_encode(array("message" => "Please fill empty field","status" => "0"));

}else{
    if($data->user_old_password == $data->user_new_password ){
              http_response_code(401);
              echo json_encode(array("status" => "2","message" => "old password was the same for new password."));
          }else{
            http_response_code(200);
            // decode jwt
           
            $user->user_email           = base64_encode(base64_encode(base64_encode(base64_encode($data->user_email))));
            $user->user_password        = base64_encode(base64_encode(base64_encode(base64_encode($data->user_old_password))));
         
            $user->user_id             = $data->user_id;
            $jwt                       = isset($data->jwt) ? $data->jwt : "";
           

            if($user->password_verify() > 0){
                $user->user_password        = base64_encode(base64_encode(base64_encode(base64_encode($data->user_new_password))));

                if ($user->updatePassword()) {
                
                    // get data after updateing
                    $result = $user->getUser();
                    $user_info = array();
                    while ($user_row = mysqli_fetch_assoc($result)) {
    
                        $data = [
                            'iat'  => $issuedAt,         // Issued at: time when the token was generated
                            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                            'iss'  => $serverName,       // Issuer
                            'nbf'  => $notBefore,        // Not before
                            'exp'  => $expire,           // Expire
                            'data' => [                  // Data related to the signer user
                                'token_username'   => base64_encode(base64_encode(base64_encode(base64_encode($user_email)))), 
                                'token_password'   => base64_encode(base64_encode(base64_encode(base64_encode($user_password)))), 
                            ]
                        ];
                        http_response_code(200);
                        $jwt = JWT::encode($data,$secretKey, 'HS512');
    
    
                        $user_info = array(
                            "user_id"        =>  $user_row['administration_id'],
                        "user_email"     =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_username'])))),
                        "user_password"  =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_password'])))),
                     
                        );
                        // print_r($user_info);
                    }
                
                    echo json_encode(
                    array(
                              "status" => "1",
                                "message"  => "User was updated.",
                                 "jwt"     => $jwt
                             )
                         );
                }// message if unable to update user
                else {
                    http_response_code(401);
                    echo json_encode(array("status" => "0","message" => "Unable to update user."));
                }
            }else{
                    http_response_code(401);
                    echo json_encode( array("status" => "0","message" => "User was incorrect password",));
            }
          }
    }
            



		} catch (Exception $e) {
            http_response_code(401);
            echo json_encode(array("state"   => "0","message" => "Access denied.", "error" => $e->getMessage()));
		}
	}else {
        http_response_code(401);
        echo json_encode(array("state"   => "0","message" => "Access denied."));
	}
} else {
    http_response_code(401);
    echo json_encode(array("state" => "0","message" => "REQUEST METHOD wasn't found."));
}

?>