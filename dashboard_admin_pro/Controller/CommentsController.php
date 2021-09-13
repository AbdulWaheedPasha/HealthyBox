<?php 
class comment_controller{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function fetch_comment_disview()
    {
        $counter_sql = " SELECT count(*)  as counter FROM `comment_driver_tbl` WHERE `comment_driver_view` = 0 ";
          //echo $query;
          $result = mysqli_query($this->con, $counter_sql);
          while ($row = mysqli_fetch_array($result)) {
              $prog_obj['counter']            = $row['counter'];
          }
          return $prog_obj;
    }

    public function fetc_num_new_user()
    {
        $counter_sql = "SELECT count(*) as counter FROM `administration_tbl` WHERE `administration_active` = 4 ";
        //   echo $counter_sql;
          $result = mysqli_query($this->con, $counter_sql);
          while ($row = mysqli_fetch_array($result)) {
              $prog_obj['counter']            = $row['counter'];
          }
          return $prog_obj;
    }

}

?>