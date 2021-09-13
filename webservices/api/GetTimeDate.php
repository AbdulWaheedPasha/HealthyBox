<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/GetTimeDate.php';
include_once '../../adminstrator/class_file/format_date_class.php';
$date_class  = new format_date_class();
$database    = new Database();
$db          = $database->connect();
$cms         = new GetTimeDate($db);
$result      = $cms->getAvailable();
include_once '../models/Date.php';
$getTimeDate = new GetTimeDate($db);
$data        = json_decode(file_get_contents("php://input"));
$lang        = $data->lang;
if (mysqli_num_rows($result) > 0) {
    $cat_arr = array();
    $cat_arr['available'] = array();
    while ($row_available = mysqli_fetch_assoc($result)) {
        if ($row_available['process_work_status'] == 0) {
            $start = new DateTime('now');
            $end = new DateTime('+ 7 day');
            $diff = $end->diff($start);
            $interval = DateInterval::createFromDateString('+1 day');
            $period = new DatePeriod($start, $interval, $diff->days);
            $dateArr = array();
            $i       = 0;
            $count   = 0;
            $day_arr = Array();
            $ar_day_arr    = Array();
            foreach ($period as $date) {$timestamp    = strtotime($date->format('Y-m-d'));
                date_default_timezone_set('Asia/Kuwait');
                $postdate_d2  = date('l', $timestamp);
                $find         = array("Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
                $ar_day_format = $postdate_d2;
                $ar_day = str_replace($find, $find, $ar_day_format);
                // echo $ar_day;
                $value = $date->format('Y-m-d') . " " . $ar_day;
                $ar_day_arr[$i][1] = $value;
                $ar_day_arr[$i][0] = $ar_day;
                $i++;
            }
            
            $time_arr = Array();
            for($z=0;$z<count($ar_day_arr);$z++){
                $getTimeDate->day_name  = $ar_day_arr[$z][0];
                $time_work              = $getTimeDate->getTimeWork();
                $time_counter           = 0;
                if (mysqli_num_rows($time_work) > 0) {
                    $time_arr = Array();
                    while ($timearra = mysqli_fetch_assoc($time_work)) {
                        date_default_timezone_set('Asia/Kuwait');
                        $origin = strtotime($ar_day_arr[$z][1]); // date 
                        $target = strtotime(date("Y-m-d")); // current date 
                       
                       
                        if($origin == $target){
                         
                        $time = date("G:i:s");
                        $time1 = strtotime($time); 
                        $resttimeto1   = strtotime($timearra['day_time_hours_to']);
                            if($time1 < $resttimeto1){
                                //echo "current date";
                                if($lang == "en") {
                                    $time_arr[$time_counter] =  date("h:i:s a",strtotime($timearra['day_time_hours_from']))." - ".date("h:i:s a",strtotime($timearra['day_time_hours_to']));
                                }
                                else if($lang == "ar") {
                                    $time_arr_from     = explode(":",date("h:i:s a",strtotime($timearra['day_time_hours_from'])));
                                    $morning_or_eveing = explode(" ",$time_arr_from[2]);
                                    $from              = $date_class->set_arabic_time($time_arr_from[0],$time_arr_from[1],$morning_or_eveing[1]);
                                    $time_arr_to       = explode(":",date("h:i:s a",strtotime($timearra['day_time_hours_to'])));
                                    $morning_or_eveing = explode(" ",$time_arr_to[2]);
                                    $to                = $date_class->set_arabic_time($time_arr_to[0],$time_arr_to[1],$morning_or_eveing[1]);
                                    $time_arr[$time_counter] =  $from." - ".$to;
                                }
                                $time_counter++;
                          }
                          
                        }else{
                          //  echo "here1"."<br/>";
                        if($lang == "en") {
                            $time_arr[$time_counter] =  date("h:i:s a",strtotime($timearra['day_time_hours_from']))." - ".date("h:i:s a",strtotime($timearra['day_time_hours_to']));
                        }else if($lang == "ar") {
                            $time_arr_from     = explode(":",date("h:i:s a",strtotime($timearra['day_time_hours_from'])));
                            $morning_or_eveing = explode(" ",$time_arr_from[2]);
                            $from              = $date_class->set_arabic_time($time_arr_from[0],$time_arr_from[1],$morning_or_eveing[1]);
                            $time_arr_to       = explode(":",date("h:i:s a",strtotime($timearra['day_time_hours_to'])));
                            $morning_or_eveing = explode(" ",$time_arr_to[2]);
                            $to                = $date_class->set_arabic_time($time_arr_to[0],$time_arr_to[1],$morning_or_eveing[1]);
                            $time_arr[$time_counter] =  $from." - ".$to;
                        }
                        $time_counter++;
                    }
                    
                       
                    }
                    $time_counter++;
                }
                $format_date   = array(
                        'name'     => $ar_day_arr[$z][1],
                        'id'       => $time_arr
                    );
                array_push($day_arr, $format_date);
                $time_arr = Array();
            }
           $cat_item = array('status' => "0","date" => $day_arr);
         } else {
            $cat_item = array('status' => "1",
                'msg_ar' => "نحن لسنا متاحين الان",
                'msg_eng' => "We aren't available Now",
            );
        }
        array_push($cat_arr['available'], $cat_item);
    }
    echo json_encode($cat_arr);
} else {
    echo json_encode(
        array('message' => 'No Data Found')
    );
}

?>