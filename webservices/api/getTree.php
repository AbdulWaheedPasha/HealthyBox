<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/Database.php';
include_once '../models/Tree.php';

$data = json_decode(file_get_contents("php://input"));




$database     = new Database();
$db           = $database->connect();
$tree          = new Tree($db);
// $data         = json_decode(file_get_contents("php://input"));

$result       = $tree->getMainCategory();
if (mysqli_num_rows($result) > 0) {
    $cat_arr = array();
    $cat_arr['Tree'] = array();
    while ($row = mysqli_fetch_assoc($result)) {
        if($data->lang == "ar"){
            $category_name = $row['category_title_ar'];
        }else{
            $category_name = $row['category_title_en']; 
        }
        
        
        $tree->category_id   = $row['category_id'];
        $result_product       = $tree->getProduct();
        if (mysqli_num_rows($result_product) > 0) {
            $cat_arr['Tree'][$category_name] = array();
            while ($row_product = mysqli_fetch_assoc($result_product)) {
                $cat_item = array(
                    'product_id'        => $row_product['product_id'],
                    'product_title_ar'  => $row_product['product_title_ar'],
                    'product_title_en'  => $row_product['product_title_en'],
                    'product_price'     => $row_product['product_price'],
                    'product_discount'  => $row_product['product_discount'],
                );
                
                array_push($cat_arr['Tree'][$category_name], $cat_item);
            }
        }
    }
    echo json_encode($cat_arr);
} else {
    echo json_encode(
        array('message' => 'No Data Found')
    );
}
  ?>