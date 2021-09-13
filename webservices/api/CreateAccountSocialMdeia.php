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

$target_dir = "../../asset/images/";
if (isset($_SERVER['REQUEST_METHOD'])) {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if ($_SERVER['HTTP_AUTHORIZATION'] != "") {
			if ($_SERVER['HTTP_AUTHORIZATION']) {
				try {
                    $arr = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
                   
                    $token = JWT::decode($arr[1], $secretKey, array('HS512'));
                    // files needed to connect to database
                    include_once '../config/Database.php';
                    include_once '../models/User.php';
                    $database = new Database();
                    $db       = $database->connect();
                    $user     = new User($db);
                    $data     = json_decode(file_get_contents("php://input"));
                    if(!empty($data->access_token)  && !empty($data->user_email) && !empty($data->user_telep)){
                        $user->user_name             = $data->user_name;
                        $user->user_email            = base64_encode(base64_encode(base64_encode(base64_encode($data->user_email))));
                        $user->user_password         = base64_encode(base64_encode(base64_encode(base64_encode($data->user_password))));
                        $user->user_telep            = $data->user_telep;
                        $user->user_another_telep    = $data->user_another_telep;
                        $user->gender                = $data->user_gender;
                        $user->age                   = $data->user_age;
                        $user->tall                  = $data->user_tall;
                        $user->weight                = $data->user_weight;
                        $user->motivation            = $data->user_motivation;
                        $user->goal_weight           = $data->user_goal_weight;
                        $user->firebase              = $data->user_firebase;
                        $user->user_image_path       = $data->user_image_path;
                        if($user->searchUser() == 0){
                            if($user->create()){
                                http_response_code(200);
                                $result         = $user->getUserByUserNameAndPassword();
                                while($user_row = mysqli_fetch_assoc($result)) {
                            
                                        $user_info = array(
                                               "user_image_path"       =>  $user_row['administration_profile'],
                                                 "user_id"             =>  $user_row['administration_id'],
                                                "user_name"            =>  $user_row['administration_name'],
                                                "user_email"           =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_username'])))),
                                                "user_password"        =>  base64_decode(base64_decode(base64_decode(base64_decode($user_row['administration_password'])))),
                                                "user_telep"           =>  $user_row['administration_telephone_number'],
                                                "user_another_telep"   => $user_row['administration_telephone_number1'],
                                                "user_gender"          => $user_row['administration_gender_type'], 
                                                "user_age"             => $user_row['administration_age'], 
                                                "user_tall"            => $user_row['administration_tall'], 
                                                "user_weight"          => $user_row['administration_weight'], 
                                                "user_motivation"      => $user_row['administration_motivation'], 
                                                "user_goal_weight"     => $user_row['administration_goal_weight'], 
                                                "user_firebase"        => $user_row['administration_firebase']
                                        );
                                }
                                echo json_encode(array("status" => "1","message" => "User was created.","user"=> $user_info));
                            }else{
                                http_response_code(400);
                                echo json_encode(array("message" => "Unable to create user.","status" => "0"));
                            }
                        }else{
                            http_response_code(400);
                            echo json_encode(array("message" => "User Registration before","status" => "0"));
                        }
                    }else{
                        http_response_code(401);
                        echo json_encode(array("message" => "Empty field","status" => "0"));
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