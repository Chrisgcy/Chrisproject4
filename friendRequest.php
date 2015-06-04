<?php
 	session_start();
 	$uname=$_SESSION['uname'];
 	$reqName=$_GET['reqname'];
		if (!isset($_GET['reqname'])) {
			echo "<script>location.href='./friends.php';</script>"; 
/* 		header("location: friends.php"); */
	} else {
		include("db_connect.inc.php");
		//
		$sql = "select * from Friends where uname = '$uname' and funame = '$reqName'";
		$result = mysql_query($sql);
		//if not exist, then insert
		if(!mysql_fetch_array($result)){
			$sql = "insert into Friends(uname, funame, ts_sel) values ('$uname', '$reqName', now())";
			echo $sql;
			$result = mysql_query($sql, $connect) or die("Failed.");
		}else{
			$sql = "update Friends set accept='none' where uname = '$uname' and funame = '$reqName'";
			$result = mysql_query($sql);		
		}
				
		echo "<script>location.href='./friends.php';</script>";
/* 		header("location: friendsadd.php"); */
	}

?>
