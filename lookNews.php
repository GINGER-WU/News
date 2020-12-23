<?php
include_once("functions/is_login.php");
include_once("functions/database.php");
include_once("functions/page2.php");
get_connection();

$num=0;
$html = <<<EOF
<html>
    <head>
        <meta charset="utf-8">
        <title>时 下 热 点</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="css/main.css" />
        <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="tab" style="background: #080808;height: 100%">
EOF;
echo $html;

echo "<font size='7px' color='#ffffff' style='margin-left:850px '>时 下 热 点</font>";
    echo "<a href='index.php' style='margin-top: 10px;margin-left: 90%' class='file'><font size='5px' color='#3e8cff '> 返回主页 </font></a>";
echo "<br><br>";
echo "<div class='codeBox' style='width: 1100px'> ";
echo"<table class='t' style='margin-left: 5%' border='1' width='1000' height='50'>  ";
$page_size=15;
if(isset($_GET["page_current"])){
    $page_current = $_GET["page_current"];
}else{
    $page_current=1;
}
$start=($page_current-1)*$page_size;
$sql="select * from news order by clicked desc limit $start,$page_size";
$result=mysqli_query($database_connection,$sql);
while($row=mysqli_fetch_array($result))
{
    $num++;
    echo "<tr>
                            <td width='8%' align='center'><font size='5px' color='#ffffff' >$num</font></td>
                            <td align='center'> 
                            <a href='news_detail.php?s=0&news_id={$row['news_id']}' style='text-decoration:none'><font size='5px' style='color: #5aa8ff;' >{$row['title']}</font></a>
                            <font size='3px' style='color: red;margin-left: auto; ' >（浏览次数：{$row['clicked']}）</font>
                            </td>
                            </tr>";
}
echo"</table>";
echo"</div>";

$url=$_SERVER['PHP_SELF'];
$sql_total="select * from news";
$result_total = mysqli_query($database_connection, "select * from news");
$total_news=mysqli_num_rows($result_total);//共多少条新闻
$total_pages=ceil($total_news/$page_size);//共多少页
page2($total_news,$page_size,$page_current,$url);

?>