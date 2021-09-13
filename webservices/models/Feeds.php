<?php
class Feeds
{
    // DB Stuff
    private $conn;
    // Properties
    public $feed_title;
    public $feed_message;
    public $name;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all Product
    public function addNewFeeds()
    {
        $this->feed_title     = htmlspecialchars(strip_tags($this->feed_title));
        $this->feed_message   = htmlspecialchars(strip_tags($this->feed_message));
        $this->name           = htmlspecialchars(strip_tags($this->name));
        $query  = "INSERT INTO `feed_tbl`(`feed_name`, `feed_title`, `feed_message`)  VALUES ('$this->name','$this->feed_title','$this->feed_message');";
        //echo $query;
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}
?>


