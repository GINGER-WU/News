<?php
$html= <<<EOF
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
    <body style="background: #343638;">
        <div class="tab">
            <div class="titleBox" id="tittleBox" style="width: 13%">
                <ul class="titleList" id='titleList' style="display:block;">
                    <li>
                        <span><font size="4px">注 册</font></span>
                    </li>
                    <li>
                        <span><font size="4px">登 陆</font></span>
                    </li>
                </ul>
                <div class="backBox" id="backBox"></div>
            </div>
            <div class="contentBox" id="contentBox" style="width: 87%;">
                <ul class="contentList">
                    <li>
                    <form action="registerOP.php" method="get">
                     <div style="margin-top: 5%;margin-left: 5%">
                     <font size="4px" color="#5aa8ff">注册账号：</font>
                     <input class="inp" type="text" name="name1" placeholder="请输入您的登陆账号...">
                     <br>
                     <br>
                     <font size="4px" color="#5aa8ff">注册密码：</font>
                     <input class="inp" type="password" name="password1" placeholder="请输入您的登陆密码...">
                     <br>
                     <br>
                     <font size="4px" color="#5aa8ff">确认密码：</font>
                     <input class="inp" type="password" name="password2" placeholder="请确认您的登陆密码...">
                     <br>
                     <br>
                     <font size="4px" color="#5aa8ff">选择密保问题（当密码忘记可用来修改）：</font>
                     <select name="question" size="1">
                     <option value="你的真实姓名是什么？">你的真实姓名是什么？</option>
                     <option value="你的童年梦想是什么？">你的童年梦想是什么？</option>
                     <option value="你老板叫什么名字？">你老板叫什么名字？</option>
                     <option value="你的工作是什么？">你的工作是什么？</option>
                     <option value="你最好的朋友是谁？">你最好的朋友是谁？</option>
                     </select>
                     <br>
                     <br>
                     <font size="4px" color="#5aa8ff">答案：</font>
                     <input class="inp" type="text" name="answer" placeholder="请输入您的密保问题答案...">
                     <br>
                     <br>
                     <a href="javascript:;" class="file" >
                     <input type="submit">注册</a>
                     <a href="javascript:;" class="file" >
                     <input type="reset">重填</a>
                     </div>
                     </form>
                    </li>
                    <li>
                     <form action="loginOP.php" method="post">
                     <div style="margin-top: 5%;margin-left: 5%">
                     <font size="5px" color="#5aa8ff">账号：</font>
                     <input class="inp" type="text" name="name" placeholder="请输入您的登陆账号...">
                     <br>
                     <br>
                     <font size="5px" color="#5aa8ff">密码：</font>
                     <input class="inp" type="password" name="password" placeholder="请输入您的登陆密码...">
                     <br>
                     <br>
                     <br>
                     <a href="javascript:;" class="file" >
                     <input type="submit" >登陆</a>
                     <a href="javascript:;" class="file" >
                     <input type="reset" >重填</a>
                      <a style="margin-left: 30%;" class="cw" href="findpassword.php">忘记密码?</a>
                     </div>
                     </form>
                    </li>
                </ul>
            </div>
        </div>
    </body>
    <script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="js/loginJS.js"></script>
</html>
EOF;
echo $html;
?>
