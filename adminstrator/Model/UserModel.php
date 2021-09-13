<?php
class user_model
{   
        #region Member Variables
        private  $user_area_id;
        private  $program_id;
        private  $area_id;
        private  $user_id;
        private  $place_id;
        private  $user_area_block;
        private  $user_area_street;
        private  $user_area_avenue;
        private  $user_area_house_num;
        private  $user_area_building_num;
        private  $user_area_floor;
        private  $user_area_apartment_num;
        private  $user_area_office_num;
        private  $user_area_automated_figure;
        private  $user_area_notes;
        private  $administration_name;
        private  $administration_telephone_number;
        private  $administration_telephone_number1;
        private  $administration_username;
        private  $administration_password;
        #endregion

        #region Constructors

        // function __construct($user_area_id,$program_id,  $area_id,  $user_id,  $place_id,  $user_area_block,  $user_area_street,  $user_area_avenue,  $user_area_house_num,  $user_area_building_num,  $user_area_floor,  $user_area_apartment_num,  $user_area_office_num,  $user_area_automated_figure,  $user_area_notes, $user_area_inserted,  $user_area_flag)
        // {
        //     $this->_user_area_id = $user_area_id;
        //     $this->program_id    = $program_id;
        //     $this->area_id       = $area_id;
        //     $this->user_id       = $user_id;
        //     $this->place_id      = $place_id;
        //     $this->user_area_block  = $user_area_block;
        //     $this->user_area_street = $user_area_street;
        //     $this->user_area_avenue = $user_area_avenue;
        //     $this->user_area_house_num = $user_area_house_num;
        //     $this->user_area_building_num = $user_area_building_num;
        //     $this->user_area_floor = $user_area_floor;
        //     $this->user_area_apartment_num = $user_area_apartment_num;
        //     $this->user_area_office_num = $user_area_office_num;
        //     $this->user_area_automated_figure = $user_area_automated_figure;
        //     $this->user_area_notes = $user_area_notes;
        //     $this->user_area_inserted   = $user_area_inserted;
        //     $this->user_area_flag      = $user_area_flag;
        
        // }
        #endregion
        #region Public Properties
        function get_user_area_id()
        {
            return $this->user_area_id;
        }

        function set_user_area_id($user_area_id)
        {
             $this->user_area_id = $user_area_id;
        }
        function get_program_id()
        {
            return $this->program_id;
        }

        function set_program_id($program_id)
        {
             $this->program_id = $program_id;
        }

        function get_area_id()
        {
            return $this->area_id;
        }

        function set_area_id($area_id)
        {
             $this->area_id = $area_id;
        }

        function get_user_id()
        {
            return $this->user_id;
        }

        function set_user_id($user_id)
        {
             $this->user_id = $user_id;
        }

        function get_place_id()
        {
            return $this->place_id;
        }

        function set_place_id($place_id)
        {
             $this->place_id = $place_id;
        }

        function get_user_area_block()
        {
            return $this->user_area_block;
        }

        function set_user_area_block($user_area_block)
        {
             $this->user_area_block = $user_area_block;
        }

        function get_user_area_street()
        {
            return $this->user_area_street;
        }

        function set_user_area_street($user_area_street)
        {
             $this->user_area_street = $user_area_street;
        }
       
        function get_user_area_avenue()
        {
            return $this->user_area_avenue;
        }

        function set_user_area_avenue($user_area_avenue)
        {
             $this->user_area_avenue = $user_area_avenue;
        }

        function get_user_area_house_num()
        {
            return $this->user_area_house_num;
        }

        function set_user_area_house_num($user_area_house_num)
        {
             $this->user_area_house_num = $user_area_house_num;
        }

        function get_user_area_building_num()
        {
            return $this->user_area_building_num;
        }

        function set_user_area_building_num($user_area_building_num)
        {
             $this->user_area_building_num = $user_area_building_num;
        }
        
        function get_user_area_floor()
        {
            return $this->user_area_floor;
        }

        function set_user_area_floor($user_area_floor)
        {
             $this->user_area_floor = $user_area_floor;
        }

        function get_user_area_apartment_num()
        {
            return $this->user_area_apartment_num;
        }

        function set_user_area_apartment_num($user_area_apartment_num)
        {
             $this->user_area_apartment_num = $user_area_apartment_num;
        }

        function get_user_area_office_num()
        {
            return $this->user_area_office_num;
        }

        function set_user_area_office_num($user_area_office_num)
        {
             $this->user_area_office_num = $user_area_office_num;
        }
        
        function get_user_area_automated_figure()
        {
            return $this->user_area_automated_figure;
        }

        function set_user_area_automated_figure($user_area_automated_figure)
        {
             $this->user_area_automated_figure = $user_area_automated_figure;
        }

        function get_user_area_notes()
        {
            return $this->user_area_notes;
        }

        function set_user_area_notes($user_area_notes)
        {
             $this->user_area_notes = $user_area_notes;
        }

        function get_administration_name()
        {
            return $this->administration_name;
        }

        function set_administration_name($administration_name)
        {
             $this->administration_name = $administration_name;
        }

        function get_administration_telephone_number()
        {
            return $this->administration_telephone_number;
        }

        function set_administration_telephone_number($administration_telephone_number)
        {
             $this->administration_telephone_number = $administration_telephone_number;
        }

        function get_administration_telephone_number1()
        {
            return $this->administration_telephone_number1;
        }

        function set_administration_telephone_number1($administration_telephone_number1)
        {
             $this->administration_telephone_number1 = $administration_telephone_number1;
        }

        function get_administration_username()
        {
            return $this->administration_username;
        }

        function set_administration_username($administration_username)
        {
             $this->administration_username = $administration_username;
        }

        function get_administration_password()
        {
            return $this->administration_password;
        }

        function set_administration_password($administration_password)
        {
             $this->administration_password = $administration_password;
        }
        
        #endregion
}

?>