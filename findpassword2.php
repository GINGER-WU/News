<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
include_once ("functions/file_system.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
get_connection();
$name=$_GET['name1'];
$sql="select * from users where name='$name'";
$result=mysqli_query($database_connection,$sql);
$row=mysqli_fetch_array($result);
$ans=$_GET['answer'];
if($ans==$row['answer']){
$html=<<<EOF
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="css/logincss.css" />
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body style="background: #080808;">
<caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">找回密码</font></h1></caption><br>
<div align="center" style="width: 50%;height: 20%;margin-left: auto;margin-right: auto;margin-top: 3%">
    <form action="findpassword3.php" method="get">
        <font size="4px" color="#5aa8ff">输入你的新密码：</font><input style="border-top: transparent" class="inp" type="text" name="pw1" placeholder="输入新密码...">
        <br>
        <br>
        <a style="margin-left: 55%" href="javascript:;" class="file" >
            <input type="hidden" name="name1" value="$name">
            <input type="submit">确认</a>
    </form>
</div>
</body>
</html>
EOF;
echo $html;
}
else  echo"<script>alert('回答错误！');location.href='findpassword.php'</script>";
?>