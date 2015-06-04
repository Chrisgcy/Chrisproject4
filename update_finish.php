<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("db_connect.inc.php");

$id=$_POST['id'];
$pw=md5($_POST['pw']);
$pw2=md5($_POST['pw2']);
$birthday=$_POST['birthday'];
$city=$_POST['city'];

if($_SESSION['uname']!=null&&$pw!=null&&$pw2!=null&&$pw==$pw2)
{
$id=$_SESSION['uname'];

$sql="update Users set password='$pw', birth='$birthday', city='$city' where uname='$id'";
if(mysql_query($sql))
{
echo 'update successfully!';
echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
}
else
{
echo 'update unsuccessfully !';
echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
}
}
else
{
echo 'you have no rights to browse this website!';
echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
}
?>