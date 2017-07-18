<?php
session_start();
include("mysqlInc.php");
 
if($_POST["msg"]!=NULL){
    $myid = mysql_real_escape_string($_SESSION['id']);
	$yourid = mysql_real_escape_string($_SESSION["yourid"]);
    $content = mysql_real_escape_string($_POST["msg"]);
    $sql = "INSERT INTO chatroom (myid,yourid,time,content) VALUES ('$myid','$yourid',CURRENT_TIMESTAMP,'$content')";
    mysql_query($sql);
}
 
?>
