<?php
session_start();
include("mysqlInc.php");


/**上傳動態圖片*/
$blackList = array('php', 'jsp', 'asp');
$newDir = "./pic_states/".$_SESSION['id']."/";
$photo = null;

if($_POST['tp'] && $_POST['msgBody']){
	if($_FILES["statesphoto"]["name"]!=NULL){ // 程式從檔案上傳
		// explode: 切割字串, end: 取最後一個結果
		$extension = strtolower(end(explode(".", $_FILES["statesphoto"]["name"])));
		if( !in_array($extension, $blackList) && $_FILES["statesphoto"]["size"]<=1024*1024){
			$photo =time();
            $resultStr = "Submit file OK.";

			mkdir($newDir,'0777'); //建立資料夾!!!!
			
            move_uploaded_file($_FILES["statesphoto"]["tmp_name"], $newDir.$photo.".".$extension);
		}
		else {
			$resultStr = "Submit file GG!!";
		}
	}
	$acc = $_SESSION['id'];
    $type = $_POST['tp'];
    $content = $_POST['msgBody'];
    /*$sql = "SELECT COUNT(id) FROM status WHERE id='&acc'";
    $result =mysql_query($sql);
	$row = mysql_fetch_array($result);*/
	$sql = "INSERT INTO status(id,photo,type,content,time,extension) VALUES ('$acc','$photo','$type','$content',CURRENT_TIMESTAMP,'$extension')";
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