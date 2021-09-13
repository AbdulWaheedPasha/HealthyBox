<?php
date_default_timezone_set('Asia/Kuwait');
header("Access-Control-Allow-Origin: ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../libs/core.php';
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';

use \Firebase\JWT\JWT;


include_once '../config/Database.php';
include_once '../models/User.php';
include_once '../models/Programs.php';
include_once '../models/Payment.php';
$database = new Database();
$db = $database->connect();
$user = new User($db);
$program = new Programs($db);
$payment = new Payment($db);

if (isset($_SERVER['REQUEST_METHOD'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        try {
            $data     = json_decode(file_get_contents("php://input"));

            if (!empty($data->jwt)) {
                
                $token = JWT::decode($data->jwt, $secretKey, array('HS512'));
                
                if (
                    !empty($data->user_email)           &&
                    !empty($data->user_password)        &&
                    !empty($data->user_id)              &&
                    !empty($data->program_id)           &&
                    !empty($data->area_id)              &&
                    !empty($data->block_num)            &&
                    !empty($data->street_num)           &&
                    !empty($data->house_num)            &&
                    !empty($data->start_date)           &&
                    !empty($data->payment_status_id)    &&
                    !empty($data->TrackID)      &&
                    !empty($data->TrackID)      &&
                    !empty($data->price)      &&
                    !empty($data->PaymentID) ) {
                    http_response_code(200);
                    // check for date 
                    $date = date("Y-m-d",strtotime($data->start_date));
                    // echo $date."<br/>";
                    // echo date("Y-m-d");
                    if ($date >=  date("Y-m-d")) {

                        $unixTimestamp = strtotime($date);
                        $dayOfWeek = date("l", $unixTimestamp);
                        //echo $dayOfWeek;
                        if ($dayOfWeek !== 'Thursday') {
                            $user->user_id            = $data->user_id;
                            $user->place_id           = 1;
                            $user->program_id         = $data->program_id;
                            $user->area_id            = $data->area_id;
                            $user->block_number       = $data->block_num;
                            $user->street_number      = $data->street_num;
                            $user->avenus_number      = $data->avenus_num;
                            $user->house_no           = $data->house_num;
                            $user->note               = $data->notes;
                            $program->user_area_id    = $user->insertAddressRelateProgram();
                            // echo  date('Y-m-d', strtotime($date . ' +1 day'));
                            if ($program->user_area_id > 0) {
                                $duration_day             = $data->program_duration;
                                $program->start_date      = date('Y-m-d', strtotime($date . ' +1 day'));
                                $program->end_date        = date('Y-m-d', strtotime("+" . $duration_day . " day", strtotime($data->start_date)));
                                //echo $program->end_date;
                                if ($program->setStartDateAndEndDate()) {
                                   

                                    $payment->payment_order_id      =  $data->order_id;
                                    $payment->payment_date          =  date("Y-m-d");
                                    $payment->payment_time          =  date("h:i:sa");
                                    $payment->user_area_id          =  $program->user_area_id;
                                    $payment->payment_status_id     =  $data->payment_status_id;
                                    $payment->paymentId              = $data->PaymentID;
                                    $payment->payment_Tran_Id       =  $data->TranID;
                                    $payment->payment_TrackID       =  $data->TrackID;
                                    $payment->payment_price         =  $data->price;
                                    $user_email                     =  $data->user_email;
                                    $user_password                  =  $data->user_password;

                                    if ($payment->saveTransaction()) {

                                        $data = [
                                            'iat'  => $issuedAt,         // Issued at: time when the token was generated
                                            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                                            'iss'  => $serverName,       // Issuer
                                            'nbf'  => $notBefore,        // Not before
                                            'exp'  => $expire,           // Expire
                                            'data' => [                  // Data related to the signer user
                                                'token_username'   => base64_encode(base64_encode(base64_encode(base64_encode($user_email)))), 
                                                'token_password'   => base64_encode(base64_encode(base64_encode(base64_encode($user_password)))), 
                                            ]
                                        ];
                                        http_response_code(200);
                                        $jwt = JWT::encode($data,$secretKey, 'HS512');

                                        echo json_encode(array("message" => "Program was added  Successfully and will be start in $program->start_date .", "status" => "1","jwt" => $jwt));
                                    } else {
                                        echo json_encode(array("message" => "Error To add Transaction.", "status" => "0"));
                                    }

                                } else {
                                    echo json_encode(array("message" => "Error To add start and End Date.", "status" => "0"));
                                }
                            } else {
                                http_response_code(401);
                                echo json_encode(array("message" => "Error To add Address.", "status" => "0"));
                            }
                        } else {
                            http_response_code(401);
                            echo json_encode(array("message" => "No Orders in Thursday is weekend , the order will be delivery in Friday .", "status" => "0"));
                        }
                    } else {
                        http_response_code(401);
                        echo json_encode(array("message" => "Date was less than current date. Please select another date", "status" => "0"));
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(array("message" => "Please fill empty field", "status" => "0"));
                }
            } else {
                http_response_code(401);
                echo json_encode(array("state" => "0", "message" => "Access denied.", "error" => "No jwt was found "));
            }
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(array("state" => "0", "message" => "Access denied.", "error" => $e->getMessage()));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("state" => "0", "message" => "Access denied."));
    }
} else {
    http_response_code(401);
    echo json_encode(array("state" => "0", "message" => "REQUEST METHOD wasn't found."));
}
