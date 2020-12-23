<?php
include_once("functions/database.php");
include_once("functions/is_login.php");
include_once ("functions/file_system.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
if(!is_login()){
    echo"<script>alert('登陆后才能进入该页面');location.href='login.php'</script>";
    return;
}
$news_id=$_GET["news_id"];
get_connection();
$sql="select * from news where news_id=$news_id";
$result=mysqli_query($database_connection,$sql);
$row=mysqli_fetch_array($result);
$sql1="select * from category where category_id={$row['category_id']}";
$result1=mysqli_query($database_connection,$sql1);
$row1=mysqli_fetch_array($result1);
$sql2="select * from users where user_id={$row['user_id']}";
$result2=mysqli_query($database_connection,$sql2);
$row2=mysqli_fetch_array($result2);
$sql_news_update = "update news set clicked=clicked+1 where news_id=$news_id";
$result3=mysqli_query($database_connection,$sql_news_update);
$sql_review_query = "select * from review where news_id=$news_id and state='已审核'";
$result_review = mysqli_query($database_connection,$sql_review_query);
$count_news = mysqli_num_rows($result);
$result_news_count=mysqli_query($database_connection,"select * from news");
$news_count= mysqli_num_rows($result_news_count);
//取出结果集中该新闻"已审核"的评论条数
$count_review = mysqli_num_rows($result_review);
$imgName = $row['attachment'];
if($count_news==0){
    echo "该新闻不存在或已被删除！";
    exit;
}
close_connection();
mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_free_result($result2);
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
     <div class="tabnews">
     <div class="codeBox">
        <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">《{$row['title']}》</font></h1></caption><br>
EOF;
echo $htm;
if($news_count<15){
echo"<a style='margin-left: 3%;background-size: cover;' href='index.php' class='file'>返回主页</a>";
}else{
echo"<a style='margin-left: 3%;background-size: cover;' href='lookNews.php' class='file'>返回时下新闻</a>";
}

if($_SESSION['user_id']==$row['user_id']||$_SESSION['user_id']==1)
{
    echo"
<form action='news_modify.php' method='post' onsubmit='return alter();'>
<input type='hidden' name='title' value={$row['title']}>
<input type='hidden' name='category_id' value={$row['category_id']}>
<input type='hidden' name='content' value={$row['content']}>
<input type='hidden' name='attachment' value={$row['attachment']}>
<input type='hidden' name='news_id' value=$news_id>
<input type='hidden' name='user_id' value={$row['user_id']}>
<a style='margin-left: 3%' href='javascript:;' class='file'><input type='submit'>修改</a>
</form>";
}
$html2=<<<EOY

        <table class='t' style='margin-left: 15%' border='1' width='500' height='30'>
        <tr>
        <td style="border-bottom: transparent" width="15%" align="left"><font size='3px' color='#5aa8ff' >类别：</font></td> <td align="left" style="border-bottom: transparent"><font size='3px' color='#ffffff' >{$row1['name']}</font></td>
        </tr>
        <tr>
        <td style="border-bottom: transparent" width="15%" align="left"><font size='3px' color='#5aa8ff' >发布者：</font></td> <td align="left" style="border-bottom: transparent"><font size='3px' color='#ffffff' >{$row2['name']}</font></td>
        </tr>
        <tr>
        <td style="border-bottom: transparent" width="20%" align="left"><font size='3px' color='#5aa8ff' >发布时间：</font></td> <td align="left" style="border-bottom: transparent"><font size='3px' color='#ffffff' >{$row['publish_time']}</font></td>
        </tr>
        <tr>
        <td style="border-bottom: transparent" width="20%" align="left"><font size='3px' color='#5aa8ff' >浏览次数：</font></td> <td align="left" style="border-bottom: transparent"><font size='3px' color='#ffffff' >{$row['clicked']}</font></td>
        </tr>
        <tr>
         <td style="border-bottom: transparent" width="20%" align="left"><font size='3px' color='#5aa8ff' >附件：</font></td><td align="left" style="border-bottom: transparent"><a href="download.php?attachment={$row['attachment']}"> <font size='3px' color='#ffffff' >{$row['attachment']}</font></a></td>
        </td>
        </tr>
        </table>
        <br>
        <div style="width: 1300px;word-wrap: break-word;word-break: break-all">
        <p style="margin-left: 330px;font-size: 20px"><font style="color: aliceblue;font-family: 'Arial font'">{$row['content']}</font></p>
        </div><br/>
        <div style="margin:auto;width:400px">
        <img src="uploads/$imgName" width="400"/>
        </div>
        <br/>
        <br/>
EOY;
echo $html2;
if($count_review>0)
{
    echo "<font style='margin-left:21%' size='3px' color='#5aa8ff' >评论：</fontleft><a href='review_news_list.php?news_id=".$row['news_id']."'><font size='3px' color='#fff' >共有".$count_review."条评论</font></a><br/>";
}else{
    echo "<font style='margin-left:21%' size='3px' color='#5aa8ff' >该新闻暂无评论！</font><br/>";
}
$html= <<<EOT
<form action="reviewOP.php" method="post">
    <textarea class="text" style="height:3%;width: 50%;margin-left: 21%;border-color: #a8a8a8" type="remark" cols="50" rows="1" name="content" placeholder="请输入您的评论..."></textarea>
     <a href="javascript:;" class="file">
     <input type="submit" >评论</a>
     <input type="hidden" name="news_id" value="{$row['news_id']}">
    </form>
    </div>
    </div>
    </body>
    <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/main.js"></script>
</html>
EOT;
echo $html;


