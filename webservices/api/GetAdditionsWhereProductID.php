<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../config/Database.php';
  include_once '../models/Additions.php';
  include_once '../models/Product.php';
  $database = new Database();
  $myObj = (object)array(); // object(stdClass)
  $myObj->message = (object)array(); // object(stdClass)
  $db = $database->connect();
  $product      = new Product($db);
  $additions    = new Additions($db);
  $data         = json_decode(file_get_contents("php://input"));
  $additions->product_id  = $data->product_id;
  $product->product_id     = $data->product_id;
  $result                  = $additions->getAdditions();
  $result_product          = $product->getProductWhereProductID();
  $jsonArray = array();
  $cat_arr   = array(); 
  if(mysqli_num_rows($result) > 0) {

   
    while ($row_photos = mysqli_fetch_assoc($result)) {
      $temp["additions"] = array(
        'additions_name_ar'   => $row_photos['additions_name_ar'],
        'additions_name_eng'  => $row_photos['additions_name_eng'],
        'additions_type'      => $row_photos['additions_type'],
        'additions_id'        => $row_photos['additions_id'],
        'additions_haveqty'   => $row_photos['additions_haveqty'],
        'additions_selection' => $row_photos['additions_selection'],
        'additions_qty'       => $row_photos['additions_qty']
      );
      $additions->additions_id  = $row_photos['additions_id'];
      $result_items            = $additions->getItemsAdditions();
      while($row_items = mysqli_fetch_assoc($result_items)) {
      
        $temp["additions"]["additions_items"][] =  array(
          'additions_item_ar_name'   => $row_items['additions_item_ar_name'],
          'additions_item_en_name'   => $row_items['additions_item_en_name'],
          'additions_item_price'     => $row_items['additions_item_price'],
          'additions_item_id'        => $row_items['additions_item_id'],
        );
    }
     $myObj->main[]    = $temp;
    }
  
    $myObj->message = 'have_add';
     $temp;
    
    echo json_encode($myObj);
  } else {
        // No Categories
        echo json_encode(
          array('message' => "no_add")
        );
  }
  ?>