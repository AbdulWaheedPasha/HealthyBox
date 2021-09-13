<?php
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
    require_once '../Configuration/db.php';
    $query = "SELECT * FROM `area_tbl` WHERE `area_name_ar` LIKE '%$_GET[name]%' or `area_name_eng` LIKE '%$_GET[name]%' ";
    mysqli_set_charset($con, "utf8");
    $area_query = mysqli_query($con, $query);
    $area_rows  = mysqli_num_rows($area_query);
    $hint = "";
    if ($area_rows > 0) {
        ?>
                <table width="100%" class="table">
                    <thead>
                      <tr role="row">
                        <th >
                          الاسم باللغة الانجليزية
                        </th>
                        <th >
                          الاسم باللغة العربية 
                        </th>
                        <th >العمليات 
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
while ($arr = mysqli_fetch_array($area_query)) {
            ?>
                      <tr class="gradeA odd" role="row">
                        <td  valign="center">
                          <?php echo $arr['area_name_eng']; ?>
                        </td>
                        <td class="sorting_1"  valign="center">
                          <?php echo $arr['area_name_ar']; ?>
                        </td>
                        <td style="text-align: center;" valign="center">
                          <a href="update_area.php?area_id=<?php echo base64_encode($arr['area_id']); ?>&&pro=<?php echo base64_encode('تعديل'); ?>"
                             class="btn btn-success">
                             تعديل <i class="fa fa-edit">
                            </i>
                          </a>
                          <a href="Area.php?area_ID=<?php echo base64_encode($arr['area_id']); ?>&&pro=<?php echo base64_encode('Active'); ?>&&active=<?php echo $arr['category_active'] ?>"
                             class="btn btn-danger"> حذف
                            <i class="fa fa-external-link ">
                            </i>
                          </a>
 
                        </td>

                      </tr>

                      <?php
        } ?>
                    </tbody>
                    </table>

                    <?php
    }
}
    ?>
