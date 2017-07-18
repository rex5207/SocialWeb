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
		span#changing_hp{
			display:none;
			border:#ff7700 10px;
			border-style:none;
			background-color:#FFFFFF;
			border-radius:0px;
			height:50px;
			width:200px;
			text-align:center;
			line-height:50px;
			opacity: 0.7;
			position:absolute;
			margin-top:130px;
			margin-left:-200px;
		}
		span#person_title{
			font-size:20px;
			line-height:30px;
			font-family:標楷體;
		}
		a:hover {color:#EDFF00}
		a#lout:hover{color:#EDFF00}
		a#option:hover{color:#EDFF00}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#headpic").mouseenter(
				function(){
					$("#changing_hp").fadeIn(200);
				}
			);
			
			$("#headpic").click(
				function() {
					$("#upload").click();        
				}
			);
			
			$("#upload_pic").change(
				function() {
					$("#submit").click();        
				}
			);
			
			$("#headpic").mouseleave(
				function(){
					$("#changing_hp").fadeOut(200);
				}
			);
		});
	</script>
	<script>
		//setInterval("$(\"#my_headpic\").load(\"php_profile.php\");", 1000);
	</script>
</head>
<body bgcolor="#BFBFBB" style="padding-top:3%;padding-left:3%;">
<div id="temp"style="float:left;">
<?php
	echo "<a href='php_index.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.The Wall</a></br>";
	echo "<a href='php_profile.php?id=".$_GET['id']."' id='option' style='color:#EDFF00;font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Profile</a></br>";
	echo "<a href='php_friendlist.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Friend</a></br>";
	echo "<a href='php_blog.php?id=".$_GET['id']."' id='option' style='font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;'>.Blog</a></br>";
?>
<a id="lout" href="php_logout.php" style="font-size:80px;font-family:Calibri,sans-serif; font-variant:small-caps;">.Logout</a></br></br></br></br></br>

<a href="php_index.php" id='option' style="font-size:40px;font-family:Calibri,sans-serif;text-decoration:none;padding-left:180px"><span style="color:#EDFF00;font-size:40px;font-family:Calibri,sans-serif;" >⇧</span>HOME</a></br>
</div>


<div style="float:left;padding-left:20%;padding-top:0%;">

<?php
/**上傳大頭貼*/
$whiteList = array('gif', 'jpg', 'png');
$newDir = "./pic_personal/";
if($_FILES["person_pic"]["name"]!=NULL){ // 程式從檔案上傳
    // explode: 切割字串, end: 取最後一個結果
    $extension = strtolower(end(explode(".", $_FILES["person_pic"]["name"])));
    if( in_array($extension, $whiteList) &&
        $_FILES["person_pic"]["size"]<=1024*1024){
            $resultStr = "Submit file OK.";
            move_uploaded_file($_FILES["person_pic"]["tmp_name"], $newDir.$_SESSION['id'].".".$extension);
    }
    else {
        $resultStr = "Submit file GG!!";
    }
	echo "<meta http-equiv=REFRESH CONTENT=0;url=php_profile.php?id=".$_POST['id'].">";
}
?>

<?php
	if($_SESSION['id']==null){ 
		echo '<meta http-equiv=REFRESH CONTENT=0;url=php_login.php>';
	}
	else {
		$acc = $_GET['id'];
		if($acc==null && $_POST['id']!=null){
			echo "<meta http-equiv=REFRESH CONTENT=0;url=php_profile.php?id=".$_POST['id'].">";
		}
		else if($acc!=null){
			$sql = "SELECT id, pwd, nickName FROM user where id = '$acc'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			if($row==null){//如果找不到使用者，返回自己的首頁
				echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id='.$_SESSION['id'].'>';
			}
			// 比對密碼
			$cur_id = $row['id'];
			$cur_nn = $row['nickName'];
			echo "<div style='cursor:hand ;float:left;' id='headpic'><img id='my_headpic' src='./pic_personal/".$cur_id.".jpg' height='300px' width='200px' style='border:#FFFFFF 3px double;'></img>";
			echo "<span id='changing_hp'>更換大頭貼</span></div>";
			echo "<div style='float:left;padding-left:20px'></br>";
			echo "<span id=person_title>姓名: ".$cur_id."</br>暱稱: ".$cur_nn."</br></span></div>";
		}
		else{//網址列ID=空白，返回自己的首頁
			echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id='.$_SESSION['id'].'>';
		}
	}
?>

<form id="upload_pic" style="display:none" action="php_profile.php" method="POST" enctype="multipart/form-data">
	<?php echo "<input type='hidden' name='id' value = ".$_GET['id']." >" ?>
    <input id ="upload" type="file" name="person_pic">
    <input id ="submit" type="submit" name="submit" value="Submit">
</form>

</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
<?php	
		if($_SESSION['id'] == $_GET['id']){//更改資料
			echo "<hr>更改資料：</br>";
			echo "<form action='php_modify.php' method='GET'>";
			echo "新密碼：<input type='text' name='new_pwd'><br/>";
			echo "新暱稱：<input type='text' name='new_nn'><br/>";
			echo "<input type='submit'></form>";
		}
		else{//不是自己 可加好友
			echo "好友：</br>";
			echo "<form action='php_friend.php' method='POST'>";
			echo "<input type='submit' value='加為好友' >";
			echo "</form>";
		}
?>
</div>
</body></html>