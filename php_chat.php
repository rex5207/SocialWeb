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
		a:hover {color:#EDFF00}
		a#lout:hover{color:#EDFF00}
		a#option:hover{color:#EDFF00}
		table,tr,td{
			border:1px dashed;
		}
        #showMsgHere{width:100%;height:100%;font-size:20px;resize:none;}
	</style>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
    function sendMsg(){
		var yourid = "<?echo $_GET[id];?>";
        $.post(
            "ajax_chatroom_insert.php","yourid="+yourid+"&msg="+$("#msg").val()
        );
        $("#msg").val("");
    }
     
    function showMsg(){
		<?php
			$_SESSION['yourid']=$_GET[id];
		?>
        $("#showMsgHere").load(
            "ajax_chatroom_disp.php", "",
            function(){
                $('#showMsgHere').scrollTop( $('#showMsgHere')[0].scrollHeight );
            }
        );
    }
     
    $(function(){
        setInterval("showMsg();", 700);
        $("#msg").bind("keydown",
            function(e){
                if(e.which==13){
					e.preventDefault();
                    sendMsg();
                }
            }
        )
    })
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


<div style="float:left;padding-left:10%;padding-top:0%;">
<table style="height:70%">
    <tr height="100%"><td><textarea id="showMsgHere" disabled="disabled"></textarea></td></tr>
    <tr><td>
        <form>
            <input type="text" id="msg" placeholder="訊息" style="width:70em;height:2em">
            <input type="button" value="送出" onclick="sendMsg()">
        </form>
    </td></tr>
</table>

</div>