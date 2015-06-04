<?php session_start();?>
<html>
<head>
<title>Friends</title>
</head>
<body style= "text-align:center; background-color:#b0c4de">
<?php
    
    if ($_SESSION['uname']==null) {
        header("location: logout.php");
    } else {
        $session_uname = $_SESSION['uname'];
        include("db_connect.inc.php");
        
        //include("feeds.php");
        
        echo "<br />";
        echo "<h2><center>Friends</center> </h2>";
       
        
        $query = "SELECT * from Friends join Users on Friends.uname = Users.uname where Friends.uname = '{$_SESSION['uname']}' or Friends.funame = '{$_SESSION['uname']}'";
/*         echo $query; */
        $result = @ mysql_query($query, $connect) or
        die("Can't query table friendship.");
        
        echo "<table class='post' style='margin: 10px auto;'>";
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        	$uname = $row['uname'];
        	$funame = $row['funame'];
        	$accept = $row['accept'];
        	
        	//显示对方的信息
        	if($uname == $session_uname){
        		/**
        		*name
        		*/
	        	echo "<tr><td><a href='friendProfile.php?uname=$funame'>$funame</a></td>&nbsp;&nbsp;&nbsp;";
	        	
	        	/**
	        	*Pinboards
	        	*/
	        	echo "<td>Pinboards</td>";
	        	
	        	/**
	        	*Operation
	        	*/
	        	echo "<td>";
				if($accept == 'ignore'){
		            echo "<a href = 'friendRequest.php?reqname=$funame'>request Again</a>";
	            }else if($accept == 'yes'){
					echo "<a href = 'friendRemove.php?removeName=$funame'>remove</a>";
	            }
				echo "</td></tr></n>";

        	}else if($funame == $session_uname && $accept != "ignore"){
        		/**
        		*name
        		*/
	        	echo "<tr><td><a href='friendProfile.php?uname=$uname'>$uname</a></td>&nbsp;&nbsp;&nbsp;";
	        	
	        	/**
	        	*Pinboards
	        	*/
	        	echo "<td>Pinboards</td>";
	        	
	        	/**
	        	*Operation
	        	*/
	        	echo "<td>";
				if($row['accept']=='none'){
	            	echo "<a href = 'friendAccept.php?acceptName=$uname'>confirm</a>&nbsp;";
					echo "<a href = 'friendIgnore.php?ignoreName=$uname'>ignore</a>";
	            }else if($row['accept']=='yes'){
		            echo "<a href = 'friendRemove.php?removeName=$uname'>remove</a>";
	            }
				echo "</td></tr></n>";
        	}
        	
                                   
            
            $query_1 = "select * from Users natural join Diary natural join Activity natual join Location where uname = '{$row['uname']}'";
            $result_1 = mysql_query($query_1, $connect) or
            die("Can't query table pinboard.");
            
            // echo "<ul>";
            while ($row_1 = mysql_fetch_array($result_1, MYSQL_ASSOC)) {
                echo "<td>{$row_1['aname']}";
                echo"</td>";
                echo "<td>{$row_1['lname']}";
                echo"</td>";
            }
            // echo "</ul>";
            
        }
        echo "</table>";
    }
	?>
        <br>
<a href="friendsadd.php">Add new friends</a>
<br>
<form action='profile.php'>
<input type="submit" value="Back to home page">
</form>

</body>
</html>
