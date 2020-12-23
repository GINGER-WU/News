<?php
include_once("functions/database.php");
$id=$_POST['id'];
get_connection();
$updateSQL="delete from review where review_id='$id'";
mysqli_query($database_connection,$updateSQL);
close_connection();
echo "<script>alert('该评论已删除');location.href='index.php'</script>";
?>