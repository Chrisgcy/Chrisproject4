<?php
session_start();

// Connect to server and select databse.
include("db_connect.inc.php");

if($_SESSION['uname']!=null){
    $add_comment_format = "call commentDiary('%s', %d, '%s')";
    $sql = sprintf($add_comment_format, $_SESSION['uname'], $_POST["did"], $_POST["content"]);
    error_log($sql);

    //$s = "<ul class='row'>";
    $comment_li_format = "<li><div><a style='font-weight: bold'>%s:</a><span>%s</span></div></li>";
    
    $result = mysql_query($sql);
    if ($result) {
        $comment_li = sprintf($comment_li_format, $_SESSION['uname'], $_POST["content"]);
    }
    //$s .= "</ul>";
    error_log($comment_li);

    //$cmt_form = "<form method='post' class='cmt-form'><textarea name='content' style='width:85%; margin: 3px 2px 2px 3px;'></textarea>";
    //$cmt_form .= sprintf("<input type='hidden' name='did' value=%d />", $_GET["did"]);
    //$cmt_form .= "<input type='submit' class='btn btn-primary' style='float: right; margin-right:2px;' value='Comment' /></form>";
    //error_log($cmt_form);

    $json_arr = array("result"=>"success", "did"=>$_POST["did"], "comment"=>$comment_li);
    //error_log($json_arr);
    echo json_encode($json_arr);
}

mysql_close($connect);

?>
