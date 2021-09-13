<?php
class Payment_Method
{
    // DB Stuff
    private $conn;
    
    // Properties
    public $payment_date;
    public $payment_type_text;
    public $order_id;
    public $paymentId;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Product
    public function insert_payment_method(){
              // Create query
      $query = "INSERT INTO `payment_tbl`(`payment_date`, `payment_type_text`, `order_id`, `paymentId`) 
      VALUES ('$this->order_date','$this->payment_type_text','$this->order_id','$this->paymentId') ";
     //  echo  $query;
      mysqli_set_charset($this->conn,"utf8");
      $result = mysqli_query($this->conn, $query);
      return  $result;
    }

 


    
    
}

?>
