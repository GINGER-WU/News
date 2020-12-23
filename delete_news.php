<?php
include_once("functions/is_login.php");
session_start();
if(!is_login()){
    echo "请您登录系统后，再访问该页面！";
    return;
}
else{
    $news_id=$_POST['news_id'];
    $sql = "delete from news where news_id=$news_id";
    $sql1 = "delete from review where news_id=$news_id";
    include_once("functions/database.php");
    get_connection();
    $result=mysqli_query($database_connection,$sql);
    $result1=mysqli_query($database_connection,$sql1);
    close_connection();
    echo "<script>alert('删除成功');location.href='index.php'</script>";
}
?>