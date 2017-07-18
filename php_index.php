<?php
session_start();
include("mysqlInc.php");
?>

<html>
<head>
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
		a#lout:hover{color:#EDFF00}
		a#option:hover{color:#EDFF00}
	</style>
</head>
<body bgcolor="#BFBFBB" style="padding-top:3%;padding-left:3%;">
<div id="temp"style="float:left;">
<?php
	echo "<a href='php_index.php?id=".$_GET['id']."' id='option' style='color:#EDFF00;font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.The Wall</a></br>";
	echo "<a href='php_profile.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Profile</a></br>";
	echo "<a href='php_friendlist.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Friend</a></br>";
	echo "<a href='php_blog.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Blog</a></br>";
?>
<a id="lout" href="php_logout.php" id='option' style="font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;">.Logout</a></br></br></br></br></br>

<a href="php_index.php" id='option' style="font-size:40px;font-family:Calibri,sans-serif;text-decoration:none;padding-left:180px"><span style="color:#EDFF00;font-size:40px;font-family:Calibri,sans-serif;" >⇧</span>HOME</a></br>
</div>


<div style="float:left;padding-left:20%;padding-top:0%;width:40%">

<?php
/**比對現在的塗鴉牆是否為本人*/
	$acc = $_SESSION['id'];
	$fd = $_GET['id'];
	$_SESSION['flag'] = 0;
	if($acc == $fd){
		$_SESSION['flag'] =1;
	}
	else if($_SESSION['new_friend']!=null){//如果帳號密碼不為空
		$sql = "SELECT myfriend FROM friend_list where myself = '$acc'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		// 比對密碼
		while($row['myfriend']==$fd && $_SESSION['flag']!=1){/*檢查是否已經為朋友*/
			$_SESSION['flag'] =1;
		}
	}
?>

<?php
	//echo "Hi, ".$_SESSION['id']."(".$_SESSION['nickName'].")";
?>
<?php
	if($_SESSION['id']==null){ 
		echo '<meta http-equiv=REFRESH CONTENT=0;url=php_login.php>';
	}
	else {
		$_SESSION['new_friend'] = $_GET['id'];
		$acc = $_GET['id'];
		if($acc!=null){
			$sql = "SELECT id, pwd, nickName FROM user where id = '$acc'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			if($row==null){/*如果找不到使用者，返回自己的首頁*/
				echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id='.$_SESSION['id'].'>';
			}
			// 比對密碼
			$cur_id = $row['id'];
			$cur_nn = $row['nickName'];
			$_SESSION['nickName'] =  $row['nickName'];
			echo "<img src='./pic_personal/".$cur_id.".jpg' align='left' height='130px' width='130px' style='border:#FFFFFF 3px solid;'></img></br>";
			echo "<span style='font-size:70px;color:#FFFFFF;padding-left:110px;letter-spacing:6px;font-style:italic;'>".$cur_nn."</span>";
			echo "<a href='php_chat.php?id=".$cur_id = $row['id']."'style='color:blue;'>粗乃玩~</a>";
		}
		else{//網址列ID=空白，返回自己的首頁
			echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id='.$_SESSION['id'].'>';
		}
	}
?>
</br></br></br>
<hr>

