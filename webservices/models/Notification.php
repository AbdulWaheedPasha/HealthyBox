<?php
class Notification
{
    // DB Stuff
    private $conn;

    private $table2 = '`notification_tbl` ';
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Notification List
    public function getNotificationList(){
      $query = "SELECT `notification_id`, `notification_message` FROM $this->table2  ";
     //  echo  $query;
       mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return  $result;
    }



 


    
    
}

?>
