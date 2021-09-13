<?php
 session_destroy();
 header('Location:../index.php?err=1');
 exit();
?>