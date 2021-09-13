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

if (empty($data->user_email) && empty($data->user_telep)) {
    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "No User Was Found.",  "status" => "0"));
} else {
    $user->user_email        = isset($data->user_email) ? $data->user_email : "";
    $user->user_telep        = isset($data->user_telep) ? $data->user_telep : "";
    $lang                    = isset($data->lang)       ? $data->lang : "";
    if ($user->user_telep || $user->user_email) {
        if ($user->checkIfUserFound() > 0) {
            $result = $user->fetchUserInfoByEmailOrTelephone();
            while ($user_row = mysqli_fetch_assoc($result)) {
                $to              = $user_row['administration_username'];
                $t               = time();
                $user->user_date = date("Y-m-d",$t);
                $user->user_id   = $user_row['administration_id'];
                if($user->numChangePasswordPerDay() > 2){
                    http_response_code(200);
                    // tell the user login failed
                    echo json_encode(
                        array(
                            "status" => "0",
                            "message" => "Limit Request to send per day (Maxmuim 3 request per day)."
                        )
                    ); 
                }else{
                    $subject = "Healthy Box Forget Password?";
                    $user->user_password   = $user->generateNumericOTP(8); 
                    if($lang == "en"){
                        $title     = "You have requested to reset your password";
                        $passTitle = "  Your New Password is : ". $user->user_password;
                    }else{
                        $title     = "لقد طلبت إعادة تعيين كلمة المرور الخاصة بك";
                        $passTitle = " كلمة المرور الجديدة هي: ". $user->user_password;
                    }
                    $message = "
                    <!doctype html>
                    <html lang='en-US'>
                    
                    <head>
                        <meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
                        <title>Reset Password Email</title>
                        <meta name='description' content='Reset Password Email Template.'>
                        <style type='text/css'>
                            a:hover {text-decoration: underline !important;}
                        </style>
                    </head>
                    
                    <body marginheight='0' topmargin='0' marginwidth='0' style='margin: 0px; background-color: #f2f3f8;' leftmargin='0'>
                        <!--100% body table-->
                        <table cellspacing='0' border='0' cellpadding='0' width='100%' bgcolor='#f2f3f8'
                            style='@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;'>
                            <tr>
                                <td>
                                    <table style='background-color: #f2f3f8; max-width:670px;  margin:0 auto;' width='100%' border='0'
                                        align='center' cellpadding='0' cellspacing='0'>
                                        <tr>
                                            <td style='height:80px;'>&nbsp;</td>
                                        </tr>
                                        
                                 
                                        <tr>
                                            <td>
                                                <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'
                                                    style='max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);'>
                                                    <tr>
                                                        <td style='height:40px;'>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding:0 35px;'>
                                                            <h1 style='color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;'></h1>
                                                            <span
                                                                style='display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;'>'.$title.'</span>
                                                            <p style='color:#455056; font-size:15px;line-height:24px; margin:0;'>
                                                            '.$passTitle.'
                                                            </p>
                                                          
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='height:40px;'>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!--/100% body table-->
                    </body>
                    
                    </html>";
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <info@healthybox.com>' . "\r\n";
                    if(mail($to,$subject,$message,$headers)){
                        $user->user_password = base64_encode(base64_encode(base64_encode(base64_encode($user->user_password))));
                        $user->updatePassword();
                        $user->insertChangePasswordRequest();
                        echo json_encode(
                            array(
                                "status" => "1",
                                "message" => "mail send successfully.",
                            )
                        );
                       
                    }else{
                        http_response_code(200);
                        // tell the user login failed
                        echo json_encode(
                            array(
                                "status" => "0",
                                "message" => "Error in mail function ."
                            )
                        ); 
                    }
                }
               
            }
           
            // $to = "somebody@example.com, somebodyelse@example.com";
            // mail($to,$subject,$message,$headers);
            // echo 
            // http_response_code(200);
            // $jwt = JWT::encode($data,$secretKey, 'HS512');
            // echo json_encode(
            //     array(
            //         "status" => "1",
            //         "message" => "Successful login.",
            //         "jwt"     => $jwt,
            //         "user"    => $user_info
            //     )
            // );
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