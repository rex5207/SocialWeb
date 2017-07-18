<?php
session_start();
include("mysqlInc.php");

if($_GET['time']){
	$id = $_GET['id'];
	$loca_id = $_GET['loca_id'];
	$time = $_GET['time'];
	echo $time;
	echo $loca_id;
	echo $id;
    $sql = "DELETE FROM msg WHERE (id='$id') AND (time='$time') AND (loca_id='$loca_id')";
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