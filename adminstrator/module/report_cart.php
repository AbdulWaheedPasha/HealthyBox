<?php
session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['password'])) {
    session_destroy();
       header('Location:./index.php?err=1');
       exit();
}else{ 

    if(count($_SESSION['order_today'][0]) > 0){
    require_once '../Configuration/db.php';
    $lang = $_GET['lang'];
    require_once("../lang/$lang.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Test</title>
    <style>
        .break {
            page-break-after: right;
            width: 700px;
            clear: both;
        }
        @page {
            size: 204mm 102mm;
            outline: 1pt dotted;
            margin: 0;
            padding-top: 0;

        }

        .print_label {
            height: 104mm;
            /* should be 31.0 */
            width: 204mm;
            /* should be 63.5 */
        }

        .print_label {
            padding-top: 9mm;
            /* padding-left: 3mm;
            margin-left: 2.6mm;
            margin-bottom: 30mm; */
            /* float: left; */
            text-align: center;
            font-size: 10mm;
        }
        p{
            font-weight: bold;
            font-size: 45px;;
        }

    </style>
</head>

<body>



<?php
//print_r($_SESSION['order_today']);

    for($counter=0;$counter<$_SESSION['count'];$counter++){
        $area_name    = ($_GET['lang'] == "en")       ?  $_SESSION['order_today'][$counter]['area_name_eng']     : $_SESSION['order_today'][$counter]['area_name_ar'] ;
        $program_name = ($_GET['lang'] == "en")       ?  $_SESSION['order_today'][$counter]['program_title_en']  : $_SESSION['order_today'][$counter]['program_title_ar'] ;
        // $program_name_title = ($_GET['lang'] == "en") ?  $languages['area']['program_en_name']                   : $languages['area']['program_ar_name'];
        $dir = ($_GET['lang'] != "en") ? 'style="direction:rtl"' : "";   
        echo ' <div class="break" '.$dir.'> 
                    <div class="print_label">
                        <h2>'.$_SESSION['order_today'][$counter]['name'] .'</h2>
                        <p>'.$languages['today_orders']['area'] .": ".$area_name .' - '.$languages['today_orders']['block'] .":".$_SESSION['order_today'][$counter]['user_area_block'] .'</p>
                        <p>'.$languages['today_orders']['street']." : ". $_SESSION['order_today'][$counter]['user_area_street'] .' - '.$languages['today_orders']['avenue'] .":".$_SESSION['order_today'][$counter]['user_area_avenue'] .'-'. $languages['today_orders']['house_no'].":".$_SESSION['order_today'][$counter]['user_area_house_num'] .'</p>
                        <p>'.$languages['today_orders']['tele'] ." : ".$_SESSION['order_today'][$counter]['tele'] .'-'.$_SESSION['order_today'][$counter]['telep1'] .'</p>
                        <p>'.$program_name.'</p>
                        <p>'.$languages['today_orders']['user_id'] ." : ".$_SESSION['order_today'][$counter]['user_id'] .'</p>

                    </div>
                </div>';

                                                                
    }
 
?>
   






  

  





    
</body>

</html>

<?php
}
  
    }

    ?>