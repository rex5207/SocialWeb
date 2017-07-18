<?php
session_start();
include("mysqlInc.php");
	if($_POST['acc'] && $_POST['pwd'] && $_POST['nn']){//如果帳號密碼不為空
		$acc = preg_replace("/[^A-Za-z0-9]/","",$_POST['acc']);//檢查字元
		$pwd = preg_replace("/[^A-Za-z0-9]/","",$_POST['pwd']);
		$nn = $_POST['nn'];
		$pwd = md5($pwd);		
		$_SESSION['id'] = $acc;
		$_SESSION['nickName']=$nn;
		$sql = "INSERT INTO user (id,pwd,nickName) VALUES ('$acc', '$pwd', '$nn')";
		mysql_query($sql);
		echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php'.'?id='.$_SESSION['id'].'>';
	}
	else{
		echo "<script language=\"JavaScript\">";
		echo "window.alert(\"資料不完全\");";
		echo "</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=php_login.php>';
	}
?>