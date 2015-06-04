<?php 
	session_start();
	$removeName = $_GET['removeName'];
	$uname = $_SESSION['uname'];
	if(isset($removeName)){
		include("db_connect.inc.php");
		$sql = "delete from Friends where (uname = '$uname' and funame = '$removeName') or (uname = '$removeName' and funame = '$uname')";
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