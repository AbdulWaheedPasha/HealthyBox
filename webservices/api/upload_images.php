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
JWT::$leeway = 5;   // Allows a 5 second tolerance on timing checks

$target_dir  = "../../asset/images/";
if (isset($_SERVER['REQUEST_METHOD'])) {
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if ($_SERVER['HTTP_AUTHORIZATION'] != "") {
			if ($_SERVER['HTTP_AUTHORIZATION']) {
				try {
				// 	$arr = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
				// 	$token = JWT::decode($arr[1], $secretKey, array('HS512'));
        // set response code
					http_response_code(200);

					$target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
					if (isset($_POST)) {
						$check = getimagesize($_FILES["file_upload"]["tmp_name"]);
						if ($check !== false) {
							$uploadOk = 1;
						} else {
							http_response_code(401);
							echo json_encode(
								array(
									"state"   => "0",
									"message" => "File is not an image."
								)
							);

							$uploadOk = 0;
						}
					}
                 if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
						http_response_code(401);
						echo json_encode(
							array(
								"state"   => "0",
								"message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
							)
						);
						$uploadOk = 0;
					} else if ($uploadOk == 0) {
						http_response_code(401);
						echo json_encode(
							array(
								"state"   => "0",
								"message" => "Sorry, your file was not uploaded."
							)
						);
					} else {
            $filename   = uniqid() . "-" . time(); 
            $extension  = pathinfo( $_FILES["file_upload"]["name"], PATHINFO_EXTENSION );
            $basename   = $filename . "." . $extension; 
            $source       = $_FILES["file_upload"]["tmp_name"];
            $destination  = "../../asset/images/".$basename;

						if (move_uploaded_file($source,$destination)) {
              $target_dir = "asset/images/";
							http_response_code(200);
							echo json_encode(
								array(
									"state"   => "1",
                  "image_path" => $target_dir.basename($basename),
                  "message" => "file was uploaded."
								)
							);
						} else {
							http_response_code(401);
							echo json_encode(
								array(
									"state"   => "0",
									"message" => "Sorry, there was an error uploading your file."
								)
							);
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