<?php
	function showMyMsg($row){//顯示留言
		$time=$row['time'];
		$loca_id=$row['loca_id'];
		$id=$row['id'];
		$filename=$row['filename'];
		$extension=$row['extension'];
		echo "<tr'><td style='padding-left:20px;color:#1E0000' bgcolor='#E1F0F0'>留言人：".$row['id'];
		if($_SESSION['id']==$_GET['id'])
			echo "<a href='php_del_Msg.php?time=".$time."&loca_id=".$loca_id."&id=".$id."'style='float:right'>刪除留言</a>"."</td><tr>";
		else
			echo "</td><tr>";
		if($filename!=null && $extension=='jpg'){
			echo "<td colspan=\"3\" style='padding-left:70px'>".$row['content']."</br><img id='msg' src='./file_msg/".$id."/".$filename.".jpg'></img></br></td></tr>";
		}
		else if($filename!=null)
			echo "<td colspan=\"3\" style='padding-left:70px'>".$row['content']."</br><a href='./file_msg/".$id."/".$filename.".".$extension."'>下載附加檔案</a></br></td></tr>";
		else
			echo "<td colspan=\"3\" style='padding-left:70px'>".$row['content']."</td></tr>";
	}

	function showMySta($row){//顯示動態
		$time = $row['time'];
		$md5time = md5($row['time']);
		$msg = $row['content'];
		$photo = $row['photo'];
		$curID = $_GET['id'];
		$extension = $row['extension'];
		if($row['type']=='public' || $_SESSION['flag']==1){
			echo "</br><table border=\"1\" style='width:94%;margin-left:3%;border-collapse:collapse'><tr>";
			echo "<td><span style='color:red;font-size:20px'>".$_SESSION['nickName']."</span> ──";
			echo " 發表於 ".$time;
			if($_SESSION['id']==$_GET['id'])
				echo "<a href='php_del_status.php?time=".$time."' style='float:right'>刪除動態</a>"."</td>";
			else
				echo "</td>";
			if(strpos($msg,"youtube")!=false){//動態包含youtube網址
				$extension = end(explode("=", $msg));
				echo "<tr><td colspan=\"3\"></br><a href='".$msg."'>".$msg."</a></br>";
				echo "<iframe width='560' height='315' src='//www.youtube.com/embed/".$extension."' frameborder='0' allowfullscreen></iframe></br></br></td></tr>";
			}
			else if(strpos($msg,"http")!==false || strpos($msg,"www")===true){
				echo "<tr><td colspan=\"3\"></br><a href='".$msg."'>".$msg."</a></br>";
				$url = str_replace('https','http',$msg);//避免因https造成file_get_contents的錯誤
				//----- 讀取網頁源始碼
				$fp = file_get_contents($url);  
				//----- 擷取 title 資訊
				preg_match("/<title>(.*)<\/title>/s", $fp, $match);
				$title = $match[1];
				//----- 印出結果
				echo "→$title<BR>";
				echo "</br></br></td></tr>";
			}
			else{
				if($photo!=null && $extension=='jpg')
					echo "<tr><td colspan=\"3\"></br><img id='sta' src='./pic_states/".$curID."/".$photo.".jpg'></img></br></br>";
				else if($photo!=null)
					echo "<tr><td colspan=\"3\"></br><a href='./pic_states/".$curID."/".$photo.".".$extension."'>下載附加檔案</a></br>";
				else
					echo "<tr><td colspan=\"3\"></br>";
				echo $msg."</br></br></td></tr>";
			}
			$sql = "SELECT * FROM msg where (loca_id='$curID') AND (loca_time='$md5time') ORDER BY time ASC";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				showMyMsg($row);
			}
			$temp = $md5time;
			echo "<td>";
			echo "<form action='php_addMsg.php' method='POST' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='loca_id' value = ".$_GET['id']." >";
			echo "<input type='hidden' name='loca_time' value = ".$temp." >";
			echo "<textarea name='msgBody' style='width:100%;height:50px'></textarea><br>";
			echo "<input type='file' name='uploadfile'>";
			echo "<input type='submit' style='float:right' value='我要留言'></form>";
			echo "</td>";
		}
	}

	if($_GET['id']){
		if($_SESSION['id'] == $_GET['id']){//自己的塗鴉牆 可發動態
			echo "發布新動態";		
			echo "<form action='php_addStatus.php' method='POST' enctype='multipart/form-data'>";
			echo "種類：<input type='radio' name='tp' value='public'>公開";
			echo "<input type='radio' name='tp' value='private'>我自己<br>";
			echo "內容：</br><textarea name='msgBody' style='height:100px;width:100%;border-radius:10px'></textarea><br>";
			echo "<input type='file' name='statesphoto'>";
			echo "<input type='submit' value='送出' style='float:right;width:80px;height:30px;border-radius:5px'></form><hr>";
			echo "我的動態</br>";
		}
		
		$acc = $_GET['id'];
		$sql = "SELECT * FROM status where id = '$acc' ORDER BY time DESC";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){//顯示動態及留言
			echo "<div style='background-color:#D2E1F0;width:100%;border-radius:10px;'>";
			showMySta($row);
			echo "</table><br/>";
			echo "</div><br/><hr><br/>";
		}
	}

?>
</div>
</body></html>