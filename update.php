<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("db_connect.inc.php");

if($_SESSION['uname']!=null)
{
$id=$_SESSION['uname'];
$sql="select * from Users where uname='$id'";
$result=mysql_query($sql);
$row=mysql_fetch_row($result);

 echo "<form name=\"form\" method=\"post\" action=\"update_finish.php\">";
    echo "User Name：$row[0] <br>";
 echo "Password：<input type=\"password\" name=\"pw\" value=\"$row[1]\" /> <br>";
echo "Confirm Password：<input type=\"password\" name=\"pw2\" value=\"$row[1]\" /> <br>";
echo "Date of Birth：<input type=\"text\" name=\"birthday\" value=\"$row[2]\" /> <br>";
echo "City：<input type=\"text\" name=\"city\" value=\"$row[3]\" /> <br>";
echo "<input type=\"submit\" name=\"button\" value=\"Update\" />";
echo"</form>";
}
else
{
echo 'you have no rights to browse this website!';
echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
}
?>
</body>
</html>
