<?php
$con = @mysqli_connect('localhost', 'root', 'tahir@msrit', 'althybq7_healthy_box');
if (!$con) {
    echo "Error: " . mysqli_connect_error();
	exit();
}
//echo 'Connected to MySQL';
?>