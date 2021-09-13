<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/Database.php';
include_once '../models/Notification.php';
$database     = new Database();
$db           = $database->connect();
$notification = new Notification($db);
$result       = $notification->getNotificationList();
if (mysqli_num_rows($result) > 0) {
    $cat_arr = array();
    $cat_arr['notification_items'] = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $cat_item = array(
            'notification_message'        => $row['notification_message']
        );
        array_push($cat_arr['notification_items'], $cat_item);    
    }
    echo json_encode($cat_arr);
} else {
    echo json_encode(
        array('message' => 'No Data Found')
    );
}
  ?>