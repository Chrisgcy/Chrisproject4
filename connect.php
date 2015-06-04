<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
    include("db_connect.inc.php");
    $id=$_POST['id'];
    $pw=md5($_POST['pw']);
    
    $id=stripslashes($id);
    $pw=stripslashes($pw);
    $id=mysql_real_escape_string($id);
    $pw=mysql_real_escape_string($pw);
    
    
    $sql="select * from Users where uname='$id'";
    $result=mysql_query($sql);
    $row=@mysql_fetch_row($result);
    if($id!=null && $pw!=null && $row[0]==$id && $row[1]==$pw)
    {
        $_SESSION['uname']=$id;
        echo 'login successfully!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=wall.php>';
    }
    else
    {
        echo 'login unsuccessfully';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
    }
    //echo $id;
    //echo $pw;
    //echo $row[1];
    //echo $row[2];
    ?>
