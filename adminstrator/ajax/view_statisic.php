<?php
session_start();
// error_reporting(0);
// ini_set('display_errors', 0);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {

  if (isset($_GET['cap_id'])) {
    require_once("../Configuration/db.php");
    require_once('../lang/' . $_SESSION['lang'] . '.php');
    require_once("../Controller/StatisticsController.php");

    $statistics_cont     = new statistics_controller($con);
    $type_search         = 3;
    $date                = 3;
    $title = $languages['menu_item']['month'];
    $id = $_GET['cap_id'];

    $user_num      =  $statistics_cont->get_number_subscriber($id);
    $user_num      =  ($user_num  > 0) ? $user_num : 0;
    $active_user   =  $statistics_cont->get_number_subscriber_where_status($id, 1);
    $active_user   =  ($active_user  > 0) ? $active_user : 0;
    $deactive_user =  $statistics_cont->get_number_subscriber_where_status($id, 2);
    $deactive_user =  ($deactive_user  > 0) ? $deactive_user : 0;
    $hold_user     =  $statistics_cont->get_number_subscriber_where_status($id, 3);
    $hold_user     =  ($hold_user  > 0) ? $hold_user : 0;

    echo '<table class="table">
       <tr> <th class="text-right">' . $languages['home']['all'] . '</th>
         <th class="text-right">' . $languages['home']['active_user'] . '</th>
         <th class="text-right">' . $languages['home']['hold_user'] . '</th>

         <th></th>
       </tr>


         
         
           <tr>
                         
                          <td>' . $user_num . '</td>
                          <td>' . $active_user . '</td>
                          <td>' . $hold_user . '</td>
                          
                          
                       </tr>
       


       </tbody>
     </table>';
  }
}
