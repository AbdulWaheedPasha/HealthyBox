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
                    $data     = json_decode(file_get_contents("php://input"));
                    if (!function_exists('curl_version')) {
                        http_response_code(401);
                        echo json_encode(array("message" => "Access denied.", "error" => "Enable cURL in PHP" ));
                    }else if(!empty($data->total_price) && !empty($data->user_name) && !empty($data->user_email) && !empty($data->user_telep) ){
                     $number  = "";
                     $passwordChar = '1234567890';
                     $passwordLength = rand(15, 30);
                     $max = strlen($passwordChar) - 1;
                     $number = '';
                     $number1 = '';
                     for ($i = 0; $i < $passwordLength; ++$i) {
                         $number .= $passwordChar[random_int(0, $max)];
                     }


                     $fields = array(
                        'merchant_id'=>'1201',
                        'username' => 'test',
                        'password'=>stripslashes('test'), 'api_key'=>'jtest123', // in sandbox request
                   //'api_key' =>password_hash('API_KEY',PASSWORD_BCRYPT), //In production mode, please pass API_KEY with
                   'order_id'=>$number, 
                   'total_price'=>$data->total_price,
                   'CurrencyCode'=>'KWD',
                   'CstFName'=>$data->user_name,
                   'CstEmail'=>$data->user_email,
                   'CstMobile' =>$data->user_telep,
                   'success_url' =>"http://healthyboxq8.com/webservices/api/payment_upay_api.php",
                   'error_url'=>'http://healthyboxq8.com/webservices/api/payment_upay_api.php',
                   'test_mode'=>1, // test mode enabled
                   'whitelabled'=>true, // only accept in live credentials (it will not work in test)
                   'payment_gateway'=>'knet',// only works in production mode
                //    'ProductName'=>json_encode([‘computer’,’television’]),
                //    'ProductQty'=>json_encode([2,1]),
                //    'ProductPrice'=>json_encode([150,1500]),
                   'reference'=>'Ref00001'
                   );
                   $fields_string = http_build_query($fields);
                   $ch = curl_init();
                   curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/test-payment");
                   curl_setopt($ch, CURLOPT_POST, 1);
                   curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
                   // receive server response ...
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   $server_output = curl_exec($ch);
                   curl_close($ch);
                   $server_output = json_decode($server_output,true);
                   http_response_code(200);
                   echo json_encode(array("message" => "generate link sucessfully.", "link_payment" => $server_output['paymentURL'],"order_id"=>$number ,"status" => "1"));

                    }else{
                
                     http_response_code(401);
          
             // tell the user access denied
                     echo json_encode(array("message" => "Empty Field","status" => "0"));
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