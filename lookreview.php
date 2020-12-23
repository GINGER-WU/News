<?php
include_once("functions/is_login.php");
include_once("functions/database.php");
include_once("functions/page.php");
$id=$_GET['id'];
get_connection();
$html = <<<EOF
<html>
    <head>
        <meta charset="utf-8">
        <title>浏览评论</title>
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
if($id==1){
    $page_size=5;
    if(isset($_GET["page_current"])){
        $page_current = $_GET["page_current"];
    }else{
        $page_current=1;
    }
    $start=($page_current-1)*$page_size;
    $sql_review = "select * from review order by review_id desc limit $start,$page_size";
    $result_review = mysqli_query($database_connection, $sql_review);
    echo "<font size='5px' color='#ffffff' style='margin-left:3%'>以下是全部评论：</font>";
    echo"<a href='index.php' style='margin-top: 10px;margin-left: 90%' class='file'><font size='5px' color='#3e8cff '> 返回主页面 </font></a>";
    echo "<br><br>";
    while ($row_review = mysqli_fetch_array($result_review)) {
        $result_title = mysqli_query($database_connection, "select * from news where news_id={$row_review['news_id']}");
        $row_title = mysqli_fetch_array($result_title);
        echo "<table class='t' style='margin-left: 31%' border='1' width='800' height='30'>";
        echo "<tr>";
        echo "<td width='70%'>";
        echo "<font size='4px' color='#5aa8ff' >评论内容：</font><font size='4px' color='#ffffff' >{$row_review['content']}";
        echo "</td>";
        echo "<td width='10%' align='center' >";
        if ($row_review['state'] == "已审核")
            echo "</font><br/><font size='4px' color='#546dff' >已审核</font>";
        if ($row_review['state'] == "未审核")
            echo "</font><br/><font size='4px' color='#d4353b' >未审核</font>";
        echo "</td>";
        echo "<td align='center' style='border-bottom: transparent'>";
        echo "<form action='review_state.php' method='post' onsubmit='return alter();'>";
        echo "<a href='javascript:;' class='file'><input type='submit' >审核</a>";
        echo "<input type='hidden' name='id' value={$row_review['review_id']}>";
        echo "</form>";
        echo "<form action='review_delete.php' method='post' onsubmit='return alter();'>";
        echo "<a href='javascript:;' class='file'><input type='submit' >删除</a>";
        echo "<input type='hidden' name='id' value={$row_review['review_id']}>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<table class='t' style='margin-left: 31%' border='1' width='800' height='30'>";
        echo "<tr>";
        echo "<td style='border-bottom: transparent'width='30%'>";
        echo "<font size='3px' color='#686868' >评论IP地址：</font><font size='3px' color='#686868' >{$row_review['ip']}</font>";
        echo "</td>";
        echo "<td style='border-bottom: transparent'width='35%'>";
        echo "<font size='3px' color='#686868' >评论日期：</font><font size='3px' color='#686868' >{$row_review['publish_time']}</font>";
        echo "</td>";
        echo "<td style='border-bottom: transparent'>";
        echo "<font size='3px' color='#686868' >新闻标题：</font><font size='3px' color='#686868' >{$row_title['title']}</font>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
    $url=$_SERVER['PHP_SELF'];
    $sql_total="select * from review";
    $result_total = mysqli_query($database_connection, "select * from review");
    $total_records=mysqli_num_rows($result_total);//共多少条留言
    $total_pages=ceil($total_records/$page_size);//共多少页
    page($total_records,$page_size,$page_current,$url,$id);
}else{
    $page_size=5;
    if(isset($_GET["page_current"])){
        $page_current = $_GET["page_current"];
    }else{
        $page_current=1;
    }
    $start=($page_current-1)*$page_size;
        $sql_review = "select * from review where user_id=$id order by review_id desc limit $start,$page_size";
        $result_review = mysqli_query($database_connection,$sql_review);
        echo"<font size='5px' color='#ffffff' style='margin-left:7% '>以下是您的全部评论：</font>";
        echo"<br><br>";
        while ($row_review = mysqli_fetch_array($result_review)) {
            $result_title = mysqli_query($database_connection,"select * from news where news_id={$row_review['news_id']}");
            $row_title= mysqli_fetch_array($result_title);
            echo "<table class='t' style='margin-left: 31% ' border='1' width='800' height='30'>";
            echo "<tr>";
            echo "<td width='70%'>";
            echo "<font size='4px' color='#5aa8ff' >评论内容：</font><font size='4px' color='#ffffff' >{$row_review['content']}";
            echo "</td>";
            echo "<td width='10%' align='center' >";
            if ($row_review['state'] == "已审核")
                echo "</font><br/><font size='4px' color='#546dff' >已审核</font>";
            if ($row_review['state'] == "未审核")
                echo "</font><br/><font size='4px' color='#d4353b' >未审核</font>";
            echo "</td>";
            echo "<td align='center' style='border-bottom: transparent'>";
            echo "<form action='review_delete.php' method='post' onsubmit='return alter();'>";
            echo "<a href='javascript:;' class='file'><input type='submit' >删除</a>";
            echo "<input type='hidden' name='id' value={$row_review['review_id']}>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<table class='t' style='margin-left: 31%' border='1' width='800' height='30'>";
            echo "<tr>";
            echo "<td style='border-bottom: transparent'width='30%'>";
            echo "<font size='3px' color='#686868' >评论IP地址：</font><font size='3px' color='#686868' >{$row_review['ip']}</font>";
            echo "</td>";
            echo "<td style='border-bottom: transparent'width='35%'>";
            echo "<font size='3px' color='#686868' >评论日期：</font><font size='3px' color='#686868' >{$row_review['publish_time']}</font>";
            echo "</td>";
            echo "<td style='border-bottom: transparent'>";
            echo "<font size='3px' color='#686868' >新闻标题：</font><font size='3px' color='#686868' >{$row_title['title']}</font>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        }
    $url=$_SERVER['PHP_SELF'];
    $sql_total="select * from review where user_id=$id";
    $result_total = mysqli_query($database_connection, "select * from review");
    $total_records=mysqli_num_rows($result_total);//共多少条留言
    $total_pages=ceil($total_records/$page_size);//共多少页
    page($total_records,$page_size,$page_current,$url,$id);
}
echo "</div>";
?>