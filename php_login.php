<?php
session_start();
include("mysqlInc.php");
?>
 
<?php
if($_SESSION['id']!=null){ // 如果登入過，則直接轉到登入後頁面
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php'.'?id='.$_SESSION['id'].'>';
}
else {
    $acc = $_GET['account'];
    $pwd = $_GET['password'];
    $acc = preg_replace("/[^A-Za-z0-9]/","",$acc);
    $pwd = preg_replace("/[^A-Za-z0-9]/","",$pwd);
    if($acc!=NULL && $pwd!=NULL){
        $sql = "SELECT id, pwd, nickName FROM user where id = '$acc'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        // 比對密碼
        if($row['pwd']==md5($pwd)){
            $_SESSION['id'] = $row['id'];
            $_SESSION['pwd'] = $row['pwd'];
            $_SESSION['nickName'] = $row['nickName'];
            echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php'.'?id='.$_GET['account'].'>';
        }
    }
     
}
?>
 
<html>
<head>
	<meta charset="UTF-8">
	<style>
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
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#register").click(
				function(){
					$("#slideShow").css("display","block");;
					$("#add_account").show(300);
				}
			);
			$("#slideShow").click(
				function(){
					$("#slideShow").css("display","none");;
					$("#add_account").hide(300);
				}
			);
			$("#add_submit").click(
				function(){
					$("#slideShow").css("display","none");;
					$("#add_account").hide(300);
				}
			);
		});
	</script>
</head>
<body bgcolor="#0F0000">
<div id="slideShow"></div>
<?php
	$sql = "SELECT id FROM user ORDER BY RAND()";//隨機選取圖片
	$result = mysql_query($sql);
	$h=2;
	$w=2;
	$deg='-15deg';
	$z=0;
	while($row = mysql_fetch_array($result)){
		if(file_exists("./pic_personal/".$row['id'].".jpg")){//如果大頭貼存在
			echo "<img src='./pic_personal/".$row['id'].".jpg' 
			style='position:absolute;top:".$h."%;left:".$w."%;z-index:".z."; border:3px white solid;transform:rotate(".$deg.");-webkit-transform:rotate(".$deg.");' 
			height=30% width=10%>";
			if($deg=='15deg')
				$deg = '-15deg';
			else
				$deg = '15deg';
			if($z==0)
				$z=1;
			else
				$z=0;
			if($w>90 && $h>75)
				break;
			else if($w<90)
				$w = $w+8;
			else if($w>=90){
				$w = 3;
				$h = $h+25;
			}
		}
			
	}
?>
<div style="position:absolute;z-index:2;top:40%;left:30%;width:620px;height:170px;
			background-color:rgba(255,255,255,0.75);border: 0px solid;border-radius: 10px;box-shadow: 0px -1px 10px,0px 1px 20px;">
	</br>
	<div style="position:relative;left:5%;">
		<div style="float:left;">
			<span style="font-size:20px;color:#2D2D3C;text-decoration:underline">帳號</span></br></br>
			<form action="php_login.php" method="GET">
			<input type="text" name="account" style="padding-left:5px;border: 1px solid;border-radius:10px;width:200px;height:50px;outline:none;font-size:25px"><br/>
		</div>
		<div style="float:left;padding-left:40px">
			<span style="font-size:20px;color:#2D2D3C;text-decoration:underline">密碼</span></br></br>
			<input type="text" name="password" style="padding-left:5px;border: 1px solid;border-radius: 10px;width:200px;height:50px;outline:none;font-size:25px">
			<input style="position:relative;left:25px;height:50px;width:70px;border-radius:8px;background-color:#5C76A9;color:white;font-size:15px;outline:none;"type="submit" value="登入"><br/>
			<a href="javascript: void(0)" id="register">註冊帳號</a>
			</br>You can using test accounts(test1/test1、test2/test2...)
		</div>
			</form>
	</div></br></br>
</div>
 
 
 <div id="add_account" style="display:none;position:absolute;z-index:3;top:35%;left:35%;width:400px;height:200px;
			background-color:rgba(255,255,255,0.75);border: 0px solid;border-radius: 15px;box-shadow: 0px -1px 10px,0px 1px 20px;">
	</br>
	<div style="position:relative;left:10%;">
		<span style="font-size:20px;color:#2D2D3C;text-decoration:underline">新增帳號</span></br></br>
		<form action="php_account.php" method="POST">
			帳號：<input type="text" style="height:25px;border-radius:5px;" name="acc"><br/>
			密碼：<input type="text" style="height:25px;border-radius:5px;" name="pwd"><br/>
			暱稱：<input type="text" style="height:25px;border-radius:5px;" name="nn"><br/><br/>
			<input style="height:25px;" value="註冊" type="submit">
		</form>
	</div>
 </div>
</body></html>