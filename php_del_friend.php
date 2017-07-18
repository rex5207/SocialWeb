<?php
session_start();
include("mysqlInc.php");
?>
<?php
		$del_id = $_GET['del'];
		$acc = $_SESSION['id'];
		$sql = "DELETE FROM friend_list WHERE (myself='$acc') AND (myfriend='$del_id')";
		mysql_query($sql);
		$sql = "DELETE FROM friend_list WHERE (myself='$del_id') AND (myfriend='$acc')";
		mysql_query($sql);
		echo "<script language=\"JavaScript\">";
		echo "window.alert(\"你們已經不是朋友了\");";
		echo "</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=php_friendlist.php>';
?>