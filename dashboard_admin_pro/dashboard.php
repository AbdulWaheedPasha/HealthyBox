
   <?php 
   session_start();
//    error_reporting(0);
// ini_set('display_errors', 0);
  if(!isset($_SESSION['user_name']) && !isset($_SESSION['password'])  && empty($_SESSION['user_name']) && empty($_SESSION['password'])){
    session_destroy();
    echo '<meta http-equiv="refresh" content="0;url=./index.php?err=1" />';
    exit();
  
}
// var_dump((!isset($_SESSION['user_name']) && !isset($_SESSION['password'])  && empty($_SESSION['user_name']) && empty($_SESSION['password'])));
   include_once('./lang/'.$_SESSION['lang'].'.php');
   require_once './Configuration/db.php';

      require_once('./header.php');
      require_once('./top_side.php');
      require_once('./container.php');
      require_once('./footer.php')
    ?>

