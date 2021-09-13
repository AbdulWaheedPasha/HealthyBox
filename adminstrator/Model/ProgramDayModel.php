<?php
class program_day_model
{
    // Properties
    public $day_en;
    public $day_ar;
    public $program_id;
    public $date;

  
    function set_day_en($day_en)
    {
        $this->day_en = $day_en;
    }
    function get_day_en()
    {
        return $this->day_en;
    }

   
    function set_day_ar($day_ar)
    {
        $this->day_ar = $day_ar;
    }
    function get_day_ar()
    {
        return $this->day_ar;
    }

    function set_date($date)
    {
        $this->date = $date;
    }
    function get_date()
    {
        return $this->date;
    }


    function set_program_id($program_id)
    {
        $this->program_id = $program_id;
    }
    function get_program_id()
    {
        return $this->program_id;
    }

  

 
    
}
