<?php
session_start();
include("mysqlInc.php");
	$acc = $_SESSION['id'];
	$fd = $_SESSION['new_friend'];
	$flag = 0;
	if($acc == $fd){
		echo "<script language=\"JavaScript\">";
			echo "window.alert(\"你不能加自己為好友\");";
			echo "</script>";
	}
	else if($_SESSION['new_friend']!=null){//如果帳號密碼不為空
		$sql = "SELECT myfriend FROM friend_list where myself = '$acc'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		// 比對密碼
		while($row['myfriend']==$fd && $flag!=1){/*檢查是否已經為朋友*/
			$flag=1;
			echo "<script language=\"JavaScript\">";
			echo "window.alert(\"你們已經是朋友了\");";
			echo "</script>";
		}
	}
	if($flag == 0 && $acc != $fd){
		$sql = "INSERT INTO friend_list (myself,myfriend) VALUES ('$acc','$fd')";
		mysql_query($sql);
		$sql = "INSERT INTO friend_list (myself,myfriend) VALUES ('$fd','$acc')";
		mysql_query($sql);
		echo "<script language=\"JavaScript\">";
		echo "window.alert(\"變成朋友囉!\");";
		echo "</script>";
	}
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id='.$_SESSION['new_friend'].'>';
?>