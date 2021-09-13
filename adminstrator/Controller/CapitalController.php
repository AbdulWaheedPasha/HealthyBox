<?php
class capital_controller
{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
    }


    public function get_capital_tbl()
    {

        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `capital_id`, `capital_en_title`, `capital_ar_title` FROM `capital_tbl`" ;
    ///  echo $query;
        $result = mysqli_query($this->con, $query);
       // print_r($result);
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            $prog_obj[$i]['capital_id']            = $row['capital_id'];
            $prog_obj[$i]['capital_en_title']               = $row['capital_en_title'];
            $prog_obj[$i]['capital_ar_title']               = $row['capital_ar_title'];

            $i++;
        }

        return $prog_obj;
    }
    
}
