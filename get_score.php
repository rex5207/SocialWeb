<?php
include("mysqlInc.php");
session_start();
$myid = mysql_real_escape_string($_SESSION['id']);
$yourid = mysql_real_escape_string($_SESSION["yourid"]);
$sql = "SELECT * FROM chatroom where  (myid='".$myid."' AND yourid='".$yourid."' ) OR (myid='".$yourid."' AND yourid='".$myid."' ) ORDER BY time";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
    echo $row["myid"]."(".$row["time"]."): ".htmlspecialchars($row["content"])."\n";
}
?> 