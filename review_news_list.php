<?php
include_once("functions/database.php");
get_connection();
$news_id=$_GET["news_id"];
$sql="select * from news where news_id=$news_id";
$result=mysqli_query($database_connection,$sql);
$row=mysqli_fetch_array($result);
$sql1 = "select * from review where news_id=$news_id and state='已审核' order by review_id desc";
$result_set = mysqli_query($database_connection,$sql1);
close_connection();
$htm= <<<EOF
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
        <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">《{$row['title']}》</font></h1></caption><br><br>
<a style='margin-left: 10%;background-size: cover;' href='index.php' class='file'>返回</a>
EOF;
echo $htm;
while($row1 = mysqli_fetch_array($result_set)){
    echo"<table class='t' style='margin-left: 32.5%' border='1' width='700' height='30'>";
    echo"<tr>";
    echo"<td >";
    echo "<font size='4px' color='#5aa8ff' >评论内容：</font><font size='4px' color='#ffffff' >{$row1['content']}</font><br/>";
    echo"</td>";
    echo "<td align='center' style='border-bottom: transparent'>";
    echo"</tr>";
    echo"</table>";
    echo"<table class='t' style='margin-left: 32.5%' border='1' width='700' height='30'>";
    echo"<tr>";
    echo"<td style='border-bottom: transparent'width='35%'>";
    echo "<font size='3px' color='#686868' >评论IP地址：</font><font size='3px' color='#686868' >{$row1['ip']}</font>";
    echo"</td>";
    echo"<td style='border-bottom: transparent'>";
    echo "<font size='3px' color='#686868' >评论日期：</font><font size='3px' color='#686868' >{$row1['publish_time']}</font>";
    echo"</td>";
    echo"</tr>";
    echo"</table>";
}
$html= <<<EOT
    </body>
    <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/main.js"></script>
</html>
EOT;
echo $html;
?>