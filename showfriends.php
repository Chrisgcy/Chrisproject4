<html>
<body>
<table border='1'>
<tr>
<th>Friends name</th>
<th>birthday</th>
<th>honetown</th>
</tr>
</table>;
<?php
//$q = $_GET['q'];
    include("db_connect.inc.php");
    //$connect = mysqli_connect('localhost','root','root','communitynetwork');
    //if (!$connect) {
      //  die('Could not connect: ' . mysqli_error($connect));
    //}
    
    //mysqli_select_db($connect,"communitynetwork");

    
    $sql="SELECT * FROM Users";
    $result = mysql_query($sql);
    //echo "<p>".$sql."</p>";
    //echo $sql;
    //echo $result;
    echo "<select name='uname'>";
    while($row = mysql_fetch_array($result)) {
        echo sprintf("<option value='$result'>%s</option>", $row[0]);
        //<option value="">Select a person</option>
        //echo "<option value='$result'>".$row[0]."</option>";
        //echo "<option value='$result'>".$row[2]."</option>";
        //echo "<option value='$result'>".$row[3]."</option>";
        //echo "</option>";
    }
        echo "</select>";
?>
</body>
</html>
