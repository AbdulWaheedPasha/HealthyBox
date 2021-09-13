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
                    include_once '../config/Database.php';
                    include_once '../models/CMS.php';
                   
                    $database     = new Database();
                    $db           = $database->connect();
                    $cms          = new CMS($db);
                    
                    $result       = $cms->getArea();
                    if (mysqli_num_rows($result) > 0) {
                        $cat_arr = array();
                        $cat_arr['area_item'] = array();
                        while ($row_photos = mysqli_fetch_assoc($result)) {
                            $cat_item = array(
                                'area_id'          => $row_photos['area_id'],
                                'area_name_ar'     => $row_photos['area_name_ar'],
                                'area_name_eng'    => $row_photos['area_name_eng'],
                               // 'area_cost_delivery'    => $row_photos['area_cost_delivery'],
                            );
                            array_push($cat_arr['area_item'], $cat_item);
                        }
                        echo json_encode($cat_arr);
                    } else {
                        echo json_encode(
                            array('message' => 'No Data Found'));
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