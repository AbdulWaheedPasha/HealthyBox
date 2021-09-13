<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
    include_once '../config/Database.php';
    include_once '../models/User.php';
    include_once '../models/Order.php';

      // generate json web token
    include_once '../libs/core.php';
    include_once '../libs/BeforeValidException.php';
    include_once '../libs/ExpiredException.php';
    include_once '../libs/SignatureInvalidException.php';
    include_once '../libs/JWT.php';
    use \Firebase\JWT\JWT;
    
    $database = new Database();
    $db       = $database->connect();
    $user     = new User($db);
    $order    = new Order($db);
    $data     = json_decode(file_get_contents("php://input"));

    // user Data 
    $user->user_name          = $data->user_name;
    $user->user_telep         = $data->tele1;
    $user->tele2              = $data->tele2;
    $user->area_id            = $data->area;
    $user->block              = $data->block;
    $user->street             = $data->street;
    $user->avenus             = $data->avenus;
    $user->build_num          = $data->build_num;
    $user->home               = $data->home;
    $user->flat               = $data->flat;
    $user->place              = $data->place;

    // order detials 
    $order->order_time        = $data->time;
    $order->order_created_at  = $data->date;
    $order->payment_status_id = $data->payment_status_id;
    $product_info             = array($data->product_info);
    $order->area_id           = $data->area;


if(  !empty($data->user_name)    &&
     !empty($data->tele1)        &&
     !empty($data->area)         && 
     !empty($data->block)        && 
     !empty($data->street)       && 
     !empty($data->home)         && 
     !empty($order->payment_status_id) ){
         // Insert User 
         $order->user_id       =  $user->creatGuest();
         $order->order_number  = $order->generateRandomString();
        //  echo $order->user_id;
        if($order->payment_status_id == 2) {
            $order->AddNewOrder();
        }else if($order->payment_status_id == 1){
          $order->AddNewOrderStillPayemnt();
        }

        $order->order_id = $order->getLastOrderID();
        $order->AddUserOrder(); 
        for($i=0;$i<count($product_info[0]);$i++){
            //add product id to order 
            $order->product_id      = $product_info[0][$i]->product_id;   
            $order->product_price   = $product_info[0][$i]->product_price; 
            $order->product_qty     = $product_info[0][$i]->product_quantity;
            $order->order_lists_id  = $order->InsertProducOrderList();
        }
        http_response_code(200);
        echo json_encode(array("state" => "1","message" => "Order was Inserted",
                                "order_num" => $order->order_number,
                                "user_id"   => $order->user_id,
                                "delivery_time"=>$order->getDeliveryTimeTbl()));
     


    
    
}else{
    http_response_code(400);
    echo json_encode(array("state" => "0","message" => "Empty field"));
}
?>