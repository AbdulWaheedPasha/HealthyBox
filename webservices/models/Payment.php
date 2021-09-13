<?php
class Payment
{
    private $conn;
    public $payment_order_id;
    public $payment_date;
    public $payment_time; 
    public $payment_status_id;
    public $user_area_id;
    public $paymentId;
    public $payment_Tran_Id;
    public $payment_TrackID;
    public $payment_price;
  
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function  saveTransaction()
    {
           
        $query = "INSERT INTO `payment_tbl` (`payment_order_id`, `payment_date`, `payment_time`, `payment_status_id`, `user_area_id`, `paymentId`, `payment_Tran_Id`, `payment_TrackID`, `payment_price`)
                    VALUES ('$this->payment_order_id','$this->payment_date','$this->payment_time','$this->payment_status_id','$this->user_area_id','$this->paymentId','$this->payment_Tran_Id','$this->payment_TrackID','$this->payment_price')";
        // echo $query;
        mysqli_set_charset($this->conn,"utf8");  
        $result = mysqli_query($this->conn, $query);
        return  mysqli_insert_id($this->conn);
 

    }
  

    
    

}





?>


