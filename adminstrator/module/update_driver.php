<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
// update_driver.php
if(isset($_GET['id'])){
    $area_id_arr = array();
    $counter = 0;
    $driver_id = base64_decode($_GET['id']);
    $user_sql = "SELECT *,(SELECT `administration_type_name_ar` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_ar,(SELECT `administration_type_name_en` FROM `administration_type_tbl` WHERE `administration_type_id` = admin.`administration_type_id`) as type_en FROM `administration_tbl` as admin Where `administration_id`  = $driver_id  ";
    // echo $user_sql ;
    mysqli_set_charset($con,"utf8");
    $rs = mysqli_query($con,$user_sql);
    $all_num_rows = mysqli_num_rows($rs);
    while ($arr = mysqli_fetch_array($rs)) {
        $driver_id = base64_decode($_GET['id']);
        $driver_area_sql = "SELECT `area_id` FROM `user_area_tbl` WHERE `user_id` = $driver_id  ";
        // echo $user_sql ;
        mysqli_set_charset($con,"utf8");
        $driver_area_rs = mysqli_query($con,$driver_area_sql);
        $all_num_rows = mysqli_num_rows($driver_area_rs);
        while ($driver_area_arr = mysqli_fetch_array($driver_area_rs)) {
            $area_id_arr[$counter] = $driver_area_arr['area_id'];
            $counter++;
        }
    ?>

<div class="col-md-12">

<?php
if(isset($_GET['operation']) && isset($_GET['driver_area_id'])){
    $message_error = base64_decode($_GET['operation']);
    $driver_area_id = base64_decode(base64_decode(base64_decode($_GET['driver_area_id'])));
    switch ($message_error) {
 
    
            case "delete":
              //echo  "DELETE FROM `driver_capital_tbl` WHERE `driver_capital_id` =  $driver_area_id ";
              $active_mysqli_query = mysqli_query($con, "DELETE FROM `driver_capital_tbl` WHERE `driver_capital_id` =  $driver_area_id ");

              if($active_mysqli_query){
                echo  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </b>'.$languages['cap_page']['delete'].'</b></div>';
            }
       
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

              <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title "><?php echo $languages['driver']['update']; ?></h4>
                
                </div>
                <div class="card-body">
                  <div >
                  <form action="./post/update_driver.php" method="post" enctype="multipart/form-data"
                                            name="form" id="form">
                                            <input class="form-control" type="hidden" name="id" value="<?php echo $arr['administration_id']; ?>">

                                            <div class="form-group" id="Result"></div>
                                            <div class="form-group">
                                                <label><?php echo $languages['driver']['name']; ?>
                                                </label>
                                                <input class="form-control" name="RealUserName" value="<?php echo $arr['administration_name']; ?>">
                                            </div>
                                          
                                         
                                            <div class="form-group">
                                                <label><?php echo $languages['driver']['telep']; ?>
                                                </label>
                                                <input class="form-control"  name="Telephone" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) return false;" maxlength="8"  value="<?php echo $arr['administration_telephone_number']; ?>">
                                            </div>

                                            <div class="form-group">
                        <label><?php echo $languages['login']['username']; ?>
                        </label>
                        <input class="form-control" name="username" type="text" value="<?php echo base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_username'])))); ?>" id="username" >
                                            </div>
                                              
                                            <div class=" form-group">
                        <label><?php echo $languages['login']['password']; ?>
                        </label>
                        <input class="form-control" name="password"  type="text" value="<?php echo base64_decode(base64_decode(base64_decode(base64_decode($arr['administration_password'])))); ?>" id="password" >
                    </div>



                    <script>
                $('#username').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                $('#password').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                </script>
                                            


                                            <div class="form-group">
                                        
                    <?php

$query = "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl`  WHERE `capital_id` NOT IN (SELECT `capital_id`  FROM `driver_capital_tbl` WHERE `driver_id` =  $driver_id  )  ";
                                                    // echo $query;
?>
                                                <select id="demo3"  multiple="multiple" name="area_id[]" class="form-control" >
                                                <?php
                            mysqli_set_charset($con, "utf8");
                            $area_query = mysqli_query($con, $query);
                            $area_rows  = mysqli_num_rows($area_query);
                            while ($arr = mysqli_fetch_array($area_query)) {

                                $title = ($_SESSION['lang'] == "en") ? $arr['capital_en_title'] : $arr['capital_ar_title'];
                                echo '<option value="' . $arr['capital_id'] . '">' . $title . '</option>';
                            }
                            ?>
               
               </select>
                                            </div>
                        
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="submitForm"  class="btn btn-primary btn-round" ><?php echo $languages['bttn_lbl']['save']; ?></button>
                                    </div>


                                    <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title "><?php echo $languages ['menu_item']['capitial']; ?> : </h4>

                </div>
                <div class="card-body">
                <input id="myInput" type="text" placeholder="Search..">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                      <tr>
                       
                       <th class="hidden-xs"><?php echo $languages ['menu_item']['capitial']; ?></th>
                       <th><?php echo $languages['cap_page']['name_en']; ?></th>
                       <th><?php echo $languages['cap_page']['name_ar']; ?></th>
                   </tr>
                     </thead>
                      <tbody id="myTable">
                          <?php
$query = "SELECT * FROM `capital_tbl` LEFT JOIN  `driver_capital_tbl` on  `driver_capital_tbl`.`capital_id` = `capital_tbl`.`capital_id` where `driver_capital_tbl`.`driver_id` =  $driver_id  ";
// echo $query;
 mysqli_set_charset($con, "utf8");
$area_query = mysqli_query($con,$query);
$area_rows  = mysqli_num_rows($area_query);
while ($arr = mysqli_fetch_array($area_query)) {
  // print_r();
    ?>
  <tr>
                      <td class="td-actions">
                            <a href="dashboard.php?type=update_driver&&driver_area_id=<?php echo base64_encode(base64_encode(base64_encode($arr['driver_capital_id'])));?>&&operation=<?php echo base64_encode('delete');?>&&id=<?php echo $_GET['id']; ?>" class="btn btn-danger" >
                              <i class="material-icons" style="margin: 0;">delete</i>
                            </a>
                          </td>
                

                        <td><?php echo  $arr['capital_en_title']; ?></td>
                       
                        <td><?php echo  $arr['capital_ar_title']; ?></td>
                      </tr>
    <?php
}

?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                  </div>
   
                  
                </div>
              </div>
            </div>

     <script>
      $(document).ready(function(){
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    </script>

            <script>

     $("#demo3").easySelect({
      buttons: true, //
        search: true,
        placeholder: '<?php echo $languages['area']['pro']; ?>',
        placeholderColor: 'green',
        selectColor: '#524781',
        itemTitle: '<?php echo $languages['area']['pro']; ?>',
        showEachItem: false,
        width: '100%',
        dropdownMaxHeight: '450px',
     })
     </script>
     <script src="https://code.jquery.com/jquery-3.5.1.js"  "></script>
     <script>
     $(document).ready(function () {
    $("#form").on("submit", function(e) {
       
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
              var jsonData = JSON.parse(data);
                    if (jsonData.result == "1") {
                        Notify.suc({
                            title: 'OK',
                            text: jsonData.message,
                        });
                        $("form").trigger("reset");
                        setTimeout(function(){
                            window.location.href = 'dashboard.php?type=update_driver&&id=<?php echo $_GET['id']  ?>'
                        }, 3000);
                    } else {
                        Notify.suc(jsonData.message);
                    }
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
    $("#submitForm").on('click', function() {
       $("#form").submit();
    });
});
</script>


 
        

    <?php

}

}
}

?>