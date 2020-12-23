<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
$name = $_POST["cname"];
if($_SESSION['user_id']!=1)echo"<script>alert('您没有权利添加类名');location.href='index.php'</script>";
else if($name=="")echo"<script>alert('类名不能为空');location.href='index.php'</script>";
else {
    $sql = "insert into category values(null,'$name')";
    get_connection();
    mysqli_query($database_connection,$sql);
    close_connection();
    echo "<script>alert('类名添加成功');location.href='index.php'</script>";
}
?>