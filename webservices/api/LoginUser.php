<?php

header("Access-Control-Allow-Origin: ");
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
JWT::$leeway = 5; // Allows a 5 second tolerance on timing checks

if (isset($_SERVER['REQUEST_METHOD'])) {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if ($_SERVER['HTTP_AUTHORIZATION'] != "") {
			if ($_SERVER['HTTP_AUTHORIZATION']) {
				try {
					// $arr = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
					// $token = JWT::decode($arr[1], $secretKey, array('HS512'));
        // set response code
                    http_response_code(200);
                    // get posted data
include_once '../config/Database.php';
include_once '../models/User.php';
include_once '../models/Area.php';

$database = new Database();
$db       = $database->connect();
$user     = new User($db);
$area     = new Area($db);
$data = json_decode(file_get_contents("php://input"));

if (empty($data->user_email) && empty($data->user_password)) {
    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied.",  "status" => "0"));
} else {
    $user->user_email        = isset($data->user_email) ? base64_encode(base64_encode(base64_encode(base64_encode($data->user_email)))) : "";
    $user_password           = base64_encode(base64_encode(base64_encode(base64_encode($data->user_password))));
    $user->user_password     = isset($user_password) ? $user_password : "";
    if ($user->user_password && $user->user_password) {
        if ($user->password_verify() > 0) {
            $result                  = $user->getUserByUserNameAndPassword();
            while ($user_row = mysqli_fetch_assoc($result)) {
                $token = array(
                'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
                    "data" => array(
                        "user_email"        =>  base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_username'])))),
                        "user_password"     =>  base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_password']))))
                    )
                );
               http_response_code(200);
               $jwt = JWT::encode($data,$secretKey, 'HS512');
               
                $user_info = array(
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
                    "jwt"                  => $jwt
                );
                 //  print_r($user_info);
            }

            echo json_encode(
                array(
                    "status" => "1",
                    "message" => "Successful login.",
                    "jwt"     => $jwt,
                    "user"    => $user_info
                )
            );
        } else {
            //  set response code
            http_response_code(401);
            // tell the user login failed
            echo json_encode(
                array(
                    "status" => "0",
                    "message" => "Login failed.",
                    "jwt" => "",
                    "user" => ""
                )
            );
        }
    } else {

        // set response code
        http_response_code(401);

        // tell the user access denied
        echo json_encode(array("message" => "Access denied.",  "status" => "0"));
    }
}
                    

				
				} catch (Exception $e) {
					http_response_code(401);
					echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
				}

 
    // catch will be here
			}// show error message if jwt is empty
			else {
 
    // set response code
				http_response_code(401);
 
    // tell the user access denied
				echo json_encode(array("message" => "Access denied."));
			}
		} else {
			http_response_code(401);
			echo json_encode(
				array(
					"state"   => "0",
					"message" => "Autherization wasn't found."
				)
			);
		}
	} else {
		http_response_code(401);
		echo json_encode(
			array(
				"state"   => "0",
				"message" => "Method wasn't post."
			)
		);
	}
} else {
	http_response_code(401);
	echo json_encode(
		array(
			"state"   => "0",
			"message" => "Method wasn't post."
		)
	);
}
?>