<?php 	

	$query = "select uname, funame from Friends
	where funame = '{$_SESSION['uname']}'";

	$result = mysql_query($query, $connect) or
		die("Can't query table friendrequest.");

	$row = mysql_fetch_array($result);

	echo "<div class='login-area'>";

	if (!empty($row))
		echo "<a href='friendResponse.php'>
		New Feeds</a> | ";
				
	echo	"{$_SESSION["uname"]}
		| <a class='login-link' href='logout.php'>
		Log out
		</a>
		</div>";

?>
