<?php
class Order
{
    // DB Stuff
    private $conn;
 
    // Properties
    public $product_id;
    public $order_lists_id;
    public $product_price;
    public $parent_id;
    public $branch_id;
    public $payment_status_id;
    public $order_id;
    public $user_id;
    public $additions_item;
    public $user_address;
    public $driver_notes;
    public $kitchan_notes;
    public $card_notes;
    public $quntity_num;
    public $order_time;
    public $area_id;
    public $product_qty;
    public $status;
    public $invoice_id;
    public $payment_process_error;
 
  
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    //get Parent ID
    public function getDeliveryTimeTbl(){
        $query = "SELECT `delivery_time` FROM `delivery_time_tbl` ";
        // echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_row($result);
        return  $row[0]; 
    }
    //get Parent ID
    public function getParentID(){
        $query = "SELECT `product_root` FROM `product_tbl` WHERE `product_id` = $this->product_id ";
        // echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_row($result);
        //echo "Parent id : ".$row[0]; 
        return  $row[0]; 
    }
    public function get_quntity_field(){
        $query = "SELECT `additions_item_qty` FROM `additions_item_tbl` WHERE `additions_item_id` =  '$this->additions_item' ";
       // echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_row($result);
        //echo "Parent id : ".$row[0]; 
        return  $row[0]; 
    }

    public function get_price_field(){
        $query = "SELECT `additions_item_price` FROM `additions_item_tbl` WHERE `additions_item_id` =   $this->additions_item ";
        //echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_row($result);
        //echo "Parent id : ".$row[0]; 
        return  $row[0]; 
    }
    public function get_fees(){
        $query = "SELECT `area_cost_delivery` FROM `area_tbl` LIMIT 1 ";
       // echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_row($result);
        //echo "Parent id : ".$row[0];
        return  $row[0];
    }
    //get Branch
    public function getBranchID(){
        $query  = "SELECT `branch_id` FROM `additions_item_tbl` WHERE `additions_item_id` =   $this->additions_item ";
        //  echo $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row    = mysqli_fetch_row($result);
        return  $row[0];  
    }
    //add New Product 
    public function AddNewOrder()
    {
        mysqli_set_charset($this->conn,"utf8");
        $order_query = "INSERT INTO `order_tbl`(`area_id` ,`order_number`, `order_status_id`  , `order_created_at`  , `branch_id` ,  `order_time`  , `payment_status_id`  , `order_from_id`,`order_view`)
                        VALUES ('$this->area_id','$this->order_number','1','$this->order_created_at','$this->branch_id','$this->order_time','$this->payment_status_id' , '3','0')";
        // echo  $order_query;
        $result = mysqli_query($this->conn, $order_query);
        return mysqli_insert_id($this->conn);
        
      
       
    }
    //add New Product
    public function AddNewOrderStillPayemnt()
    {
        mysqli_set_charset($this->conn,"utf8");
        $order_query = "INSERT INTO `order_tbl`(`area_id` ,`order_number`, `order_status_id`  , `order_created_at`  , `branch_id` ,  `order_time`  , `payment_status_id`  , `order_from_id`,`order_view`) 
                        VALUES ('$this->area_id','$this->order_number','8','$this->order_created_at','$this->branch_id','$this->order_time','$this->payment_status_id' , '3','2')";

        //echo  $query."<br/>";;
        $result = mysqli_query($this->conn, $order_query);
        return mysqli_insert_id($this->conn);



    }


    public function insertOutOfStock()
    {
      
        mysqli_set_charset($this->conn,"utf8");
        $query  = "INSERT INTO `product_out_stock_tbl`(`product_id`, `product_amount`, `product_out_stock_date`, `product_out_stock_view`, `order_id`)
          VALUES ('$this->additions_item','$this->quntity_num',CURDATE(),'0','$this->order_id');";
        //echo  $query."<br/>";;
        $result = mysqli_query($this->conn, $query);
        return mysqli_insert_id($this->conn);
    }

    // insert user and order number
    public function AddUserOrder()
    {
        mysqli_set_charset($this->conn,"utf8");
        $order_adminstratoir_query = "INSERT INTO `order_administration_tbl` VALUES (NULL,'$this->order_id','$this->user_id','0')";
        //echo  $order_adminstratoir_query."<br/>";;
        $rs = mysqli_query($this->conn,$order_adminstratoir_query);
        return mysqli_insert_id($this->conn);
    }
    public function InsertProducOrderList()
    {
        mysqli_set_charset($this->conn,"utf8");
        $order_list_query = "INSERT INTO `order_lists_tbl`  VALUES (NULL,'$this->product_qty','$this->order_id','$this->product_id','$this->product_price','','')";
         //echo $order_list_query;
        $result = mysqli_query($this->conn,$order_list_query);
        return  mysqli_insert_id($this->conn);  
       
    }
    public function OrderAdditionsItemTbl()
    {
        mysqli_set_charset($this->conn,"utf8");
        $order_additions_item_query = "INSERT INTO `order_additions_item_tbl` VALUES (NULL, '$this->order_lists_id', '$this->additions_item')";
        //echo $order_additions_item_query."<br/>";;
        $result = mysqli_query($this->conn,$order_additions_item_query);
        return $result;  
       
    }
    public function update_address_customer()
    {
        mysqli_set_charset($this->conn,"utf8");
        $update_address_sql = "UPDATE `administration_tbl` SET `administration_address` = '$this->user_address' WHERE `administration_id` = '$this->user_id' ";
       // echo $update_address_sql;
        $result = mysqli_query($this->conn,$update_address_sql);
        return $result;  
       
    }

    function generateRandomString($length = 5) {
        $characters = '0123456789012345678901234567890123456789012345678901213354545678901234567890123456789012345678901234567890123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
        //get Branch
    public function getLastOrderID(){
        $query  = "SELECT max(`order_id`) FROM `order_tbl`";
        // echo  $query."<br/>";
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        $row    = mysqli_fetch_row($result);
        return  $row[0];  
         
              
    }
    public function update_order_payment(){
        mysqli_set_charset($this->conn,"utf8");
        $update_address_sql = "UPDATE `order_tbl` SET `order_view` = '0' , `order_status_id` = '1' WHERE `order_number` = '$this->order_id' ";
        $result = mysqli_query($this->conn,$update_address_sql);
        return $result;  
    }
    public function insert_invoice(){
        mysqli_set_charset($this->conn,"utf8");
        date_default_timezone_set('Asia/Kuwait');
        $currentDateTime = date('Y-m-d H:i:s');
        $update_address_sql = "INSERT INTO  `payment_tbl` (`payment_type_text`, `order_id`, `paymentId`,`payment_process_error`,`payment_date`) 
                                VALUES ('$this->status', '$this->order_id', '$this->invoice_id','$this->payment_process_error','$currentDateTime');";
        
        
        $result = mysqli_query($this->conn,$update_address_sql);
        return $result;  
    }
}

?>

