<?php
include("db_connect.inc.php");
if(!$mysqli->query("drop procedure if exists userlikeActivity")||!mysqli->query("create procedure userlikeActivity(
in username varchar(40),
out id int(16))
begin
select actid into id from Like_activity where uname=username; end")){
echo "Stored procedure creation failed: (".$mysqli->errno.")".$mysqli->error;
}
if(!mysqli->query("SET @id=' '")||!$mysqli->query("CALL userlikeActivity("Mary",@id)")){
echo "CALL failed: (".$mysqli->errno.")".$mysqli->error;
}

if (!($res = $mysqli->query("SELECT @id as _p_out"))) {
    echo "Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$row = $res->fetch_assoc();
echo $row['_p_out'];
?>
?>