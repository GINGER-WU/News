<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
session_start();
if(!is_login()){
    echo "请您登录系统后，再访问该页面！";
    return;
}
$news_id = $_POST["news_id"];
//$content = htmlspecialchars(addslashes($_POST["content"]));
$content = addslashes($_POST["content"]);
$currentDate = date("Y-m-d H:i:s");
$ip = $_SERVER["REMOTE_ADDR"];
$state = "未审核";
$user_id=$_SESSION['user_id'];
if($content=="")echo"<script>alert('评论不能为空');location.href='news_detail.php?news_id=$news_id'</script>";
else {
    $sql = "insert into review values(null,$news_id,'$content','$currentDate','$state','$ip',$user_id)";
    get_connection();
    mysqli_query($database_connection,$sql);
    close_connection();
    echo "<script>alert('评论已提交审核');location.href='news_detail.php?news_id=$news_id'</script>";
}
?>