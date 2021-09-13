<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  // generate json web token
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';
use \Firebase\JWT\JWT;
JWT::$leeway = 5; // Allows a 5 second tolerance on timing checks

if (isset($_SERVER['REQUEST_METHOD'])) {
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		if ($_SERVER['HTTP_AUTHORIZATION'] != "") {
			if ($_SERVER['HTTP_AUTHORIZATION']) {
				try {
                    $arr = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
                    $token = JWT::decode($arr[1],$secretKey, array('HS512'));
                    http_response_code(200);
                    echo json_encode(array("status" => "1","message" => "Successfully", "token" => "Token wasn't expired"));
                } catch (Exception $e) {
					http_response_code(401);
					echo json_encode(array("status" => "0","message" => "Access denied.", "error" => $e->getMessage()));
				}
			}else {
				http_response_code(401);
				echo json_encode(array("status" => "0","message" => "Access denied."));
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