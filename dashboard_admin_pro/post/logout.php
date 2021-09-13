<?php 
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
unset($_SESSION['user_name']);
unset($_SESSION['password']);
session_destroy();
echo '<meta http-equiv="refresh" content="0; url=../index.php">';
exit();
?>