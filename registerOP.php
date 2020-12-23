<?php
include_once("functions/database.php");
$name1=$_GET["name1"];
$password1=$_GET["password1"];
$password2=$_GET["password2"];
$question=$_GET['question'];
$answer=$_GET['answer'];
get_connection();
$sql1 = "select * from users where name='$name1'";
$result_set = mysqli_query($database_connection,$sql1);
$admin = mysqli_fetch_array($result_set);
if($name1=="")echo"<script>alert('名字不能为空');location.href='login.php'</script>";
else if($admin['name']==$name1)echo"<script>alert('用户名已存在');location.href='login.php';</script>";
else if($password1!=$password2)echo"<script>alert('两个密码不一致');location.href='login.php';</script>";
else if($password1==""||$password2=="")echo"<script>alert('密码不能为空');location.href='login.php'</script>";
else {
    $sql = "insert into users value(null,'$name1','$password1','$question','$answer')";
    $result = mysqli_query($database_connection, $sql);
    echo "<script>alert('注册成功');location.href='login.php'</script>";
}
close_connection();
?>