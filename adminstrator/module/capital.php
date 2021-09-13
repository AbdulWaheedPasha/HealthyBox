<?php 
// capital
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
	require_once 'header.php';
	$where_query = "";
	$sql = "SELECT `capital_id` as id, `capital_en_title` as en,   `capital_ar_title`  as ar FROM `capital_tbl` ";
	 mysqli_set_charset($con, "utf8");
	$rs_query = mysqli_query($con,$sql);
	$num_rows  = mysqli_num_rows($rs_query); 

    if($_SESSION['role_id'] == "1") {
   ?>
   <a href="dashboard.php?type=add_new_cap" class="btn btn-primary btn-round"><?php  echo $languages['cap_page']['title'];?><div class="ripple-container"></div></a>
   <?php
    }
    if($num_rows > 0 ){
    ?>
   <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title "><?php  echo $languages['cap_page']['main']; ?></h4>
                   <p><?php  echo $languages['cap_page']['show']; ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table  id="example" class="display" style="width:100%">                
                    <thead class=" text-primary">
                    <tr>
                       
                        <th><?php echo $languages['cap_page']['name_ar']; ?></th>
                        <th><?php echo $languages['cap_page']['name_en']; ?></th>
                        <?php
                         if($_SESSION['role_id'] == "1") {
                        ?>
                        <th class="hidden-xs"><?php echo $languages['area_page']['process']; ?></th>
                        <?php
                         }
                         ?>

                    </tr> 
                  </thead>
                  <tbody>
                      <?php
                       while ($arr = mysqli_fetch_array($rs_query)) {
                           echo '<tr class="text-primary">
                          
                                    <td class="hidden-xs">'.$arr['ar'].'</td>
                                    <td class="hidden-xs">'.$arr['en'].'</td>';
                                    if($_SESSION['role_id'] == "1") {
                                        echo '<td><a href="dashboard.php?type=update_capital&&id='.base64_encode(base64_encode(base64_encode($arr['id']))).'"   class="btn btn-primary btn-round btn-fab"><i class="material-icons" style="margin: 0;">edit</i><div class="ripple-container"></div></a></td>';
                                    }
                                echo '</tr>';

                       }


?>
                        </tbody>
                </table>
                  </div>
                </div>
              </div>
            </div>
          

                <?php
   }
  }
   ?>


