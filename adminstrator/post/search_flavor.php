<?php 
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    $table = "";
    require_once '../Configuration/db.php';
$errorMSG = "";
$name     = "";

// echo $_POST["text_flavor"];
if (empty($_POST["text_flavor"])) {
    $errorMSG = "يرجي كتابة المراد البحث عنه";
} else {
    $name = $_POST["text_flavor"];
 
    // Change character set to utf8
    mysqli_set_charset($con, "utf8");
    $flav_query =  "SELECT * FROM `additions_tbl` inner JOIN `additions_item_tbl` ON `additions_tbl`.`additions_id` = `additions_item_tbl`.`additions_id` 
                    where  `additions_tbl`.`additions_name_ar` LIKE '%$name%' or `additions_item_tbl`.`additions_item_ar_name` LIKE '%$name%'   ";
   ///echo  $flav_query ;
    $rs           = mysqli_query($con,$flav_query);
    $all_num_rows = mysqli_num_rows($rs);
    

    ?>
   
   <table class="table table-hover">
                                    <thead>
                                        <tr >
   
                                            <td>
                                                الاسم باللغة العربية</td>
                                            <td >العمليات</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
while ($arr = mysqli_fetch_array($rs)) {
    ?>
                                        <tr class="gradeA odd" role="row">

                                            
                                            <td valign="center">
                                                <?php echo $arr['additions_name_ar']; ?>
                                            </td>
                                            <td style="text-align: center;" valign="center">
                                            
                                            
    
                                                <!-- view items additions  -->
                                                <a href="add_new_items.php?additions_id=<?php echo base64_encode(base64_encode($arr['additions_id'])); ?>" class="btn btn-danger btn-circle" ><i class="fa fa-plus"></i></a>

                                                
                                            
                                             <a href="AdditionsUpdate.php?additions_id=<?php echo base64_encode($arr['additions_id']); ?>&&pro=<?php echo base64_encode('edit'); ?>"
                                                    class="btn btn-outline btn-warning btn-circle"><i class="fa fa-edit"></i></a>


                                               



                                                <a href="./items.php?additions_id=<?php echo base64_encode(base64_encode($arr['additions_id'])); ?>" class="btn btn-success btn-circle" ><i
                                                        class="fa fa fa-sitemap"></i></a>

                                               
                                               
                                                    
                                                
        <a href="./additional_item_details.php?additions_id=<?php echo base64_encode(base64_encode($arr['additions_id'])); ?>" 
class="btn btn-warning btn-circle" >                               <i class="fa fa-eye"></i></a>

<?php
                                                    
                                                    // echo $arr_mysqli_fetch_array['additions_active'];
                                                     switch ($arr['additions_active']) {
                                                         case 1: {
                                                             echo '<a class="btn btn-info btn-circle" href="Flavors.php?additions_id='.base64_encode($arr['additions_id']).'&&active_id='.base64_encode(0) . '"><em class="fa fa-check-square"></em></a>';
                                                         }
                                                             break;
                                                         case 0: {
                                                             echo '<a class="btn btn-info btn-circle" href="Flavors.php?additions_id='.base64_encode($arr['additions_id']).'&&active_id=' . base64_encode(1) . '"><em class="fa fa-times-circle"></em></a>';
                                                         }
                                                             break;
                                                             
                                                     }
                                                     
    $value_active = ""; ?>
                                                              

                        </td>







                        </tr>
                        <?php
}
?>

                        </tbody>
                        </table>

    <?php
}
} else {
    session_destroy();
    header('Location:../index.php?err=1');
    exit();
}



?>