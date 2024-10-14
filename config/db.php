<?php 

$hostname = "localhost";
$db_username = "root";
$db_name = "todo_app";
$conn = mysqli_connect($hostname, $db_username, "", $db_name);

if (!$conn) {
    var_dump(mysqli_connect_error());
}