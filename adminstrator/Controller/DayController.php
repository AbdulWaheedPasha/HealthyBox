<?php
class day_controller
{
    private $program_day_mode;
    private $con;
    public $process;
    public $user_id;
    public $user_area_id;
    public function __construct($program_day_model, $con)
    {
        $this->program_day_model = $program_day_model;
        $this->con = $con;
    }
    public function get_program_day_tbl($user_area_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `program_day_id`,`program_day_en`, `program_day_ar`, `program_day_date` FROM `program_day_tbl` WHERE `program_start_end_date_id` = '$user_area_id' ";
        //echo $query;
        $i = 0;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['program_day_id']        = $row['program_day_id'];
            $prog_obj[$i]['program_day_en']        = $row['program_day_en'];
            $prog_obj[$i]['program_day_ar']        = $row['program_day_ar'];
            $prog_obj[$i]['program_day_date']      = $row['program_day_date'];
            $i++;
        }
        return $prog_obj;
    }

    public function get_address_where_program_id($user_area_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * FROM `user_area_tbl` 
                inner join `area_tbl` on `user_area_tbl`.`area_id` = `area_tbl`.`area_id`
                INNER JOIN `place_type_tbl` on `place_type_tbl`.`place_type_id` = `user_area_tbl`.`place_id` 
                INNER JOIN `program_tbl` on `program_tbl`.`program_id` = `user_area_tbl`.`program_id` 
                INNER JOIN `program_start_end_date_tbl` on `program_start_end_date_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id` where `user_area_tbl`.`user_area_id` = '$user_area_id' ";
       //echo $query;  
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['area_id']          = $row['area_id'];

            $prog_obj['user_area_id']          = $row['user_area_id'];
            $prog_obj['user_area_block']      = $row['user_area_block'];
            $prog_obj['user_area_street']      = $row['user_area_street'];
            $prog_obj['user_area_avenue']      = $row['user_area_avenue'];
            $prog_obj['user_area_house_num']    = $row['user_area_house_num'];
            $prog_obj['user_area_office_num']     = $row['user_area_office_num'];
            $prog_obj['user_area_automated_figure']      = $row['user_area_automated_figure'];
            $prog_obj['user_area_notes']        = $row['user_area_notes'];
            $prog_obj['user_area_inserted']     = $row['user_area_inserted'];
            $prog_obj['place_type_eng']         = $row['place_type_eng'];
            $prog_obj['place_type_ar']          = $row['place_type_ar'];
            $prog_obj['area_name_eng']          = $row['area_name_eng'];
            $prog_obj['area_name_ar']           = $row['area_name_ar'];
            $prog_obj['user_area_building_num']           = $row['user_area_building_num'];
            $prog_obj['user_area_notes']           = $row['user_area_notes'];
            $prog_obj['user_area_floor']           = $row['user_area_floor'];
            $prog_obj['user_area_apartment_num']           = $row['user_area_apartment_num'];
            $prog_obj['place_id']           = $row['place_id'];
            $prog_obj['program_duration']           = $row['program_duration'];
            $prog_obj['program_title_en']          = $row['program_title_en'];
            $prog_obj['program_title_ar']           = $row['program_title_ar'];
            $prog_obj['program_start_date']          = $row['program_start_date'];
            $prog_obj['program_start_date']          = $row['program_start_date'];
            $prog_obj['program_start_end_date_id']           = $row['program_start_end_date_id'];
            $prog_obj['user_area_driver_notes']           = $row['user_area_driver_notes'];
        }
        return $prog_obj;
    }

    public function insert_day_time_table()
    {
        $model = $this->program_day_model;
        $current_program_select = "INSERT INTO `program_day_tbl`(`program_day_en`, `program_day_ar`, `program_day_date`, `program_start_end_date_id`, `program_day_flag`) 
                                                         VALUES ('$model->day_en','$model->day_ar','$model->date','$model->program_id','0')";
        //echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        return mysqli_insert_id($this->con);
    }
}
