<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/Database.php';
include_once '../models/CMS.php';
$database     = new Database();
$db           = $database->connect();
$cms          = new CMS($db);
$data         = json_decode(file_get_contents("php://input"));
$cms->page_id = $data->page_id;
$result       = $cms->getPageContent();
if (mysqli_num_rows($result) > 0) {
    $cat_arr = array();
    $cat_arr['page_content'] = array();
    while ($row_photos = mysqli_fetch_assoc($result)) {
        $cat_item = array(
            'pages_title_ar'    => $row_photos['pages_title_ar'],
            'pages_title_en'    => $row_photos['pages_title_en'],
            'pages_contents_ar' => $row_photos['pages_contents_ar'],
            'pages_contents_en' => $row_photos['pages_contents_en']
        );
        array_push($cat_arr['page_content'], $cat_item);
    }
    echo json_encode($cat_arr);
} else {
    echo json_encode(
        array('message' => 'No Data Found')
    );
}
  ?>