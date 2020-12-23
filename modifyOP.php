<?php
include_once("functions/is_login.php");
session_start();
if(!is_login()){
    echo "请您登录系统后，再访问该页面！";
    return;
}
else{
    $news_id=$_POST['news_id'];
    $user_id = $_SESSION["user_id"];
    $category_id = $_POST["category_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $currentDate =  date("Y-m-d H:i:s");
    $clicked = 0;
    $sql = "update news set category_id=$category_id,title='$title',content='$content',publish_time='$currentDate',clicked=$clicked where news_id=$news_id";
    include_once("functions/database.php");
    get_connection();
    mysqli_query($database_connection,$sql);
    close_connection();
    echo "<script>alert('修改成功');location.href='news_detail.php?news_id=$news_id'</script>";
}
?>