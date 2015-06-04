<?php

session_start();

// Connect to server and select databse.
include("db_connect.inc.php");

if($_SESSION['uname']!=null){
    $check_like_format = "SELECT * FROM Like_Diary WHERE uname='%s' AND did=%s LIMIT 1";
    $like_diary_format = "INSERT INTO Like_Diary VALUES('%s', %s)";
    $like_cnt_format = "SELECT COUNT(*) FROM Like_Diary WHERE did=%d";

    $sql = sprintf($check_like_format, $_SESSION['uname'], $_GET["did"]);
    //error_log("check like SQL: ".$sql);
    $result = mysql_query($sql);

    if ( $result && mysql_num_rows($result)==0 ) {
        mysql_free_result($result);
        $sql = sprintf($like_diary_format, $_SESSION['uname'], $_GET["did"]);
        error_log("like diary SQL: ".$sql);

        $result = mysql_query($sql);
        if ($result) {
            $sql = sprintf($like_cnt_format, $_GET["did"]);
            error_log("like count SQL: ".$sql);
            $result = mysql_query($sql);
            if ($result) {
                $row = mysql_fetch_row($result);
                $cnt = $row[0];
                $json_arr = array('result'=>'success', 'did'=>$_GET["did"], 'cnt'=>$cnt);
            }else {
                error_log("GET LIKE COUNT ERR: ".$sql); 
                $json_arr = array('result'=>'fail', 'did'=>$_GET["did"]);
            }
        } else {
            error_log("DB ERR: ".$sql);    
            $json_arr = array('result'=>'fail', 'did'=>$_GET["did"]);
        }
    } else {
        error_log("User ".$_SESSION['uname']." already liked Diary ".$_GET['did']);
        $json_arr = array('result'=>'fail', 'did'=>$_GET["did"]);
    }
}
mysql_close($connect);
echo json_encode($json_arr);
?>
