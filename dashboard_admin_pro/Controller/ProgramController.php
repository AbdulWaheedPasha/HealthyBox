<?php
class program_controller
{
    private $program_model;
    private $con;
    public $process;
    public $user_id;
    public $user_area_id;
    public function __construct($program_model, $con)
    {
        $this->program_model = $program_model;
        $this->con = $con;
    }

    public function renew_current_program()
    {
        switch ($this->process) {
            case "insert":
                $renew_sql = "";
                break;
            case "renew":
                $renew_sql = "INSERT INTO `user_area_tbl`(`program_id`, `area_id`, 
                            `user_id`, `place_id`, `user_area_block`, `user_area_street`,
                            `user_area_avenue`, `user_area_house_num`, `user_area_building_num`, 
                            `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`,
                            `user_area_automated_figure`, `user_area_notes`, `user_area_inserted`) 
                            select `program_id`, `area_id`, `user_id`, `place_id`, `user_area_block`,
                            `user_area_street`, `user_area_avenue`, `user_area_house_num`, `user_area_building_num`,
                            `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`, 
                            `user_area_automated_figure`, `user_area_notes`, `user_area_inserted` from  `user_area_tbl` 
                            where `user_area_id` = '$this->user_area_id' ";

                break;
            case "reactive":
                $renew_sql = "INSERT INTO `user_area_tbl`(`program_id`, `area_id`, 
                            `user_id`, `place_id`, `user_area_block`, `user_area_street`,
                            `user_area_avenue`, `user_area_house_num`, `user_area_building_num`, 
                            `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`,
                            `user_area_automated_figure`, `user_area_notes`, `user_area_inserted`,) 
                            select `program_id`, `area_id`, `user_id`, `place_id`, `user_area_block`,
                            `user_area_street`, `user_area_avenue`, `user_area_house_num`, `user_area_building_num`,
                            `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`, 
                            `user_area_automated_figure`, `user_area_notes`, `user_area_inserted`,@ from  `user_area_tbl` 
                            where `user_area_id` = '$this->user_area_id' ";
                break;
        }
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $renew_sql);
        //echo mysqli_insert_id($this->con);
        return mysqli_insert_id($this->con);
    }
    
       
    public function reactive_program($user_area_id,$hold_id){
        $renew_sql = "INSERT INTO `user_area_tbl`(`program_id`, `area_id`, 
                `user_id`, `place_id`, `user_area_block`, `user_area_street`,
                `user_area_avenue`, `user_area_house_num`, `user_area_building_num`, 
                `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`,
                `user_area_automated_figure`, `user_area_notes`, `user_area_inserted`,`user_area_flag`) 
                select `program_id`, `area_id`, `user_id`, `place_id`, `user_area_block`,
                `user_area_street`, `user_area_avenue`, `user_area_house_num`, `user_area_building_num`,
                `user_area_floor`, `user_area_apartment_num`, `user_area_office_num`, 
                `user_area_automated_figure`, `user_area_notes`, `user_area_inserted`,$hold_id from  `user_area_tbl` 
                where `user_area_id` = '$user_area_id' ";
           //echo $renew_sql."<br/>";
           mysqli_set_charset($this->con, "utf8");
            $rs = mysqli_query($this->con, $renew_sql);
            //echo mysqli_insert_id($this->con);
            return mysqli_insert_id($this->con);
        }
    

    public function get_all_program()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `program_start_end_date_tbl`.`program_start_end_date_id`,
                        `user_area_tbl`.`user_area_id`,
                        `program_tbl`.`program_duration`,
                        `program_tbl`.`program_title_en`, 
                        `program_tbl`.`program_title_ar`,
                        `program_start_end_date_tbl`.`program_start_date`,
                        `program_start_end_date_tbl`.`program_start_end`
                    FROM 
                        `user_area_tbl` 
                    inner join `program_tbl` 
                        on `program_tbl`.`program_id` = `user_area_tbl`.`program_id` 
                    inner join `program_start_end_date_tbl` 
                        on `program_start_end_date_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id` where  `user_area_tbl`.`user_id` = '$this->user_id'  order by `program_start_end_date_tbl`.`program_start_end_date_id` DESC";
        //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['program_start_end_date_id']     = $row['program_start_end_date_id'];
            $prog_obj[$i]['user_area_id']          = $row['user_area_id'];
            $prog_obj[$i]['program_duration']      = $row['program_duration'];
            $prog_obj[$i]['program_title_en']      = $row['program_title_en'];
            $prog_obj[$i]['program_title_ar']      = $row['program_title_ar'];
            $prog_obj[$i]['program_start_date']    = $row['program_start_date'];
            $prog_obj[$i]['program_start_end']     = $row['program_start_end'];
            $i++;
        }

        return $prog_obj;
    }
    public function get_all_hold_status()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * FROM `hold_date_tbl`  inner join `user_area_tbl` on `user_area_tbl`.`user_area_id` = `hold_date_tbl`.`user_area_id` WHERE `user_area_tbl`.`user_id`=  '$this->user_id' ";
        //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['hold_date_id']          = $row['hold_date_id'];
            $prog_obj[$i]['hold_date_num_days']    = $row['hold_date_num_days'];
            $prog_obj[$i]['hold_date_num_date']    = $row['hold_date_num_date'];
            $prog_obj[$i]['hold_date_resume']      = $row['hold_date_resume'];

            $i++;
        }

        return $prog_obj;
    }
    public function resume_date_from_hold($hold_date_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT * FROM 
                        `program_start_end_date_tbl` 
                        INNER Join  
                        `user_area_tbl` on
                        `user_area_tbl`.`user_area_id` = `program_start_end_date_tbl`.`user_area_id` where `user_area_tbl`.`user_area_flag` =  '$hold_date_id'  ";
                       // echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
           //print_r($row);
            $prog_obj['program_start_date']      = $row['program_start_date'];
           
            
        }

        return $prog_obj;
    }
    public function select_program_where_id()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT 
                        `user_area_tbl`.`user_area_id`,
                        `program_tbl`.`program_title_en`, 
                        `program_tbl`.`program_title_ar`,
                        `program_start_end_date_tbl`.`program_start_date`,
                        `program_start_end_date_tbl`.`program_start_end`
                    FROM 
                        `user_area_tbl` 
                    inner join `program_tbl` 
                        on `program_tbl`.`program_id` = `user_area_tbl`.`program_id` 
                    inner join `program_start_end_date_tbl` 
                        on `program_start_end_date_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id` where  `user_area_tbl`.`user_id` = '$this->user_id' ";
        //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['user_area_id']          = $row['user_area_id'];
            $prog_obj[$i]['program_title_en']      = $row['program_title_en'];
            $prog_obj[$i]['program_title_ar']      = $row['program_title_ar'];
            $prog_obj[$i]['program_start_date']    = $row['program_start_date'];
            $prog_obj[$i]['program_start_end']     = $row['program_start_end'];
            $i++;
        }

        return $prog_obj;
    }


    public function insert_program_date()
    {
        $start_date = $this->program_model->start_date;
        $end_date   = $this->program_model->end_date;
        $program_id =  $this->program_model->program_id;
        $insert_date_program_query = "INSERT INTO `program_start_end_date_tbl`(`program_start_date`, `program_start_end`, `user_area_id`) 
                                        VALUES('$start_date','$end_date','$program_id') ";
       // echo  $insert_date_program_query."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $insert_date_program_query);
        return $rs;
    }



    public function search_program_date()
    {
        $start_date = $this->program_model->start_date;
        $user_id    = $this->program_model->user_id;
        $current_program_select = "SELECT 
                                    `user_area_tbl`.`user_area_id`
                                FROM 
                                    `user_area_tbl` 
                                inner join `program_tbl` 
                                    on `program_tbl`.`program_id` = `user_area_tbl`.`program_id` 
                                inner join `program_start_end_date_tbl` 
                                    on `program_start_end_date_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id`  where 
                                    `program_start_end_date_tbl`.`program_start_date` <=  '$start_date'
                                     and  `program_start_end_date_tbl`.`program_start_end` >= '$start_date'  
                                     and `user_area_tbl`.`user_id` = '$user_id' ";
        //echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        //echo mysqli_num_rows($rs)."<br/>";
        return mysqli_num_rows($rs);
    }

    public function get_last_program()
    {
        $prog_obj = array();
        $start_date = $this->program_model->start_date;
        $user_id    = $this->program_model->user_id;
        $current_program_select = "SELECT 
                                 `user_area_tbl`.`user_area_id`,
                             FROM 
                                 `user_area_tbl` 
                             inner join `program_tbl` 
                                 on `program_tbl`.`program_id` = `user_area_tbl`.`program_id` 
                             inner join `program_start_end_date_tbl` 
                                 on `program_start_end_date_tbl`.`user_area_id` = `user_area_tbl`.`user_area_id`  where 
                                 `program_start_end_date_tbl`.`program_start_date` between  '$start_date' and '$start_date' and `user_area_tbl`.`user_id` = '$user_id' ORDER BY `user_area_tbl`.`user_area_id` DESC LIMIT 1 ";
        // echo  $current_program_select;
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        while ($row = mysqli_fetch_array($rs)) {
            $prog_obj['user_area_id']          = $row['user_area_id'];
            $prog_obj['program_title_en']      = $row['program_title_en'];
            $prog_obj['program_title_ar']      = $row['program_title_ar'];
            $prog_obj['program_start_date']    = $row['program_start_date'];
            $prog_obj['program_start_end']     = $row['program_start_end'];
        }
        return $prog_obj;
    }

    public function last_id_inserted_date_time()
    {
        $current_program_select = "SELECT max(`program_start_end_date_id`) as max FROM `program_start_end_date_tbl` ";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        while ($row = mysqli_fetch_array($rs)) {
            $prog_obj['max']          = $row['max'];
        }
        return $prog_obj;
    }
    public function select_programe_details_where_id($program_id)
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT `program_duration` FROM `program_tbl` WHERE `program_id` =  '$program_id' ";
        //echo  $query;
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj['program_duration']          = $row['program_duration'];
        }

        return $prog_obj;
    }





}
