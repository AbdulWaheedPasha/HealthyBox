
<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>

  
<div class="col">
   <a href="dashboard.php?type=add_new_expen" class="btn btn-primary btn-round"><?php  echo $languages['program']['add_exp'];?><div class="ripple-container"></div></a>
   
</div>          
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css"></script>
        <script>
            // $(document).ready(function() {
            //     $('#example').DataTable();
            // });
            $(document).ready(function() {
                $('#exp').DataTable();
            });
        </script>


<div class="col-md-12">




            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title "><?php    echo $languages['payment_table']['expenses']; ?></h4>
                <p class="card-category"><?php echo $languages['payment_table']['expenses_header'];    ?></p>
              </div>
              <div class="card-body">
                <div >
                <form action="dashboard.php?type=expenses" method="post" enctype="multipart/form-data" name="formExpenses"
                                id="formExpenses">
                                <div class="panel-body">
                                    <p>

                                        <div class="form-group">
                                            <label><?php echo $languages['payment_table']['to'];    ?> : </label>
                                            <input class="form-control" type="date" name="fromDate" value="" id="fromDate">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $languages['payment_table']['from'];    ?> :</label>
                                            <input class="form-control" name="toDate" type="date" value="" id="toDate">
                                            <p class="help-block"></p>
                                        </div>








                                    </p>
                                </div>
                                <div class="modal-footer">
                                <input type="submit" name="submit" value="<?php echo $languages['bttn_lbl']['search'];    ?> " class="btn btn-default">
                               
                            </div>


                            </form>
                           


            <div>


   
<?php
$total=0;
                // area
if(isset($_GET['delete']) && isset($_GET['id'])){
    $message_error = base64_decode($_GET['delete']);
    $Category_ID   = base64_decode($_GET['id']);
    switch ($message_error) {

            case "Delete":
              $active_mysqli_query = mysqli_query($con, "DELETE FROM `expenses_detials_tbl` WHERE `expenses_detials_tbl`.`expenses_detials_id` = $Category_ID ");

              echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              </b>'.$languages['cap_page']['delete'].'</b></div>';
       
                  break;
        case "empty_field":
        echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b> '.$languages['cap_page']['empty_field'].'</b></div>';
            break; 
        case "login_again":
            echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b> '.$languages['cap_page']['empty_field'].'</b></div>';
         break;
 
            
        default:{
            
           
        }
     
    }
 
 }


?> 
            
            <?php

                require_once("./Configuration/db.php");
                require_once './lang/' . $_SESSION['lang'] . '.php';
                 $table =  '<table id="exp" class="table table-striped table-bordered" style="width:100%">
                            <thead>
            
                            <th>'.$languages['program']['title'].'</th>
                            <th>'.$languages['program']['cost'].'</th>
                            <th>'.$languages['program']['date'].'</th>';
                
                            if ($_SESSION['role_id'] == "1") {
                                $table = $table  . '<th> '.$languages['area']['process'].'</th>';
                              }
                              $table = $table .'</thead>';
                          
             if(isset($_POST['submit'])){
        
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
                    
                  
            //         // echo  $where_query;
              
                    mysqli_set_charset($con, "utf8");
                    $query = "SELECT `expenses_detials_id`, `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` ".$where_query;
                   // echo $query;
                   
                    $rs 	= mysqli_query($con, $query);
                  
                }
                
            }else{
                //echo "here";
                mysqli_set_charset($con, "utf8");
                $query  = "SELECT `expenses_detials_id`, `expenses_detials_cost`, `expenses_detials_date`, `expenses_type_id`, `expenses_detials_name`, `branch_id` FROM `expenses_detials_tbl` ";
                $rs 	= mysqli_query($con, $query);
            }

            if(mysqli_num_rows($rs) > 0){
                if ($rs) {
                    while ($arr = mysqli_fetch_array($rs)) {
                        $total +=  $arr['expenses_detials_cost']; 
                        $table = $table. '<tr>
                              <td  valign="center">'.$arr['expenses_detials_name'].'</td>
                              <td  valign="center">'.$arr['expenses_detials_cost'].'</td>
                              <td  valign="center">'.$arr['expenses_detials_date'].'</td>';
                       if ($_SESSION['role_id'] == "1") {
                        $table = $table.' <td  valign="center"><a href="dashboard.php?type=update_expense&&id=' . base64_encode($arr['expenses_detials_id']) . '" class="btn btn-success btn-fab"> <i class="material-icons" style="margin: 0;">edit</i></a> 
                                       <a href="dashboard.php?type=expenses&&id=' . base64_encode($arr['expenses_detials_id']) . '&&delete=' . base64_encode("Delete") . '" class="btn btn-danger btn-fab"> <i class="material-icons" style="margin: 0;">delete</i></a> </td> ';
                                        
                                              }

                      $table = $table.'</tr>';
                    }
                }
            }

            $table =   $table . '</tbody></table>';
            echo  $table;

           
?>

<div class="card">
            
<div class="card-header card-header-primary">
            
                <p class="card-category"><?php echo  $total; ?></p>
              </div>

</div>

</div>       
                </div>
 
                
              </div>
            </div>
          </div>

<?php
}
?>