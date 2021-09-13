<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $table = "";
    require_once("../Configuration/db.php");
    require_once '../lang/' . $_SESSION['lang'] . '.php';
    // require_once '../dashboard_admin/Configuration/db.php';
    // include_once('../dashboard_admin/lang/' . $_SESSION['lang'] . '.php');
    if (!empty($_POST['fromDate']) || !empty($_POST['toDate'])) {
      
        $where_query = "";
        $fromDate  = $_POST['fromDate']." 00:00:00";
        $toDate    = $_POST['toDate'] ." 00:00:00";
      
     
        
        if (!empty($_POST['fromDate']) && !empty($_POST['toDate']) ) {
            if (!empty($where_query)){
                $where_query = $where_query ."  and (`expenses_detials_date` BETWEEN '$fromDate' and '$toDate') ";
            }else {
                $where_query = "  WHERE (`expenses_detials_date` BETWEEN '$fromDate' and '$toDate') ";

            }  
        }
        else if (!empty($_POST['fromDate'])  && empty($_POST['toDate']) ) {
            if (!empty($where_query)){
                $where_query = $where_query ."  and `expenses_detials_date` = '$fromDate' ";

            }else {
                $where_query = "  WHERE `expenses_detials_date` = '$fromDate' ";
            }

        }
        else if (empty($_POST['fromDate']) && !empty($_POST['toDate'])) {
            if (!empty($where_query)){
                $where_query = $where_query ."  and `expenses_detials_date` = '$toDate' ";
            }else {
                $where_query = "  WHERE `expenses_detials_date` = '$toDate' ";

            }
        } 
        
      
        // echo  $where_query;
  
        mysqli_set_charset($con, "utf8");
        $query = "SELECT `expenses_detials_id`, `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` ".$where_query;
        // echo $query;
       
        $rs 	= mysqli_query($con, $query);
        if(mysqli_num_rows($rs) > 0){
            if ($rs) {
                $table =   '<table width="100%" class="table table-striped table-bordered table-hover" style="width: 100%;">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                            colspan="1" aria-label="Browser: activate to sort column ascending">
                            '.$languages['program']['title'].'</th>
                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending"> '.$languages['program']['cost'].'</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending"> '.$languages['program']['date'].'</th>
                      
                    </tr>
                </thead>
                <tbody>';
    
                        
                while ($arr = mysqli_fetch_array($rs)) {
                              
                    $table = $table. '<tr class="gradeA odd" role="row">
                          <td  valign="center">'.$arr['expenses_detials_name'].'</td>
                          <td  valign="center">'.$arr['expenses_detials_cost'].'</td>
                          <td  valign="center">'.$arr['expenses_detials_date'].'</td>
                          <td  valign="center"><a href="dashboard.php?type=update_expense&&id=' . base64_encode($arr['expenses_detials_id']) . '" class="btn btn-success btn-fab"> <i class="material-icons" style="margin: 0;">edit</i></a> </td>
                          <td  valign="center"><a href="dashboard.php?type=expenses&&id=' . base64_encode($arr['expenses_detials_idPrimary']) . '&&delete=' . base64_encode($) . '" class="btn btn-success btn-fab"> <i class="material-icons" style="margin: 0;">edit</i></a> </td>

                          
                          </tr>';
           }
         
    
    
                $table =   $table . '</tbody></table>';
              
                mysqli_set_charset($con, "utf8");
                $query = "SELECT  SUM(`expenses_detials_cost`) as sum FROM `expenses_detials_tbl` ".$where_query;;
               // echo $query;
                $rs 	= mysqli_query($con, $query);
                if ($rs) {
                    while ($arr = mysqli_fetch_array($rs)) {
                        $total = '<div class="well"> '.$languages['program']['cost'].'<h4> :'.$arr['sum'].'</h4></div>';
                    }
                }
             
                echo '<div class="row"><div class="col-sm-12"><div class="col-lg-12">
                <div class="panel-body">'.$table ."<br/>".$total.'</div></div></div>';
        }else{
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </b>No Result For Search.</b></div>';
        }
        
    
        }
        else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>No Result For Search.</b></div>';
   

    } else {
        mysqli_set_charset($con, "utf8");
        $query = "SELECT `expenses_detials_id`, `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` ";
      
       
        $rs 	= mysqli_query($con, $query);
        if ($rs) {
            $table =   '<table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline"
            id="dataTables-example" role="grid" aria-describedby="dataTables-example_info"
            style="width: 100%;">
            <thead>
            <tr role="row">
            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                colspan="1" aria-label="Browser: activate to sort column ascending">
                '.$languages['program']['title'].'</th>
            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                colspan="1" aria-label="Platform(s): activate to sort column ascending"> '.$languages['program']['cost'].'</th>
                <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1"
                colspan="1" aria-label="Platform(s): activate to sort column ascending"> '.$languages['program']['date'].'</th>
          
        </tr>
            </thead>
            <tbody>';

                    
            while ($arr = mysqli_fetch_array($rs)) {
                          
                $table = $table. '<tr class="gradeA odd" role="row">
                      <td  valign="center">'.$arr['expenses_detials_name'].'</td>
                      <td  valign="center">'.$arr['expenses_detials_cost'].'</td>
                      <td  valign="center">'.$arr['expenses_detials_date'].'</td>
                    
                      
                      </tr>';
  }
     


            $table =   $table . '</tbody></table>';
          
            mysqli_set_charset($con, "utf8");
            $query = "SELECT  SUM(`expenses_detials_cost`) as sum FROM `expenses_detials_tbl` WHERE `expenses_detials_date` ";
            $rs 	= mysqli_query($con, $query);
            if ($rs) {
                while ($arr = mysqli_fetch_array($rs)) {
                    $total = '<div class="well"> <h4>'.$languages['program']['cost'].' :'.$arr['sum'].'</h4></div>';
                }
            }
         
            echo '<div class="row"><div class="col-sm-12"><div class="col-lg-12">
            <div class="panel-body">'.$table ."<br/>".$total.'</div></div></div>';
    
        }
        else 
         echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         </b>Error in Excute Query.</b></div>';
    }
} else {
    
    echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <b>You need to login Again.</b></div>';
}



?>