<?php
session_start();
include("mysqlInc.php");

if($_GET['time']){
	$acc = $_SESSION['id'];
	echo $acc."</br>";
	$time = $_GET['time'];
	echo $time;
    $sql = "DELETE FROM status WHERE (id='$acc') AND (time='$time')";
	mysql_query($sql);
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php>';
}
else{
	echo "<script language=\"JavaScript\">";
	echo "window.alert(\"type和content不能為空\");";
	echo "</script>";
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php>';
}
?>