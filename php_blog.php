<?php
session_start();
include("mysqlInc.php");

if($_POST['msgBody']){
	$id = $_SESSION['id'];
    $content = $_POST['msgBody'];
	$tp = $_POST['tp'];
	$title = $_POST['title'];
	$sql = "INSERT INTO blog(id,time,content,type,title) VALUES ('$id',CURRENT_TIMESTAMP,'$content','$tp','$title')";
	mysql_query($sql);
	echo "<meta http-equiv=REFRESH CONTENT=0;url=php_blog.php?id=".$id.">";
}

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
		
		#slideShow{
			position:absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0,0,0,0.8);
			z-index:3;
			display:none;
		}
		
		.next{
			color:blue;
			cursor:hand;
			outline:none;
			font-size:15px;
		}
		
		.button {
			border-top: 1px solid #e4e9ed;
  		    background: #BFBFBB;
			padding: 8px 16px;
			border-radius: 3px;
			box-shadow: 0px -1px 10px;
			color: BLACK;
			font-size: 15px;
			outline:none;
			width:150px;
			font-family: Georgia, Serif;
			text-decoration: none;
			vertical-align: middle;
			letter-spacing:2px;
			font-style: italic;
		}
		.button:hover {
			border-top-color: #d6ed51;
			background: #EDFF00;
			color: #000000;
		}
		.button:active {
			border-top-color: #1b435e;
			background: #BFBFBB;
		}
		.next:hover{
			color:red;
		}
		a#lout:hover{color:#EDFF00}
		a#option:hover{color:#EDFF00}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#add_blog").click(
				function(){
					$("#slideShow").css("display","block");;
					$("#add_blog_enter").show(300);
				}
			);
			$("#slideShow").click(
				function(){
					$("#slideShow").css("display","none");
					$("#add_blog_enter").hide(300);
					$("#show_blog").hide(300);
				}
			);
			$("#add_submit").click(
				function(){
					$("#slideShow").css("display","none");
					$("#add_blog_enter").hide(300);
					$("#show_blog").hide(300);
				}
			);
		});
	</script>
</head>
<body bgcolor="#BFBFBB" style="padding-top:3%;padding-left:3%;">
<div id="temp"style="float:left;">
<?php
	echo "<a href='php_index.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.The Wall</a></br>";
	echo "<a href='php_profile.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Profile</a></br>";
	echo "<a href='php_friendlist.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Friend</a></br>";
	echo "<a href='php_blog.php?id=".$_GET['id']."' id='option' style='color:#EDFF00;font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Blog</a></br>";
?>
<a id="lout" href="php_logout.php" id='option' style="font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;">.Logout</a></br></br></br></br></br>

<a href="php_index.php" id='option' style="font-size:40px;font-family:Calibri,sans-serif;text-decoration:none;padding-left:180px"><span style="color:#EDFF00;font-size:40px;font-family:Calibri,sans-serif;" >⇧</span>HOME</a></br>
</div>

<div id="slideShow"></div>
<div style="float:left;padding-left:20%;padding-top:0%;">

<?php
	if($_GET['id']){
		if($_SESSION['id'] == $_GET['id']){//自己的塗鴉牆 可發動態
			echo "<input id='add_blog' class='button' style='margin-left:10px' type='button' value='發表新文章'></br></br>";
		}
		$acc = $_GET['id'];
		$sql = "SELECT * FROM blog where id = '$acc' ORDER BY time DESC";
		$result = mysql_query($sql);
		echo "<div style='width:600px;'></br>";
		while($row = mysql_fetch_array($result)){//顯示動態及留言
			echo "<span style='padding-left:10px;color:white;text-shadow:1px 1px 5px  #4B4BF0;font-size:20px'>".$row['time']."　────　</span>";
			echo "<span style='color:white;text-shadow:1px 1px 5px  black;font-size:30px;font-weight: bold;letter-spacing:1px; text-decoration:underline '>".$row['title']."</span></br></br></br>";
			echo "<a class='next' href='php_blog.php?id=".$row['id']."&time=".$row['time']."&flag=1' style='padding-right:10px;float:right' > 繼續閱讀</a></br></br><hr align='center' color='#D2D2F0' style='width:100%;'></br>";
			/*echo "<form action='php_blog.php' method='POST'>";
			echo "<input type='hidden' name='id' value = ".$row['id']." >";
			echo "<input type='hidden' name='time' value = ".$row['time']." >";
			echo "<input class='next' type='button' style='padding-right:10px;float:right;background-color:#BFBFBB;border: 0px solid' value='繼續閱讀'></form></br></br><hr align='center' color='#D2D2F0' style='width:100%;'></br>";*/
		}
		echo "</div>";
	}
?>



<div id="add_blog_enter" style="display:none;position:absolute;z-index:3;top:10%;left:30%;width:570px;height:600px;
			background-color:rgba(255,255,255,0.75);border: 0px solid;border-radius: 15px;box-shadow: 0px -1px 10px,0px 1px 20px;"></br>
	<div style="position:relative;left:10%">
		<?php
			echo "<form action='php_blog.php' method='POST' enctype='multipart/form-data'>";
			echo "標題：<input type='text' style='height:30px;width:350px;border-radius:5px;' name='title'></br></br>";
			echo "種類：<input type='radio' name='tp' value='public'>公開     ";
			echo "<input type='radio' name='tp' value='private'>私人</br></br>";
			echo "內容：</br><textarea name='msgBody' style='margin-left:9%;margin-top:-4%;height:400px;width:350px;border-radius:5px;'></textarea><br><br>";
			echo "<input type='submit' style='margin-left:65%' value='送出'></form>";
		?>
	</div>
</div>


<div id="show_blog" style="display:none;position:absolute;z-index:3;top:10%;left:30%;width:570px;height:600px;
			background-color:rgba(255,255,255,0.75);border: 0px solid;border-radius: 15px;box-shadow: 0px -1px 10px,0px 1px 20px;"></br>
	<div style="position:relative;left:10%">
		<?php
			if($_GET['flag']==1){
				$id = $_GET['id'];
				$time = $_GET['time'];
				$sql = "SELECT * FROM blog where id = '$id' AND time='$time'";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo "<span style='padding-left:10px;color:white;text-shadow:1px 1px 5px  #4B4BF0;font-size:20px'>".$row['time']."　────　</span>";
				echo "<span style='color:white;text-shadow:1px 1px 5px  black;font-size:30px;font-weight: bold;letter-spacing:1px; text-decoration:underline '>".$row['title']."</span></br></br></br>";
				echo "<pre style='padding-left:10px;'>".$row['content']."</pre>";
				echo "<script language=\"JavaScript\">";
				echo "$('#slideShow').css('display','block');";
				echo "$('#show_blog').show(300);";
				echo "</script>";
			}
		?>
	</div>
</div>

</div>