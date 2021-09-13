<?php
class program_model
{
    // Properties
    public $start_date;
    public $end_date;
    public $program_id;
    public $user_id;

    // Methods
    function set_start_date($start_date)
    {
        $this->start_date = $start_date;
    }
    function get_start_date()
    {
        return $this->start_date;
    }
    // Methods
    function set_end_date($end_date)
    {
        $this->end_date = $end_date;
    }
    function get_end_date()
    {
        return $this->end_date;
    }
    // Methods
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function get_user_id(){
        return $this->user_id;
   }
}
