<?php
class Category
{
    // DB Stuff
    private $conn;
    private $table = 'category_tbl';
    // Properties
    public $category_id;
    public $level;
    public $category_icon;
    public $category_title_ar;
    public $category_title_en;
    public $category_img;
    public $category_order;
    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get all categories
    public function getCategory()
    {
        $query = 'SELECT * FROM ' . $this->table . ' where `category_id_tree` = '.$this->level.' AND `category_active` = 1  ORDER BY `category_id_tree` DESC';
        mysqli_set_charset($this->conn,"utf8");
        $result = mysqli_query($this->conn, $query);
        return  $result;
 
    }
    
    
}

?>

