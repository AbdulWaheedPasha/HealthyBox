<?php 
session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['password'])) {
    session_destroy();
       header('Location:./index.php?err=1');
       exit();
}else{ 
    require_once '../Configuration/db.php';
    $lang = $_GET['lang'];
    require_once("../lang/$lang.php");
    require_once("../Controller/TodayOrderController.php");
    $order_controller     = new today_order_controller($con);
    $pov_arr              = $order_controller->fetc_pro($_SESSION['order_today']['capital_id']);
    $pro_name             = ($lang == "en") ? $pov_arr["capital_en_title"] : $pov_arr["capital_ar_title"];

        $html_str = '<!DOCTYPE html>
        <html>
           <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <meta name="generator" content="Adobe RoboHelp 2017">
              <title>Print Report</title>
              <script type="text/javascript"> 
         window.print()
        </script> 
              <style type="text/css">';
             $direction = ($lang == "ar") ? 'body{direction: rtl;}' : 'body{direction: ltr;}' ;

             $html_str .= $direction;

              $html_str .= 'topic-header {
                 background-color: #FFFFFF;
                 color: #0000FF;
                 width: calc(100%);
                 height: 3em;
                 position: fixed;
                 left: 0;
                 top: 0;
                 font-family: Brandon Grotesque Light;
                 display: table;
                 box-sizing: border-box;
                 }
                 .topic-header-shadow {
                 height: 3em;
                 width: 100%;
                 }
                 .logo {
                 cursor: pointer;
                 padding: 0.2em;
                 text-align: center;
                 display: table-cell;
                 vertical-align: middle;
                 }
                 .logo img {
                 width: 1.875em;
                 display: block;
                 }
                 .nav {
                 width: 100%;
                 display: table-cell;
                 }
                 .title {
                 width: 40%;
                 height: 100%;
                 float: left;
                 line-height: 3em;
                 cursor: pointer;
                 }
                 .gotohome {
                 width: 60%;
                 float: left;
                 text-align: right;
                 height: 100%;
                 line-height: 3em;
                 cursor: pointer;
                 }
                 .title span,
                 .gotohome span {
                 padding: 0em 1em;
                 white-space: nowrap;
                 text-overflow: ellipsis;
                 overflow: hidden;
                 display: block;
                 }
              </style>
           </head>
           <body><div><h4>'.$pro_name .' - '.$_SESSION['order_today']['date'].'</h4></div>
           <h6>'.$languages['today_orders']['kitchen'].'</h6>';
 
            $html_str = $html_str . '<table width="100%" cellspacing="0" styel="text-align:center; border: 1px solid black;">
                                        <thead>
                                                <tr>     
                                                    <th style="text-align:center; border: 0.1px solid gray;">'. $languages['driver']['code'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['subscriber_name'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['subscriber_notes'].'</th>
                                                </tr>
                                       </thead>
                                    <tbody>';
                                 
              for($i=0;$i<$_SESSION['count'];$i++){
                  $value = $i+1;
                  $html_str = $html_str . '<tr>
                            <td style="text-align:center; border: 0.1px solid gray;color:'.$_SESSION['order_today'][$i]['color'].'">'.$_SESSION['order_today'][$i]['user_id'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;color:'.$_SESSION['order_today'][$i]['color'].'">'.$_SESSION['order_today'][$i]['name'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;color:'.$_SESSION['order_today'][$i]['color'].'">'.$_SESSION['order_today'][$i]['user_area_notes'].'</td>
                  </tr>';
              }
         

              

            $html_str   = $html_str .'</tbody></table>';
            $html_str   = $html_str .'';
        
        $html_str = $html_str . '
  </body>
</html>';

        echo  $html_str;

        // echo '<button onclick="window.print()">Print this page</button>';

    }

?>