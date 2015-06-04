<?php
    $host="localhost"; // Host name 
    $username="root"; // Mysql username 
    $password="ms123456"; // Mysql password 
    $db_name="communitynetwork"; // Database name 
    $user_tbl_name="Users"; // Table name 
     
    $connect = mysql_connect("$host", "$username", "$password") or die("cannot connect");
    mysql_select_db("$db_name", $connect) or die("cannot select DB");
?>
