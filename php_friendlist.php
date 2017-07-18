<?php
session_start();
include("mysqlInc.php");
?>

<?php
	if($_GET['bt1']){
		delete_friend();
	}
function delete_friend(){
	$fd = $row['myfriend'];
	echo "<script language=\"JavaScript\">";
	echo "window.alert($fd);";
	echo "</script>";
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_friendlist.php>';
	}
?>

<html><head>
	<meta charset="UTF-8">
	<style>
		a#option{
			color:white;
			-webkit-transition:color 0.2s linear;
			cursor:hand;
		}
		a#lout{
			color:#E1F0F0;
			-webkit-transition:color 0.2s linear;
			cursor:hand;
		}
		img#msg{
			height: expression(this.width > 160 ? this.height = this.height * 160 / this.width : "auto");
			width: expression(this.width > 160 ? "160px" : "auto");
			max-width:160px;
		}
		img#sta{
			height: expression(this.width > 300 ? this.height = this.height * 300 / this.width : "auto");
			width: expression(this.width > 300 ? "160px" : "auto");
			max-width:300px;
		}
		a:hover {color:#EDFF00}
		a#lout:hover{color:#EDFF00}
		a#option:hover{color:#EDFF00}
	</style>
</head>
<body bgcolor="#BFBFBB" style="padding-top:3%;padding-left:3%;">
<div id="temp"style="float:left;">
<?php
	echo "<a href='php_index.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.The Wall</a></br>";
	echo "<a href='php_profile.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Profile</a></br>";
	echo "<a href='php_friendlist.php?id=".$_GET['id']."' id='option' style='color:#EDFF00;font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Friend</a></br>";
	echo "<a href='php_blog.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Blog</a></br>";
?>
<a id="lout" href="php_logout.php" id='option' style="font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;">.Logout</a></br></br></br></br></br>

<a href="php_index.php" id='option' style="font-size:40px;font-family:Calibri,sans-serif;text-decoration:none;padding-left:180px"><span style="color:#EDFF00;font-size:40px;font-family:Calibri,sans-serif;" >⇧</span>HOME</a></br>
</div>


<div style="float:left;padding-left:20%;padding-top:0%;">

<table border="1">
	<tr>
		<th>好友帳號</th>
		<th>主頁連結</th>
		<th>刪除好友</th>
	<tr>
	<?php
		$acc = $_GET['id'];
		$sql = "SELECT myfriend FROM friend_list where myself = '$acc'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['myfriend']."</td>";
			echo "<td>"."<a href='php_index.php?id=".$row['myfriend']."'>連結</a></td>";
			echo "<td><form action='php_del_friend.php' method='GET'>
					<input type='hidden' name='del' value = ".$row['myfriend']." >
					<input type='submit' value='刪除好友' ></form></td></tr> ";
		}
	?>
</table>

</div>
</body></html>