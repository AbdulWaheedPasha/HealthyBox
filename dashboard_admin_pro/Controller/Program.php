<?php
class all_program_controller
{
 
    private $con;
    public  $program_id;
    public function __construct($con)
    {
        $this->con = $con;
    }
    function get_program_id()
    {
        return $this->program_id;
    }
    public function get_program()
    {

        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `program_id`, `program_title_ar` as type_ar,`program_active`,`program_title_en` as type_en , `program_duration`, `program_cost`, `program_discount` FROM `program_tbl` ORDER By `program_id` DESC ";
    ///  echo $query;
        $result = mysqli_query($this->con, $query);
       // print_r($result);
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            $prog_obj[$i]['program_id']            = $row['program_id'];
            $prog_obj[$i]['type_ar']               = $row['type_ar'];
            $prog_obj[$i]['type_en']               = $row['type_en'];
            $prog_obj[$i]['program_duration']      = $row['program_duration'];
            $prog_obj[$i]['program_cost']          = $row['program_cost'];
            $prog_obj[$i]['program_discount']      = $row['program_discount'];
            $prog_obj[$i]['program_active']      = $row['program_active'];
            $i++;
        }

        return $prog_obj;
    }

    public function fetc_cat()
    {

        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * FROM `category_tbl` order by `category_id` DESC ";
    ///  echo $query;
        $result = mysqli_query($this->con, $query);
       // print_r($result);
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            $prog_obj[$i]['program_id']            = $row['category_id'];
            $prog_obj[$i]['type_ar']               = $row['category_title_ar'];
            $prog_obj[$i]['type_en']               = $row['category_title_en'];
            $i++;
        }

        return $prog_obj;
    }

    public function get_program_where_id($program_id)
    {

        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `category_id`,`program_ar_describe`, `program_en_describe`,`program_color_id`,`program_id`, `program_title_ar` as type_ar,`program_active`,`program_title_en` as type_en , `program_duration`, `program_cost`, `program_discount`,`program_image_path` FROM `program_tbl`  where  `program_id` = '$program_id' ";
        $result = mysqli_query($this->con, $query);
       // print_r($result);
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            $prog_obj['program_id']            = $row['program_id'];
            $prog_obj['type_ar']               = $row['type_ar'];
            $prog_obj['type_en']               = $row['type_en'];
            $prog_obj['program_duration']      = $row['program_duration'];
            $prog_obj['program_cost']          = $row['program_cost'];
            $prog_obj['program_discount']      = $row['program_discount'];
            $prog_obj['program_active']      = $row['program_active'];
            $prog_obj['program_image_path']      = $row['program_image_path'];
            $prog_obj['program_ar_describe']      = $row['program_ar_describe'];
            $prog_obj['program_en_describe']      = $row['program_en_describe'];
            $prog_obj['program_color_id']              = $row['program_color_id'];
            $prog_obj['category_id']              = $row['category_id'];
            $i++;
        }

        return $prog_obj;
    }

    public function fetc_color()
    {

        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `color_id`, `color_name` FROM `color_tbl` ";
    ///  echo $query;
        $result = mysqli_query($this->con, $query);
       // print_r($result);
        while ($row = mysqli_fetch_array($result)) {
            // print_r($row);
            $prog_obj[$i]['color_id']            = $row['color_id'];
            $prog_obj[$i]['color_name']               = $row['color_name'];
    
            $i++;
        }

        return $prog_obj;
    }
}

