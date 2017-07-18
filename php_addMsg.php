<?php
session_start();
include("mysqlInc.php");

/**上傳動態圖片*/
$blackList = array('php', 'jsp', 'asp');
$newDir = "./file_msg/".$_SESSION['id']."/";

if($_POST['msgBody']){
	$acc = $_SESSION['id'];
    $content = $_POST['msgBody'];
	$loca_id = $_POST['loca_id'];
	$loca_time = $_POST['loca_time'];
	if($_FILES["uploadfile"]["name"]!=NULL){ // 程式從檔案上傳
		// explode: 切割字串, end: 取最後一個結果
		$extension = strtolower(end(explode(".", $_FILES["uploadfile"]["name"])));
		if( !in_array($extension, $blackList) && $_FILES["uploadfile"]["size"]<=1024*1024){
			$filename =time();
            $resultStr = "Submit file OK.";
			
			mkdir($newDir,'0777'); //建立資料夾!!!!
			
            move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $newDir.$filename.".".$extension);
		}
		else {
			$resultStr = "Submit file GG!!";
		}
	}
	$sql = "INSERT INTO msg(loca_id,loca_time,id,time,content,filename,extension) 
				VALUES ('$loca_id','$loca_time','$acc',CURRENT_TIMESTAMP,'$content','$filename','$extension')";
	mysql_query($sql);
	echo "<meta http-equiv=REFRESH CONTENT=0;url=php_index.php?id=".$loca_id.">";
}
else{
	echo "<script language=\"JavaScript\">";
	echo "window.alert(\"type和content不能為空\");";
	echo "</script>";
	echo '<meta http-equiv=REFRESH CONTENT=0;url=php_index.php>';
}
?>