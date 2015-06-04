<?php
session_start();

// Connect to server and select databse.
include("db_connect.inc.php");

if($_SESSION['uname']!=null){
    $fetch_comment_format = "select * from Comment where did=%s";
    $sql = sprintf($fetch_comment_format, $_GET["did"]);
    //error_log("fetch comment SQL: ".$sql);

    $s = "<ul class='row'>";
    $comment_li_format = "<li><div><a style='font-weight: bold'>%s:</a><span>%s</span></div></li>";
    
    $result = mysql_query($sql);
    if ($result) {
        while ($cmt = mysql_fetch_assoc($result)) {
            $comment_li = sprintf($comment_li_format, $cmt["uname"], $cmt["ccontent"]);
            $s .= $comment_li;
        }
    }
    $s .= "</ul>";
    //error_log($s);

    $cmt_form = "<div class='row' style='margin-right: 0px; margin-left: 0px;'><form method='post' class='cmt-form'><textarea name='content' style='width:84%; margin: 3px 2px 2px 3px;'></textarea>";
    $cmt_form .= sprintf("<input type='hidden' name='did' value=%d />", $_GET["did"]);
    $cmt_form .= "<input type='submit' class='btn btn-primary' style='float: right; margin-right:2px;' value='Comment' /></form></div>";
    //error_log($cmt_form);

    $json_arr = array("result"=>"success", "did"=>$_GET["did"], "comments"=>$s, "cmt_form"=>$cmt_form);
    //error_log($json_arr);
    echo json_encode($json_arr);
}
mysql_close($connect);
?>
