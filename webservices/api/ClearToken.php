<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../models/User.php';
include_once '../models/Area.php';
include_once '../config/core.php';
$database = new Database();
$db       = $database->connect();
$user     = new User($db);
$area     = new Area($db);

// generate json web token
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';

use \Firebase\JWT\JWT;

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (empty($data->user_email) && empty($data->user_password)) {
    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied.",  "status" => "0"));
} else {
    $user->user_email        = isset($data->user_email) ? base64_encode(base64_encode(base64_encode(base64_encode($data->user_email)))): "";
    $user_password           = base64_encode(base64_encode(base64_encode(base64_encode($data->user_password))));
    $user->user_password     = isset($user_password) ? $user_password : "";
    if ($user->user_password && $user->user_password) {
        if ($user->password_verify() > 0) {
            $result                  = $user->getUserByUserNameAndPassword();
            if (mysqli_num_rows($result) > 0) {
                while ($user_row = mysqli_fetch_assoc($result)) {
                    $token = array(
                        "iss" => $iss,
                        "aud" => $aud,
                        "iat" => $iat,
                        "nbf" => $nbf,
                        "data" => array(
                            "user_email"        =>  base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_username'])))),
                            "user_password"     =>  base64_encode(base64_encode(base64_encode(base64_encode($user_row['administration_password']))))
                        )
                    );

                    $delete_token                  = $user->deleteTokenFirebase();
                    if ($delete_token) {
                       http_response_code(200);
                       $jwt = JWT::encode($data,$secretKey, 'HS512');
                        echo json_encode(
                            array(
                                "status" => "1",
                                "message" => "Token was Delete.",
                                "jwt"     => $jwt
                            )
                        );
                    }else{
                          //  set response code
                        http_response_code(401);
                        // tell the user login failed
                        echo json_encode(
                            array(
                                "status" => "0",
                                "message" => "Token wasnot Delete.",
                                "jwt" => "",
                                "user" => ""
                            )
                        );
                    }
                }
            } else {
                //  set response code
                http_response_code(401);
                // tell the user login failed
                echo json_encode(
                    array(
                        "status" => "0",
                        "message" => "No User Found.",
                        "jwt" => "",
                        "user" => ""
                    )
                );
            }
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
