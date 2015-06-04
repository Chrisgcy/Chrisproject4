<?php 
	session_start();
	$acceptName = $_GET['acceptName'];
	$funame = $_SESSION['uname'];
	if(isset($acceptName)){
		include("db_connect.inc.php");
		$sql = "update Friends set accept='yes' where uname = '$acceptName' and funame = '$funame'";
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