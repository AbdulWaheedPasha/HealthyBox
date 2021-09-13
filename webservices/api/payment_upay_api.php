<?php
header("Access-Control-Allow-Origin:");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 if(isset($_SERVER['QUERY_STRING'])){
  if(!empty($_GET['PaymentID']) && !empty($_GET['Result']) && !empty($_GET['Result']) && !empty($_GET['TranID']) && !empty($_GET['TrackID']) && !empty($_GET['OrderID'])  ){
    echo  json_encode(array("PaymentID" => $_GET['PaymentID'], "Result" => $_GET['Result'], "TranID" => $_GET['TranID'], "TrackID" => $_GET['TrackID'],"OrderID" => $_GET['OrderID'],"status" => "1"));
  }else{
    echo json_encode(array("message" => "Access denied.", "error" => "No Paramater ","status" => "0"));
  }
  
 }else{
    http_response_code(401);
    echo json_encode(array("message" => "Access denied.", "error" => "No Query String","status" => "0"));
 }

?>