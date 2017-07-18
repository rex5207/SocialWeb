<?php
session_start();
include("mysqlInc.php");
?>

<?php
	if( $_GET['new_pwd'] && $_GET['new_nn']){//如果帳號密碼不為空
		$nn = $_GET['new_nn'];
		$pwd = md5($_GET['new_pwd']);
		$acc = $_SESSION['id'];
		$sql = "UPDATE user SET pwd='$pwd' ,nickName='$nn' WHERE id= '$acc'";
		mysql_query($sql);
        $_SESSION['pwd'] = $pwd;
        $_SESSION['nickName'] = $nn;
        echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php'.'?id='.$_SESSION['id'].'>';
	}
?>