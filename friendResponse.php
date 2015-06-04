<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="./static/main.css" />
<title>Adding new friends</title>
</head>
<body>
	<?php
		session_start();
		if ($_SESSION['uname']==null) {
			header("location: logout.php");
			exit;
		} else {

			include("db_connect.inc");

			if (!empty($_POST['selected']) && $_POST['decision'] == 'Accept')  {
				foreach ($_POST['selected'] as $id) {

					$query = "INSERT INTO Friends(uname, funame) VALUES ({$_SESSION['uname']},{$friname})";
					$result = mysql_query($query, $connect) or
					die("Updated failed.");

					$query = "INSERT INTO Friends(uname, funame) VALUES ({$friname},{$_SESSION['uname']})";
					$result = mysql_query($query, $connect) or
					die("Updated failed.");

					$query ="DELETE FROM Friends where uname = {$friname} and funame = {$_SESSION['uname']}";
					$result = mysql_query($query, $connect) or
					die("Delete failed.");

				}
			} else if (!empty($_POST['selected']) && $_POST['decision'] == 'Reject') {
				foreach ($_POST['selected'] as $friname) {
					$query ="DELETE FROM Friends where uname = {$friname} and funame = {$_SESSION['uname']}";
					$result = mysql_query($query, $connect) or
					die("Delete failed.");
				}
			}

			include("feeds.php");

			$query = "select * from Friends join users on Users.uname = Friends.uname where funame = '{$_SESSION['uname']}'";
			$result = mysql_query($query, $connect) or
				die("Failed.");

			echo "<form action='friendResponse.php' method='post'>";


			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				echo "<input type='checkbox' name='selected[]' value='{$row['uname']}'>
				{$row['uname']} {$row['ts_con']}<br>";
			}
			echo "<input type='submit' name='decision' value='Accept'>
			<input type='submit' name='decision' value='Reject'>
				</form>";

		}
	?>
	<br>
	<form action='profile.php'>
		<input type="submit" value="Back to homepage">
	</form>
</body>
</html>	
