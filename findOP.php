<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
if(!is_login()){
    echo"<script>alert('登陆后才能进入该页面');location.href='login.php'</script>";
    return;
}
$c_id=$_POST['cn'];
$kw=$_POST['keywords'];
get_connection();
if($kw=="")$sql="select * from news where category_id=$c_id ";
else if($c_id=="")$sql="select * from news where content like '%$kw%' or title like '%$kw%' ";
else $sql="select * from news where content like '%$kw%' or title like '%$kw%' and category_id=$c_id ";
$result_find=mysqli_query($database_connection,$sql);
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
        <link rel="stylesheet" href="css/main.css" />
        <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body style="background: #080808;">
     <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">搜 索 结 果</font></h1></caption><br><br>
<a style='margin-left: 20%;background-size: cover;' href='index.php' class='file'>返回</a>
EOF;
echo $html;
echo"<table class='t' style='margin-left: 25%' border='1' width='900' height='50'>  ";
$num1=0;
while($row_find=mysqli_fetch_array($result_find))
{
    $num1++;
    echo "<tr>
                            <td width='8%' align='center'><font size='5px' color='#ffffff' >$num1</font></td>
                            <td align='center'> 
                            <a href='news_detail.php?news_id={$row_find['news_id']}'><font size='4px' style='color: #5aa8ff' >{$row_find['title']}</font></a>
                            </td>
                            </tr>";
}
echo"</table>";
$html1= <<<EOT
    </body>
    <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/main.js"></script>
</html>
EOT;
echo $html1;
?>