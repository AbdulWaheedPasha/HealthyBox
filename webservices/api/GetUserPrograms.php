<?php
// required headers
header("Access-Control-Allow-Origin: *");
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

$data                = json_decode(file_get_contents("php://input"));
$token_username      = isset($data->user_email) ? $data->user_email : "";
$token_password      = isset($data->user_password) ? $data->user_password : "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($token_username) && !empty($token_password)){
            try{
              $token = JWT::decode($data->jwt, $secretKey, array('HS512'));
              include_once '../models/Programs.php';
              include_once '../models/User.php';
              include_once '../models/Area.php';
              include_once '../config/Database.php';
              $database = new Database();
              $db       = $database->connect();
              
              $user     = new User($db);
              $area     = new Area($db);
              $program  = new Programs($db);
              
              $program->user_id = $data->user_id;
              $program_arr      = $program->getSubcriberStatus();

              $user->username         = isset($data->user_email) ? $data->user_email : "";
              $user->user_password    = isset($data->user_password) ? $data->user_password : "";

              if(!empty($user->username) && !empty($user->user_password)){
        
                $user->user_email          = base64_encode(base64_encode(base64_encode(base64_encode($data->user_email))));
                $user->user_password       = base64_encode(base64_encode(base64_encode(base64_encode($data->user_password))));

                
                if($user->password_verify() > 0){
                  include_once '../models/OrderLists.php';
                  // Instantiate category object
                  $orderlist = new OrderLists($db);
                  $orderlist->user_id = $data->user_id;
                  $result = $orderlist->getAllPrograms();
                    // Get row count
                  $num = mysqli_num_rows($result);
                  $data = [
                    'iat'  => $issuedAt,         // Issued at: time when the token was generated
                    'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                    'iss'  => $serverName,       // Issuer
                    'nbf'  => $notBefore,        // Not before
                    'exp'  => $expire,           // Expire
                    'data' => [                  // Data related to the signer user
                        'token_username'   => base64_encode(base64_encode(base64_encode($user->user_email))), 
                        'token_password'   => base64_encode(base64_encode(base64_encode($user->user_password))), 
                    ]
                ];
                http_response_code(200);
                $jwt = JWT::encode($data,$secretKey, 'HS512');
                    // Check if any categories
                    if($num > 0) {
                      // // Cat array
                      $cat_arr = array();
                    //  print_r($row);
                      while($row = mysqli_fetch_assoc($result)) {
                       // print_r($program_arr);
                     // echo $program_arr['program_price'];
                        $cat_item = array( 
                          'program_id'            => $row['program_id'],
                          'program_price'         => $row['program_price'],
                          'program_discount'      => $row['program_discount'],
                          'status_en'           => $program_arr['status_en'],
                          'status_ar'           => $program_arr['status_ar'],
                          'participation_id'    => $row['user_area_id'],
                          'program_start_date'  => $row['program_start_date'],
                          'program_end_date'    => $row['program_start_end'],
                        );
                        // Push to "data"
                         $cat_arr[] = $cat_item;


                      }
  
                     
                      // Turn to JSON & output
                    
                   
                      
                      echo json_encode(
                        array("programs" => $cat_arr ,"status" => "1","jwt"=>$jwt)
                      );
                  } else {
                      // No Categories
                      echo json_encode(
                        array('message' => 'No Programs for User',"status" => "3","jwt"=>$jwt)
                      );
                  }
                  
                    
                }else{
                    //  set response code
                    http_response_code(401);
                     // tell the user login failed
                    echo json_encode(
                        array(
                            "status" => "0",
                            "message" => "Login failed.",
                            "jwt" => "",
                            "user"=>""
                        )
                    );
                }
        }else{
         
            // set response code
            http_response_code(401);
         
            // tell the user access denied
            echo json_encode(array("message" => "Access denied.",  "status" => "0"));
        }

            }catch (Exception $e) {
					http_response_code(401);
					echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
				}
    }else{
        http_response_code(401);
        echo json_encode(array("status" => "0","message"=> "No Useranem and password to create token"));
    }
}else{
    http_response_code(401);
    echo json_encode(array("status" => "0","message"=> "Method wasn't Post"));
}
    ?>