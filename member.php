<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    include("db_connect.inc.php");
    echo '<a href="logout.php">log out</a> <br><br>';
    
    if($_SESSION['uname']!=null)
    {
        echo '<a href="signup.php">sign up</a> ';
        echo '<a href="update.php">revise</a> ';
        echo '<a href="delete.php">delete</a> <br><br>';
        
        $sql="select * from Users";
        $result=mysql_query($sql);
        while($row=mysql_fetch_row($result))
        {
            echo "$row[0] - name: $row[1],"."city: $row[3], Date of Birth: $row[4]<br>";
        }
    }
    else{
        echo 'you have no rights to browse this website!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
    }
    ?>