<?php
session_start();
include_once("functions/database.php");
$name=$_POST["name"];
$password=$_POST["password"];
get_connection();
$sql = "select * from users where name='$name' and password ='$password'";
$result_set = mysqli_query($database_connection,$sql);
if(mysqli_num_rows($result_set)>0)
{
    $admin = mysqli_fetch_array($result_set);
    $_SESSION['user_id'] = $admin['user_id'];
    $_SESSION['name'] = $admin['name'];
    echo"<script>alert('登陆成功');location.href='index.php'</script>";
}
else {
    echo"<script>alert('用户不存在或密码错误');location.href='login.php'</script>";
}
close_connection();
?>