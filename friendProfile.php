<?php session_start();?>
<html>
<head>
<title><?php echo "{$_GET['uname']}"; ?></title>
</head>
<body>
    <form action='profile.php'>
	    <input type="submit" value="Home">
	</form>
	<?php
	
		include("db_connect.inc.php");
        $a=$_GET['uname'];
		$query = "SELECT * from Users where uname = '$a'";
        //$query = "SELECT * from Users where uname = {$_GET['uname']}";
        
		$result = mysql_query($query, $connect) or die("Failed");

		$row = mysql_fetch_array($result);
        if ($_SESSION['uname']==null) {
            header("location: logout.php");
		} else {
			//include("feeds.php");

			$query = "select * from Users where uname = '{$_GET['uname']}'";
			$result = @ mysql_query($query, $connect) or
			die("Can't connect table profile.");

			$row = mysql_fetch_array($result, MYSQL_ASSOC);

			if (empty($row)) { // User with no profile.
				echo "{$row['uname']} has not set up the profile yet.";
			} else {
				echo "<h2>{$row['uname']}'s profile</h2><table>";

				echo "<tr><td class='post'>";
				echo "<div class='post-heading'>Name: </div>
					<div class='post-content'>{$row['uname']}</div>";
				echo "<br></td></tr>";
				

				if (!empty($row["birth"])) {
					echo "<tr><td class='post'>";
					echo "<div class='post-heading'>birthday: </div>
						<div class='post-content'>{$row['birth']}</div>";
					echo "<br></td></tr>";
				}

				if (!empty($row["city"])) {
					echo "<tr><td class='post'>";
					echo "<div class='post-heading'>hometown: </div>
					<div class='post-content'>{$row['city']}</div>";
					echo "<br></td></tr>";
				}

				echo "</table>";
			}

		}
	?>
	<br>
</body>
</html>
