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
					include_once '../models/Feeds.php';
					include_once '../helper/Helper_String.php';
                    $database = new Database();
                    $db       = $database->connect();
					$feed     = new Feeds($db);
					$helper_str = new Helper_String();
                    $data     = json_decode(file_get_contents("php://input"));
                    if(!empty($data->feed_title)  && !empty($data->feed_message) && !empty($data->name)){
                        $feed->feed_title           = $helper_str->string_sanitize($data->feed_title);
                        $feed->feed_message         = $helper_str->string_sanitize($data->feed_message);
                        $feed->name                 = $helper_str->string_sanitize($data->name);
                      
                        if($feed->addNewFeeds()){
                             http_response_code(200);
                             echo json_encode(array("status" => "1","message" => "Add Feeds was sucessfully",));
                        }else{
                                http_response_code(401);
                                echo json_encode(array("message" => "Error in add Feeds","status" => "0"));
                            
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