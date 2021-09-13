<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../config/Database.php';
  include_once '../models/Offers.php';
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
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		if ($_SERVER['HTTP_AUTHORIZATION'] != "") {
			if ($_SERVER['HTTP_AUTHORIZATION']) {
				try {
                    //echo $_SERVER['HTTP_AUTHORIZATION'];
                    $arr = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
                    //print_r($arr);
                    $token = JWT::decode($arr[1],$secretKey, array('HS512'));
                    $database = new Database();
                    $db = $database->connect();
                    $slider  = new Offers($db);
                    $result = $slider->fetchOffer();
                    if(mysqli_num_rows($result) > 0) {
                        $cat_arr = array();
                        $cat_arr['programs'] = array();
                        while($row_photos = mysqli_fetch_assoc($result)) {
                      
                            $cat_item = array(
                            'offer_id'        => $row_photos['offer_id'],
                            'offer_title_ar'  => $row_photos['offer_title_ar'],
                            'offer_title_en'   => $row_photos['offer_title_en'],
                            'offer_title_week' => $row_photos['offer_title_week'],
                            'offer_day'        => $row_photos['offer_day'],
                            'offer_cost'       => $row_photos['offer_cost'],

                            );
                            array_push($cat_arr['programs'], $cat_item);
                        }
                     
                            echo json_encode(array("programs" => $cat_arr['programs'],"status" => "1"));
                    } else {
                            // No Categories
                            http_response_code(401);
                            echo json_encode(array("message" => "No Fields","status" => "0"));
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