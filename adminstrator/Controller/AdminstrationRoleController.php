<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
class adminstrator_role_controller
{
    private $con;
    private $username;
    private $password;
    private $role_id;
    public function __construct($con,$username,$password,$role_id,$user_id)
    {
        $this->con     = $con;
        $this->username = $username;
        $this->password = $password;
        $this->role_id  = $role_id;
        $this->user_id  = $user_id;
    }
    public function get_roles_where_id()
    {
        $i = 0;
        $prog_obj = NULL;
        mysqli_set_charset($this->con, "utf8");
        $query = "SELECT *  FROM  `user_page_role_tbl` inner join `administration_type_tbl` On `administration_type_tbl`.`administration_type_id` = `user_page_role_tbl`.`administration_type_id` 
                    inner join `page_role_tbl` On `page_role_tbl`.`page_role_id` = `user_page_role_tbl`.`page_role_id`
                    where `user_page_role_tbl`.`administration_type_id` =  $this->role_id order by  `page_role_tbl`.`page_role_main_menu_order_by` ";
        //echo $query;  
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $prog_obj[$i]['page_role_title']          = $row['page_role_title'];
            $prog_obj[$i]['page_role_module_name']     = $row['page_role_module_name'];
            $prog_obj[$i]['page_role_title_en']      = $row['page_role_title_en'];
            $prog_obj[$i]['page_role_title_ar']     = $row['page_role_title_ar'];
            $prog_obj[$i]['page_role_logo']         = $row['page_role_logo'];
            $prog_obj[$i]['page_role_main_menu']         = $row['page_role_main_menu'];
             $i++;
        }
        return $prog_obj;
    }

    function check_session(){
        $_SESSION['user_name'] = $this->username;
        $_SESSION['password']  = $this->password;
        $_SESSION['role_id']   = $this->role_id; 
        $_SESSION['id']         = $this->user_id; 
        $_SESSION['menu_item'] = $this->get_roles_where_id();
      
    }

 


    
    
}
