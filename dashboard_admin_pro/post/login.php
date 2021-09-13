<?php
// login.php 
session_start();
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
if(isset($_POST) && !empty($_POST)){
	// echo $_SESSION['lang'];

if (isset($_POST['username']) || isset($_POST['password'])) {
	if(!empty($_POST['username']) || !empty($_POST['password'])){
		$u    = $_POST['username'];
		$p    = $_POST['password'];
		$flag = false;
		include "../Configuration/db.php";
		include "../Controller/AdminstrationRoleController.php";
		$username = base64_encode(base64_encode(base64_encode(base64_encode($u))));
		$password = base64_encode(base64_encode(base64_encode(base64_encode($p))));
		$query = "SELECT  * FROM `administration_tbl` WHERE `administration_username` = '$username' and `administration_password` = '$password' and `administration_active` = 1 ";
		//echo $query;
		$rs   = mysqli_query($con,$query);
		
		if(mysqli_num_rows($rs) > 0){
			while($r = mysqli_fetch_array($rs)){
				if($r['administration_username'] == $username && $r['administration_password'] == $password){
					$adminstor_role_controller = new adminstrator_role_controller($con,$username,$password, $r['administration_type_id'],$r['administration_id']);
					$flag =  true;
					$adminstor_role_controller->check_session();
					$adminstor_role_controller->get_roles_where_id();
				break;
			}
		}

		mysqli_close($con);
		
	 }
	if($flag){
		echo '<meta http-equiv="refresh" content="0;url=../dashboard.php" />';
	     exit();
	}else{
		session_destroy();
		header('Location:../index.php?err=1');
		exit();
	}
}else{
	session_destroy();
    header('Location:../index.php?err=1');
    exit();

}
}else{
	session_destroy();
    header('Location:../index.php?err=1');
    exit();
}
}else{
	session_destroy();
    header('Location:../index.php?err=1');
    exit();
}

?>