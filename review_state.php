<?php
include_once("functions/database.php");
$id=$_POST['id'];
get_connection();
$updateSQL="update review set state='已审核' where review_id=$id";
mysqli_query($database_connection,$updateSQL);
close_connection();
echo "<script>alert('该评论已审核');location.href='index.php'</script>";
?>