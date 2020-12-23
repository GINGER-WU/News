<?php
//error_reporting(0);
include_once("functions/is_login.php");
include_once("functions/database.php");
if (!session_id()){//这里使用session_id()判断是否已经开启了Session
    session_start();
}
if(!is_login()){
    echo"<script>alert('登陆后才能进入该页面');location.href='login.php'</script>";
    return;
}
$num=0;
get_connection();
$sql="select * from news order by clicked desc limit 0,15";
$result=mysqli_query($database_connection,$sql);
$html = <<<EOF
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
    <body>
        <div class="tab">
            <div class="titleBox" id="tittleBox" style="width: 13%">
            <button id="bt" style="margin-left: 60%;margin-top: 5%" class="btn-sign btn btn-default ripple btn-lg" type="button" onclick="toggle('titleList')"></button>
                <ul class="titleList" id='titleList' style="display:block;">
                    <li>
                        <span><font size="4px">评论浏览</font></span>
                    </li>
                    <li>
                        <span><font size="4px">分类浏览</font></span>
                    </li>
                    <li>
                        <span><font size="4px">首    页</font></span>
                    </li>
                    <li>
                        <span><font size="4px">新闻发布</font></span>
                    </li>
                    <li>
                        <span><font size="4px">添加分类</font></span>
                    </li>
                </ul>
                <div class="backBox" id="backBox" style="margin-top: 20%"></div>
            </div>
            <div class="contentBox" id="contentBox" style="width: 87%;">
                <ul class="contentList" style="overflow-y: auto">
                    <li>
                         <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">评 论 浏 览</font></h1></caption><br><br>           
