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
if (isset($_SERVER['REQUEST_METHOD'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $data = json_decode(file_get_contents("php://input"));
        if( empty($data->user_email)     &&
            empty($data->user_password)  &&
            empty($data->user_telep)     &&
            empty($data->user_id)        &&
            empty($data->jwt)   ){
                http_response_code(401);
                echo json_encode(array("status" => "0","message" => "Please fill empty field"));
           }else{
               try{
                   
              
                   $token    = JWT::decode($data->jwt, $secretKey, array('HS512'));

                   http_response_code(200);
                   include_once '../config/Database.php';
                   include_once '../models/User.php';
                   $database = new Database();
                   $db       = $database->connect();
                   $user     = new User($db);
              
                   $user->user_image_path       = $data->user_image_path;
                   $user->user_name             = $data->user_name;
                   $user->user_email            = base64_encode(base64_encode(base64_encode(base64_encode($data->user_email))));
                   $user->user_password         = base64_encode(base64_encode(base64_encode(base64_encode($data->user_password))));
                   $user->user_telep            = $data->user_telep;
                   $user->user_another_telep    = $data->user_another_telep;
                   $user->user_id               = $data->user_id;
                   $jwt                         = $data->jwt;
                   $user->gender                = $data->user_gender;
                   $user->age                   = $data->user_age;
                   $user->tall                  = $data->user_tall;
                   $user->weight                = $data->user_weight;
                   $user->motivation            = $data->user_motivation;
                   $user->goal_weight           = $data->user_goal_weight;
                   $user->firebase              = $data->user_firebase;
                   
                        if ($user->searchUser() > 0) {
                                if ($user->updateUser()) {
                                    $result = $user->getUser();
                                    $user_info = array();
                                    while ($user_row = mysqli_fetch_assoc($result)) {
                                        
                                       
                    
                    
                                        $user_info = array(
                                            "user_image_path"      =>  $user_row['administration_profile'],
                                            "user_id"              =>  $user_row['administration_id'],
                                            "user_name"            =>  $user_row['administration_name'],
                                            "user_email"           =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_username'])))),
                                            "user_password"        =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_password'])))),
                                            "user_telep"           =>  $user_row['administration_telephone_number'],
                                            "user_another_telep"   =>  $user_row['administration_telephone_number1'],
                                            "user_gender"          => $user_row['administration_gender_type'],
                                            "user_age"             => $user_row['administration_age'],
                                            "user_tall"            => $user_row['administration_tall'],
                                            "user_weight"          => $user_row['administration_weight'],
                                            "user_motivation"      => $user_row['administration_motivation'],
                                            "user_goal_weight"     => $user_row['administration_goal_weight'],
                                            "user_firebase"        => $user_row['administration_firebase'],
                                        );
                                        //print_r($user_info);
                                    }
                                    $data = [
                                        'iat'  => $issuedAt,         // Issued at: time when the token was generated
                                        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                                        'iss'  => $serverName,       // Issuer
                                        'nbf'  => $notBefore,        // Not before
                                        'exp'  => $expire,           // Expire
                                        'data' => [                  // Data related to the signer user
                                            'token_username'   => base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_username'])))), 
                                            'token_password'   => base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_password'])))), 
                                        ]
                                    ];
                                    http_response_code(200);
                                    $jwt = JWT::encode($data,$secretKey, 'HS512');
                                    echo json_encode(
                                    array(
                                                "status" => "1",
                                                "message"  => "User was updated.",
                                                "user"    => $user_info,
                                                "jwt"     => $jwt
                                            )
                                        );
                                }else {
                                    http_response_code(401);
                                    echo json_encode(array("status" => "0","message" => "Unable to update user."));
                                }
                    }else{
                        http_response_code(401);
                        echo json_encode(array("status" => "0","message" => "No User was Found with this data"));
                
                    }

               } catch (Exception $e) {
                    http_response_code(401);
                    echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
               }

            }

	}else {
        http_response_code(401);
        echo json_encode(array("message" => "Access denied."));
	}
} else {
    http_response_code(401);
    echo json_encode(array("state"   => "0","message" => "REQUEST METHOD wasn't found."));
}

?>