<?php session_start();?>
<?php
    include("db_connect.inc.php");
    
    if($_SESSION['uname']!=null)
    {
    $sql=("call userlikeActivity(Mary,@id)";select @id);
    $result=mysql_query($sql);
    echo $sql;
    }
    echo "<table border='1'>
    <tr>
    <th>activity id</th>
    </tr>";
    
    while($row=mysql_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['$uname']."</td>";
    echo "<td>".$row['$actid']."</td>";
    echo "</tr>";
    }
    echo "</table>";
    ?>
