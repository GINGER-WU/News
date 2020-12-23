<?php
$database_connection=null;
function get_connection()
{
    $hostname = "localhost";
    $database = "news";
    $username = "root";
    $password = "root";
    global $database_connection;
    $database_connection = mysqli_connect($hostname, $username, $password) or die(mysqli_error());
    @mysqli_select_db($database_connection,"news");
}
function close_connection()
{
    global $database_connection;
    if($database_connection)
    {
        mysqli_close($database_connection) or die(mysqli_error());
    }
}
?>