<?php
include_once("functions/is_login.php");
include_once("functions/database.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
if(!is_login()){
    echo"<script>alert('登陆后才能进入该页面');location.href='login.php'</script>";
    return;
}
$news_id=$_POST['news_id'];
$title=$_POST['title'];
$content=addslashes($_POST["content"]);
$category_id=$_POST['category_id'];
$attachment=$_POST['attachment'];
$se='selected="selected"';
$user_id=$_POST['user_id'];
$html1=<<<EOT
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
<caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">修 改 新 闻</font></h1></caption>
<a style='margin-left: 10%;background-size: cover;' href='news_detail.php?news_id=$news_id' class='file'>返回</a>
EOT;
echo $html1;
if($_SESSION['user_id']==$user_id||$_SESSION['user_id']==1)
{
    echo"
<form action='delete_news.php' method='post' onsubmit='return alter();'>
<input type='hidden' name='news_id' value=$news_id>
<a style='margin-left: 10%' href='javascript:;' class='file'><input type='submit' >删除</a>
</form>";
}
$html3=<<<EOL
                    <form action="modifyOP.php" method="post" enctype="multipart/form-data">
                    <table class="t" style="margin-left: 20%;margin-top: 5%" border="1" width="1000">
                    <tr>
                     <th align="right" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">类别：</font>
                     </th>
                     <th align="left" style="border-bottom: transparent">
                     <select name="category_id" size="1">
EOL;
echo $html3;
get_connection();
$result_set = mysqli_query($database_connection,"select * from category");
echo "<font size=\"5px\" color=\"#5aa8ff\">$category_id</font>";
while($select = mysqli_fetch_array($result_set)){
    if($category_id==$select['category_id']) echo"<option {$se} value='{$select['category_id']}'>{$select['name']}</option>";
    else echo"<option value='{$select['category_id']}'>{$select['name']}</option>";
}
$html2=<<<EOC
                     </select>
                     </th>
                     </tr>
                    <tr>
                     <th align="right" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">标题：</font>
                     </th>
                     <th align="left">
                     <input class="inp" type="text" name="title" value="$title" placeholder="请输入您的新闻标题...">
                     </th>
                     </tr>
                     <tr>
                     <th align="right" valign="top" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">内容：</font>
                     </th>
                     <th align="left">
                     <textarea class="text" type="remark" cols="50" rows="10" name="content" placeholder="请输入您新闻的内容...">$content</textarea>
                     </th>
                     </tr>
                    </table>
                    <input type="hidden" name="news_id" value="$news_id">
                    <table style="margin-left: 60%;margin-top: 2%;border-bottom: transparent;border-left: transparent;border-right: transparent;border-top-color: transparent;" border="1" width="200">
                    <tr>
                    <th style="margin-top: 10%">
                    <a href="javascript:;" class="file">
                     <input type="submit" >提交</a>
                      <a href="javascript:;" class="file">
                     <input type="reset" >重填</a>
                     </th>
                    </tr>
                    </table>
                    </form>
 <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/main.js"></script>
EOC;
echo $html2;