<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
include_once ("functions/file_system.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
get_connection();
$name=$_GET['name1'];
$pw=$_GET['pw1'];
$sql="update users set password='$pw' where name='$name'";
if($pw=="")echo"<script>alert('密码为空');location.href='findpassword3.php';</script>";
else
{
    $result=mysqli_query($database_connection,$sql);
    echo"<script>alert('修改成功');location.href='login.php'</script>";
}