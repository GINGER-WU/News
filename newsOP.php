<?php
include_once("functions/is_login.php");
session_start();
if(!is_login()){
    echo "请您登录系统后，再访问该页面！";
    return;
}
?>
<?php
include_once("functions/file_system.php");
if(empty($_POST)){
    $message = "上传的文件超过了php.ini中post_max_size选项限制的值";
}else{
    $user_id = $_SESSION["user_id"];
    $category_id = $_POST["category_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $currentDate =  date("Y-m-d H:i:s");
    $clicked = 0;
    $file_name = $_FILES["news_file"]["name"];
    $message = upload($_FILES["news_file"],"uploads");
    $sql = "insert into news values(null,$user_id,$category_id,'$title','$content', '$currentDate',$clicked,'$file_name')";
    if($message=="文件上传成功！"||$message=="没有选择上传附件！"){
        include_once("functions/database.php");
        get_connection();
        mysqli_query($database_connection,$sql);
        close_connection();
    }
}
echo "<script>alert('$message');location.href='index.php'</script>";
?>