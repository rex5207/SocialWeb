<?php
 
$db_server = "127.0.0.1";
$db_user = "";
$db_passwd = "";
$db_name = "";
 
if(!@mysql_connect($db_server, $db_user, $db_passwd)){
        die("gg");
}
 
mysql_query("SET NAMES utf8");
 
if(!@mysql_select_db($db_name)){
        die("gg");
}
 
?>