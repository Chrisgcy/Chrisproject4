<?php 
	session_start();
	$ignoreName = $_GET['ignoreName'];
	$funame = $_SESSION['uname'];
	if(isset($ignoreName)){
		include("db_connect.inc.php");
		$sql = "update Friends set accept='ignore' where uname = '$ignoreName' and funame = '$funame'";
/* 		echo $sql; */
		$result = mysql_query($sql);
		if($result){
			echo "<script>location.href='./friends.php';</script>";
		}else{
			echo 'error';
		}
	}else{
		echo $acceptName;
	}
	
?>