<?php
class Database{
    private $servername     = "localhost";
		private $username   =  "althybq7__user";
		private $password   =  '&tETKQ1U4MoK';
		private $dbname     =  'althybq7_healthy_box_2';
     // DB Connect
    public function connect() {
		$this->conn = null;
		try { 
		  $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			// $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($this->conn->connect_error) {
		 		echo 'Connection Error: ' . $this->conn->connect_error;
			}

		} catch(mysqli_sql_exception $e) {
		    echo 'Connection Error: ' . $e->errorMessage();
		}
		return $this->conn;
	  }
}

?>
