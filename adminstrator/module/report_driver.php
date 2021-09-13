<?php 
session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['password'])) {
    session_destroy();
       header('Location:../index.php?err=1');
       exit();
}else{ 
   
    require_once '../Configuration/db.php';
    $lang = $_GET['lang'];
    require_once("../lang/$lang.php");
    require_once("../Controller/TodayOrderController.php");
    $order_controller    = new today_order_controller($con);
    $pov_arr              = $order_controller->fetc_pro($_SESSION['order_today']['capital_id']);
    $pro_name = ($lang == "en") ? $pov_arr["capital_en_title"] : $pov_arr["capital_ar_title"];
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
           <body><div><h4>'.$languages['today_orders']['Driver'].' - '.$pro_name .' - '.$_SESSION['order_today']['date'].'</h4></div>';
           
 
            $html_str = $html_str . '<table width="100%" cellspacing="0" styel="text-align:center; border: 1px solid black;">
                                        <thead>
                                                <tr>   
                                                   <th style="text-align:center; border: 0.1px solid gray;">'. $languages['area']['seq'].'</th>
  
                                                    <th style="text-align:center; border: 0.1px solid gray;">'. $languages['driver']['code'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['subscriber_name'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['tele'].'</th>
                                                  
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['area'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['block'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['street'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['avenue'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['house_no'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['floor'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['apart_num'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['figure'].'</th>

                                                </tr>
                                       </thead>
                                    <tbody>';
                                 
              for($i=0;$i<$_SESSION['count'];$i++){
                 // print_r($_SESSION['order_today'][$i]);
                $area_name =  ($lang == "en") ? $_SESSION['order_today'][$i]['area_name_eng'] :  $_SESSION['order_today'][$i]['area_name_ar'] ;

                  $value = $i+1;
                  $html_str = $html_str . '<tr>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$value.'</td>
                            <td style="text-align:center; border: 0.1px solid gray;"> '.$_SESSION['order_today'][$i]['user_id'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;color:'.$_SESSION['order_today'][$i]['color'].'">'.$_SESSION['order_today'][$i]['name'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['tele'].'-'.$_SESSION['order_today'][$i]['telep1'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$area_name.'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_block'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_street'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_avenue'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_house_num'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_floor'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_apartment_num'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_automated_figure'].'</td>
      


                  </tr>';
              }
         

              

            $html_str = $html_str .  '</tbody></table>';
            $html_str      = $html_str .'';
        
        $html_str = $html_str . '
  </body>
</html>';

        echo  $html_str;

    

    }

?>