<?php
class user_address_controller
{
    private $user_model;
    private $con;

    public function __construct($user_model, $con)
    {
        $this->user_model = $user_model;
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
    
    public function select_address_where_program_id()
    {
        $user_area_id =  $this->user_model->get_user_area_id();
        $prog_obj = Array();
        mysqli_set_charset($this->con, "utf8");
        $current_program_select = "SELECT  `program_id`, `area_id`, `user_id`, `place_id`,
                                            `user_area_block`, `user_area_street`, `user_area_avenue`,
                                            `user_area_house_num`, `user_area_building_num`, `user_area_floor`, 
                                            `user_area_apartment_num`, `user_area_office_num`, `user_area_automated_figure`, 
                                            `user_area_notes`, `user_area_inserted`, `user_area_flag` FROM `user_area_tbl` 
                                             WHERE  `user_area_id` = '$user_area_id'  ";
       // echo  $current_program_select."<br/>";
      
        $rs = mysqli_query($this->con, $current_program_select);
        while ($row = mysqli_fetch_array($rs)) {
            $this->user_model->set_program_id($row['program_id']);
            $this->user_model->set_user_area_id($row['area_id']);
            $this->user_model->set_place_id($row['place_id']);
            $this->user_model->set_user_area_block($row['user_area_block']);
            $this->user_model->set_user_area_street($row['user_area_street']);
            $this->user_model->set_user_area_avenue($row['user_area_avenue']);
            $this->user_model->set_user_area_house_num($row['user_area_house_num']);
            $this->user_model->set_user_area_building_num($row['user_area_building_num']);
            $this->user_model->set_user_area_floor($row['user_area_floor']);
            $this->user_model->set_user_area_apartment_num($row['user_area_apartment_num']);
            $this->user_model->set_user_area_office_num($row['user_area_office_num']);
            $this->user_model->set_user_area_automated_figure($row['user_area_automated_figure']);
            $this->user_model->set_user_area_notes($row['user_area_notes']);
        }

    }

    public function select_user_personal_info_where_id()
    {
        $user_id =  $this->user_model->get_user_id();
        $prog_obj = Array();
        $current_program_select = "SELECT  `administration_name`, `administration_username`,
                                            `administration_password`, `administration_telephone_number`, 
                                            `administration_telephone_number1`,`administration_date_registeration` 
                                            FROM `administration_tbl` WHERE  `administration_id` = '$user_id' ";
        //echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        while ($row = mysqli_fetch_array($rs)) {
            $this->user_model->set_administration_name($row['administration_name']);
            $this->user_model->set_administration_username(base64_decode(base64_decode(base64_decode(base64_decode($row['administration_username'])))));
            $this->user_model->set_administration_password(base64_decode(base64_decode(base64_decode(base64_decode($row['administration_password'])))));
            $this->user_model->set_administration_telephone_number($row['administration_telephone_number']);
            $this->user_model->set_administration_telephone_number1($row['administration_telephone_number1']);
        }

    }

    public function search_username_password()
    {
        $user_id =  $this->user_model->get_user_id();

        $username =  $this->user_model->get_administration_username();
        $password =  $this->user_model->get_administration_password();
        $prog_obj = Array();
        $current_program_select = "SELECT * FROM `administration_tbl` WHERE  (`administration_username` = '$username' && `administration_password` = '$password' ) && `administration_id` <> '$user_id'  " ;
       // echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        return mysqli_num_rows($rs);

    }

    public function search_username_password_register()
    {

        $username =  $this->user_model->get_administration_username();
        $password =  $this->user_model->get_administration_password();
        $prog_obj = Array();
        $current_program_select = "SELECT * FROM `administration_tbl` WHERE `administration_username` = '$username' AND `administration_password` = '$password'   " ;
        //echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        //echo mysqli_num_rows($rs);
        return mysqli_num_rows($rs);

    }

    public function search_username_like_telephone($telephone)
    {
        $prog_obj = Array();
        $current_program_select = "SELECT `administration_id` FROM `administration_tbl` WHERE `administration_telephone_number` = '$telephone' and `administration_type_id` = '5' and  `administration_id` = '1' " ;
        echo  $current_program_select."<br/>";
        mysqli_set_charset($this->con, "utf8");
        $rs = mysqli_query($this->con, $current_program_select);
        //echo mysqli_num_rows($rs);
        $arr_id = mysqli_fetch_row($rs);
        return  $arr_id[0];

    }









}
