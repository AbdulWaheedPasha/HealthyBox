<?php
if(!isset($_SESSION['user_name']) && !isset($_SESSION['password'])  && empty($_SESSION['user_name']) && empty($_SESSION['password'])){
	 session_destroy();
		header('Location:../index.php?err=1');
		exit();
}
// print_r($_SESSION);
?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <?php
    if (isset($_GET['type'])) {
      foreach( $_SESSION['menu_item'] as  $value ) {
        switch ($_GET['type']) {
          case $value['page_role_title']:
            require_once('./module/'.$value['page_role_module_name']);
          break;

        }
      }
      switch ($_GET['type']) {
        case "change_username_password":
          require_once('./module/change_username_password.php');
        break;
      }
    } 
?>
    </div>
  </div>
</div>