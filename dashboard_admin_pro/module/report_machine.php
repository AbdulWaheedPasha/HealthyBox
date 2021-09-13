<?php 
session_start();
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_password'])) {
    session_destroy();
       header('Location:./index.php?err=1');
       exit();
}else{ 
    require_once '../Configuration/db.php';
    $lang = $_GET['lang'];
    require_once("../lang/$lang.php");

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
                 line-height: 2.8em;
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
           <body><h6>'.$languages['today_orders']['Driver'].'</h6>';
 
            $html_str = $html_str . '<table width="100%" cellspacing="0" styel="text-align:center; border: 1px solid black;">
                                        <thead>
                                                <tr>     
                                                    <th style="text-align:center; border: 0.1px solid gray;">التسلسل</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['subscriber_name'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['tele'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['block'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['street'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['avenue'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['house_no'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['building'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['floor'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['apart_num'].'</th>
                                                    <th style="text-align:center; border: 0.1px solid gray;">'.$languages['today_orders']['office_num'].'</th>

                                                </tr>
                                       </thead>
                                    <tbody>';
                                 
              for($i=0;$i<count( $_SESSION['order_today']);$i++){
                //   print_r($_SESSION['order_today'][$i]);
                $area_name =  ($lang == "ar") ? $_SESSION['order_today'][$i]['area_name_eng'] :  $_SESSION['order_today'][$i]['area_name_ar'] ;

                  $value = $i+1;
                  $html_str = $html_str . '<tr>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$value.'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['name'].'</td>
                            
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['tele'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_block'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_street'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_avenue'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_house_num'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_building_num'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_floor'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_apartment_num'].'</td>
                            <td style="text-align:center; border: 0.1px solid gray;">'.$_SESSION['order_today'][$i]['user_area_office_num'].'</td>


                  </tr>';
              }
         

              

            $html_str = $html_str .  '</tbody></table>';
            $html_str      = $html_str .'';
        
        $html_str = $html_str . '
  </body>
</html>';

        echo  $html_str;

        // echo '<button onclick="window.print()">Print this page</button>';

    }

?>