EOF;
echo $html;
if($_SESSION['user_id']==1) {
    $id=$_SESSION['user_id'];
    $page_size=5;
    if(isset($_GET["page_current"])){
        $page_current = $_GET["page_current"];
    }else{
        $page_current=1;
    }
    $start=($page_current-1)*$page_size;
    $sql_review = "select * from review order by review_id desc limit $start,$page_size";
    $result_review = mysqli_query($database_connection,$sql_review);
    echo"<font size='5px' color='#ffffff' style='margin-left:7% '>以下是全部评论：</font>";
    echo"<br><br>";
    while ($row_review = mysqli_fetch_array($result_review)) {
        $result_title = mysqli_query($database_connection,"select * from news where news_id={$row_review['news_id']}");
        $row_title= mysqli_fetch_array($result_title);
        echo "<table class='t' style='margin-left: 25%' border='1' width='800' height='30'>";
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
        echo "<table class='t' style='margin-left: 25%' border='1' width='800' height='30'>";
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
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "<a href='lookreview.php?id=$id' style='margin-left: 50%' class='file' >查看更多</a>";
}
else{
    $id=$_SESSION['user_id'];
    $page_size=5;
    if(isset($_GET["page_current"])){
        $page_current = $_GET["page_current"];
    }else{
        $page_current=1;
    }
    $start=($page_current-1)*$page_size;
    $sql_review = "select * from review where user_id={$_SESSION['user_id']} order by review_id desc limit $start,$page_size";
    $result_review = mysqli_query($database_connection,$sql_review);
    echo"<font size='5px' color='#ffffff' style='margin-left:7% '>以下是您的全部评论：</font>";
    echo"<br><br>";
    while ($row_review = mysqli_fetch_array($result_review)) {
        $result_title = mysqli_query($database_connection,"select * from news where news_id={$row_review['news_id']}");
        $row_title= mysqli_fetch_array($result_title);
        echo "<table class='t' style='margin-left: 25%' border='1' width='800' height='30'>";
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
        echo "<table class='t' style='margin-left: 25%' border='1' width='800' height='30'>";
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
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "<a style='margin-left: 50%' href='lookreview.php?id=$id' class='file'>查看更多</a>";
}

$html7=<<<EOY
                    </li>
                    <li>
                         <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">分 类 浏 览</font></h1></caption>
                             <form action="findOP.php" method="post">
                             <div class="search bar8">
                             <font size="5px" color="#ffffff">类别：</font>
                             <select name="cn" size="1">
EOY;
echo $html7;
$result_set = mysqli_query($database_connection,"select * from category");
while($select = mysqli_fetch_array($result_set)){
    echo"<option value='{$select['category_id']}'>{$select['name']}</option>";
}
$html5=<<<EOB
                             </select>
                             <br>
                             <br>
                             <font size="5px" color="#ffffff" >检索热点</font>
                             <input class="ip" style="margin-top: 55px" type="text" name="keywords" placeholder="请输入您要搜索的内容...">
                             <button class="bt1" type="submit"></button>
                             </form>
                             </div>
                             <br>
                             <br>
EOB;
echo $html5;
echo"</li>";


$html6=<<<EOZ
                    <li>
                            <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">时 下 热 点</font></h1></caption>
                            <div class="search bar8">
                            <form action="findOP.php" method="post">
                            <input type="hidden" name="cn" value=""/>
                            <font size="5px" color="#ffffff" >检索热点</font><input class="ip" type="text" name="keywords" placeholder="请输入您要搜索的内容...">
                            <button class="bt1" type="submit"></button>
                            <a style="margin-left: 58.5%" href='logout.php' class='file' onclick='return alter();'>注销</a>
                            </form>
                            </div>
EOZ;
echo $html6;
echo "<div class='codeBox' style='width: 1100px'> ";
echo"<table class='t' style='margin-left: 5%' border='1' width='1000' height='50'>  ";
while($row=mysqli_fetch_array($result))
{
    $num++;
    echo "<tr>
                            <td width='8%' align='center'><font size='5px' color='#ffffff' >$num</font></td>
                            <td align='center'> 
                            <a href='news_detail.php?s=1&news_id={$row['news_id']}' style='text-decoration:none'><font size='5px' style='color: #5aa8ff;' >{$row['title']}</font></a>
                            <font size='3px' style='color:hotpink;margin-left: auto; ' >（浏览次数：{$row['clicked']}）</font>
                            </td>
                            </tr>";
}
echo"</table>";
echo"</div>";
echo"<div style='margin-top: 20px'>";
if($num>=15){
         echo "<a style='margin-left: 800px' href='lookNews.php' class='file'>查看更多 </a>";
}
  echo"</div>";



$html1=<<<EOT


                    </li>
                    <li>
                    <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">发 布 新 闻</font></h1></caption>
                    <form action="newsOP.php" method="post" enctype="multipart/form-data">
                    <table class="t" style="margin-left: 15%;margin-top: 5%" border="1" width="1000">
                    <tr>
                     <th align="right" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">类别：</font>
                     </th>
                     <th align="left" style="border-bottom: transparent">
                     <select name="category_id" size="1">
EOT;
echo $html1;
$result_set = mysqli_query($database_connection,"select * from category");
while($select = mysqli_fetch_array($result_set)){
    echo"<option value='{$select['category_id']}'>{$select['name']}</option>";
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
                     <input class="inp" type="text" name="title" placeholder="请输入您的新闻标题...">
                     </th>
                     </tr>
                     <tr>
                     <th align="right" valign="top" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">内容：</font>
                     </th>
                     <th align="left">
                     <textarea class="text" type="remark" cols="50" rows="10" name="content" placeholder="请输入您新闻的内容..."></textarea>
                     </th>
                     </tr>
                     <tr>
                     <th align="right" valign="top" style="border-bottom: transparent">
                     <font size="5px" color="#5aa8ff">附件：</font>
                     </th>
                     <th align="left" style="border-bottom: transparent">
                     <a href="javascript:;" class="file">
                     <input type="file" name="news_file" size="50">上传附件</a>
                     <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                     </th>
                    </table>
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
                    </li>
                    <li>
                        <caption><h1 align="center" style="margin-top: 1%"><font color="#f0f8ff">添 加 分 类</font></h1></caption>
EOC;
echo $html2;
if($_SESSION['user_id']!=1)echo "<br><font style='margin-left: 44%' size='4px' color='#d4353b'>您并没有权限来添加分类</font>";
$html4=<<<EOA
                        <form action="categoryOP.php" method="post">
                        <table class="t" style="margin-left: 15%;margin-top: 5%" border="1" width="1000">
                        <tr>
                        <th align="right" style="border-bottom: transparent">
                        <font size="5px" color="#5aa8ff">类名：</font>
                        </th>
                        <th align="left">
                        <input style="margin-top: 1%" class="inp" type="text" name="cname" placeholder="请输入您的类名...">
                        </th>
                        </tr>
                        </table>
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
                        <font style="margin-left: 20%" size='3px' color='#5aa8ff' >当前类别有：</font>
EOA;
echo $html4;
$result_set1 = mysqli_query($database_connection,"select * from category");
while($select1 = mysqli_fetch_array($result_set1)){
    echo" <font style='size='3px' color='#fff' >{$select1['name']}; </font>";
}
$html3=<<<EOG
                    </li>
                </ul>
            </div>
        </div>
    </body>
    <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/main.js"></script>
</html>
EOG;
echo $html3;
?>
