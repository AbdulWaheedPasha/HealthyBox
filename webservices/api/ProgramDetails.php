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
  

              include_once '../config/Database.php';
              include_once '../models/User.php';
              include_once '../models/Area.php';
              
              $database = new Database();
              $db       = $database->connect();
              $user     = new User($db);
              include_once '../models/OrderLists.php';
              // Instantiate category object
              $orderlist = new OrderLists($db);


              $user->user_email           = isset($data->user_email)       ? base64_encode(base64_encode(base64_encode(base64_encode($data->user_email)))) : "" ;
              $user->user_password        = isset($data->user_password)    ? base64_encode(base64_encode(base64_encode(base64_encode($data->user_password)))) : "";
              $orderlist->participation_id     = isset($data->participation_id) ? $data->participation_id : "";


              if(!empty($user->user_password) && !empty($user->user_password) && !empty($orderlist->participation_id)){
                      
                     
                      if($user->password_verify() > 0){
                      
                        $orderlist->participation_id = $data->participation_id;
                        $orderlist->user_id = $data->user_id;
                        $result = $orderlist->getProgramWhereProgramID();
                          // Get row count
                        $num = mysqli_num_rows($result);
                          // Check if any categories
                          if($num > 0) {
                            // // Cat array
                            $cat_arr = array();
                       
                          //  print_r($row);
                            while($row = mysqli_fetch_assoc($result)) {
                        //`order_number`, `order_created_at`, `order_status_id`
                        // print_r($row);
                              $cat_item = array(
                                'participation_id'         =>  $row['user_area_id'],
                                'program_start_date'       =>  $row['program_start_date'],
                                'program_end_date'         => $row['program_start_end'],
                                'program_title_ar'         => $row['program_title_ar'],
                                'program_title_en'         => $row['program_title_en'],
                                'program_image_path'       => $row['program_image_path'],
                                'program_en_describe'         => $row['program_en_describe'],
                                'program_ar_describe'         => $row['program_en_describe'],
                              );
                              $orderlist->program_start_end_date_id  = $row['program_start_end_date_id'];
                              // Push to "data"
                               $cat_arr = $cat_item;
                            }
                            $days_result = $orderlist->getDaysWhereProgramID();
                            while($day_row = mysqli_fetch_assoc($days_result)) {
                                //`program_day_en`, `program_day_ar`, `program_day_date`
                               $day_arr = array(
                                   'program_day_name'        =>  $day_row['program_day_en'],
                                   'program_day_date'      =>  $day_row['program_day_date'],
                                 );
                                 $cat_arr["days"][] = $day_arr;
                            }
                         
                            // Turn to JSON & output
                          
                         
                            
                            echo json_encode(
                              array("status" => "1","programs" => $cat_arr)
                            );
                        } else {
                            // No Categories
                            echo json_encode(
                              array('message' => 'No Programs for User',"status" => "3")
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
                              )
                          );
                      }
              }else{
               
                  // set response code
                  http_response_code(401);
               
                  // tell the user access denied
                  echo json_encode(array("message" => "Empty Fields.",  "status" => "0"));
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