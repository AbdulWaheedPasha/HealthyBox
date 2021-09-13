<?php
class User
{
    // DB Stuff
    private $conn;
    // Properties
    public $social_media_id;
    public $user_id;
    public $user_date;
    public $access_token;
    public $user_name;
    public $user_password;
    public $user_telep;
    public $user_another_telep;
    public $user_email;
    public $user_address;
    public $user_token_device;
    public $tele2;
    public $area;
    public $block;
    public $street;
    public $avenus;
    public $build_num;
    public $home;
    public $flat;
    public $place;
    public $area_id;
    public $gender; 
    public $age;
    public $weight;
    public $tall;
    public $motivation;
    public $firebase_token;
    public $goal_weight;
    public $user_image_path;
    public $avenus_number;
    

    

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Product
    public function create()
    {
        $this->user_name     = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $this->user_telep    = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_another_telep    = htmlspecialchars(strip_tags($this->user_another_telep));
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_image_path    = htmlspecialchars(strip_tags($this->user_image_path));
      
        date_default_timezone_set("Asia/Kuwait");
        $date = date("h:i:sa");

        $query  = "INSERT INTO `administration_tbl` 
        (`administration_profile`,`administration_name`,`administration_password`, `administration_telephone_number`,`administration_telephone_number1`,
         `administration_username`, `administration_address`,`administration_type_id`,`administration_gender`, `administration_age`, `administration_weight`, `administration_tall`, `administration_motivation`,`administration_goal_weight`, `administration_firebase`,`administration_active`,`administrator_register_id`,`administration_date_registeration`) 
         VALUES ('$this->user_image_path','$this->user_name', '$this->user_password','$this->user_telep','$this->user_another_telep','$this->user_email','','5','$this->gender', '$this->age' , '$this->weight', '$this->tall','$this->motivation','$this->goal_weight','$this->firebase','4','1','$date');";
       // echo $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function searchUser()
    {
        $this->user_telep = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $query  = "SELECT *  FROM `administration_tbl` WHERE  `administration_username` = '$this->user_email'   ";
        //echo  $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }
    public function getUser()
    {
        $this->user_telep = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $query  =  "SELECT *  FROM `administration_tbl` inner join `administration_gender` on `administration_tbl`.`administration_gender` = `administration_gender`.`administration_gender_id` WHERE `administration_tbl`.`administration_id` = '$this->user_id' ";
        // echo $query ;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
        
    }
    public function getUserByUserNameAndPassword()
    {
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $query  = "SELECT *  FROM `administration_tbl` inner join `administration_gender` on `administration_tbl`.`administration_gender` = `administration_gender`.`administration_gender_id`
                   WHERE `administration_tbl`.`administration_password` = '$this->user_password'  and `administration_tbl`.`administration_username` = '$this->user_email' ";
        // echo $query;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
        
    }
    public function deleteTokenFirebase()
    {
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $query  = "UPDATE `administration_tbl` SET `administration_firebase` = '' WHERE `administration_tbl`.`administration_password` = '$this->user_password'  and `administration_tbl`.`administration_username` = '$this->user_email' ";
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
        
    }
    public function fetchUserInfoByEmailOrTelephone(){
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password = htmlspecialchars(strip_tags($this->user_telep));
        $query  = "SELECT *  FROM `administration_tbl` WHERE `administration_username` = '$this->user_email'  OR `administration_password` = '$this->user_telep' ";
        //echo $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    
    public function fetechUserNameAndPassword(){
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $query  = "SELECT *  FROM `administration_tbl` 
        WHERE `administration_password` = '$this->user_password' 
        and `administration_username` = '$this->user_email' ";
        //echo $query;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row    = mysqli_fetch_row($result);
        return $row;
    }
    public function checkEmail()
    {
        $this->user_telep = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $query  = "SELECT *  FROM `administration_tbl` WHERE `administration_username` = '$this->user_email' ";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }
    public function password_verify()
    {
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $query  = "SELECT *  FROM `administration_tbl` WHERE `administration_username` = '$this->user_email'  AND `administration_password` = '$this->user_password' ";
         //echo $query;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }

    public function checkIfUserFound()
    {
        $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
        $this->user_telep    = htmlspecialchars(strip_tags($this->user_telep));
        $query  = "SELECT *  FROM `administration_tbl` WHERE `administration_username` = '$this->user_email'  OR `administration_password` = '$this->user_telep' ";
         //echo $query;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }
    public function updatePassword(){
        $this->user_password       = htmlspecialchars(strip_tags($this->user_password));
        mysqli_set_charset($this->conn,"utf8");
        $query  = "UPDATE `administration_tbl` SET  `administration_password`         = '$this->user_password'  WHERE `administration_id`              = '$this->user_id'  ";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    public function updateTokenUserDevice(){
      mysqli_set_charset($this->conn,"utf8");
      $this->user_id       = htmlspecialchars(strip_tags($this->user_id));
      $this->user_address  = htmlspecialchars(strip_tags($this->user_token_device));
      $query  = "UPDATE `administration_tbl`  SET `administration_token_device` = '".$this->user_token_device."'
        WHERE `administration_id` = '$this->user_id'  ";
      mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return $result;
  }
      // Get all Product
      public function updateUser()
      {
        $this->user_image_path           = htmlspecialchars(strip_tags($this->user_image_path));
        $this->user_name           = htmlspecialchars(strip_tags($this->user_name));
        $this->user_name           = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password       = htmlspecialchars(strip_tags($this->user_password));
        $this->user_telep          = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_email          = htmlspecialchars(strip_tags($this->user_email));
        $this->user_password       = htmlspecialchars(strip_tags($this->user_password));
        $this->user_telep          = htmlspecialchars(strip_tags($this->user_telep));
        $this->user_another_telep  = htmlspecialchars(strip_tags($this->user_another_telep));
        $this->user_email          = htmlspecialchars(strip_tags($this->user_email));
      

        mysqli_set_charset($this->conn,"utf8");
          $query  = "UPDATE 
          `administration_tbl` 
      SET 
         `administration_profile`           = '$this->user_image_path' , 
          `administration_name`             = '$this->user_name' , 
          `administration_username`         = '$this->user_email' , 
          `administration_password`         = '$this->user_password' , 
          `administration_telephone_number` = '$this->user_telep' , 
          `administration_telephone_number1` = '$this->user_another_telep' , 
          `administration_username`         = '$this->user_email' ,
          `administration_gender`           = '$this->gender' ,
           `administration_age`             = '$this->age', 
           `administration_weight`          = '$this->weight',
           `administration_tall`            = '$this->tall',
            `administration_motivation`     = '$this->motivation', 
            `administration_goal_weight`    = '$this->goal_weight',
            `administration_firebase`       = '$this->firebase'

       
      WHERE   
           `administration_id`              = '$this->user_id'  ";
           //echo $query; 
          $result = mysqli_query($this->conn, $query);
          return $result;
      }
    public function creatGuest()
    {
      $query  =  "INSERT INTO `administration_tbl` ( `administration_name`,
                                                                `administration_telephone_number`, 
                                                                `administration_telephone_number1`,
                                                                `administration_type_id`, `administration_active`,
                                                                `administration_block_num`,`administration_street_num`,
                                                                `administration_avenus`, `administration_building_num`, 
                                                                `administration_home_num`,  `administration_flat_num`,`administration_place_id`)  
                            VALUES ('$this->user_name' ,'$this->user_telep','$this->tele2','5', '1','$this->block','$this->street','$this->avenus','$this->build_num','$this->home','$this->flat','$this->place');";
        //echo  $query;        
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  mysqli_insert_id($this->conn);
    }
    // Function to generate OTP 
    function generateNumericOTP($n) { 
        $generator = "1357902468abcdefghijklmnopqrstuvxyz"; 
        $result = ""; 
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
    
        // Return result 
        return $result; 
    } 

    public function insertNewForgetPasswrod(){
      $query  =  "INSERT INTO `administration_tbl` ( `administration_name`,
                                                                `administration_telephone_number`, 
                                                                `administration_telephone_number1`,
                                                                `administration_type_id`, `administration_active`,
                                                                `administration_block_num`,`administration_street_num`,
                                                                `administration_avenus`, `administration_building_num`, 
                                                                `administration_home_num`,  `administration_flat_num`,`administration_place_id`)  
                            VALUES ('$this->user_name' ,'$this->user_telep','$this->tele2','5', '1','$this->block','$this->street','$this->avenus','$this->build_num','$this->home','$this->flat','$this->place');";
        //echo  $query;        
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  mysqli_insert_id($this->conn);
    }
    public function numChangePasswordPerDay(){
        $query  = "SELECT `admin_reset_pass_id` FROM `admin_reset_pass_tbl` where `administration_id` = '$this->user_id' and  `admin_reset_pass_date` = '$this->user_date'  ";
         //echo $query;
         mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
    }
    public function insertChangePasswordRequest(){
        $query  =  "INSERT INTO `admin_reset_pass_tbl` ( `admin_reset_pass_date`, `administration_id`) VALUES ('$this->user_date', '$this->user_id');";
          //echo  $query;        
          mysqli_set_charset($this->conn,"utf8");
          $result = mysqli_query($this->conn, $query);
          return  mysqli_insert_id($this->conn);
      }
      
      public function insertAddressRelateProgram(){
        $query = "INSERT INTO `user_area_tbl`(`area_id`, `user_id`, `place_id`, `user_area_block`, `user_area_street`, `user_area_avenue`, `user_area_house_num`,`user_area_automated_figure`,`user_area_notes`,`program_id`,`user_area_order_id`) 
                  VALUES ('$this->area_id','$this->user_id','$this->place_id','$this->block_number','$this->street_number','$this->avenus_number','$this->house_no','','$this->note','$this->program_id','2')";
        //echo $query;
        mysqli_set_charset($this->conn,"utf8");  
        $result = mysqli_query($this->conn, $query);
        return  mysqli_insert_id($this->conn);
    }

    public function getForMail()
    {
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $query  = "SELECT *  FROM `administration_tbl` WHERE  `administration_username` = '$this->user_email' ";
        //echo  $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }

    public function getUserBYToken()
    {
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $query  = "SELECT *  FROM `administration_tbl` WHERE  `administration_username` = '$this->user_email' and `adminstrator_access_token` = '$this->access_token'";
        //echo  $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result);
        
    }

        // Get all Product
        public function createUserToken()
        {
            $this->user_name     = htmlspecialchars(strip_tags($this->user_name));
            $this->access_token  = $this->access_token;
            $this->user_telep    = htmlspecialchars(strip_tags($this->user_telep));
            $this->user_another_telep    = htmlspecialchars(strip_tags($this->user_another_telep));
            $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
            $this->user_image_path    = htmlspecialchars(strip_tags($this->user_image_path));
          
            $query  = "INSERT INTO `administration_tbl` 
            (`social_media_id`,`administration_profile`,`administration_name`,`adminstrator_access_token`, `administration_telephone_number`,`administration_telephone_number1`,
             `administration_username`, `administration_address`,`administration_type_id`,`administration_gender`, `administration_age`, `administration_weight`, `administration_tall`, `administration_motivation`,`administration_goal_weight`, `administration_firebase`) 
             VALUES ('$this->social_media_id','$this->user_image_path','$this->user_name', '$this->access_token','$this->user_telep','$this->user_another_telep','$this->user_email','','5','$this->gender', '$this->age' , '$this->weight', '$this->tall','$this->motivation','$this->goal_weight','$this->firebase');";
            //echo $query;
            mysqli_set_charset($this->conn,"utf8");
            $result = mysqli_query($this->conn, $query);
            return $result;
        }
        public function getUserByEmailToken(){
            $this->user_email    = htmlspecialchars(strip_tags($this->user_email));
    
            $query  = "SELECT *  FROM `administration_tbl` inner join `administration_gender` on `administration_tbl`.`administration_gender` = `administration_gender`.`administration_gender_id`
                       WHERE `administration_tbl`.`adminstrator_access_token` = '$this->access_token'  and `administration_tbl`.`administration_username` = '$this->user_email' ";
            //echo $query;
             mysqli_set_charset($this->conn,"utf8");
            $result = mysqli_query($this->conn, $query);
            return $result;
            
        }

    

}


?>


