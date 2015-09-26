<?php
$id = $_SESSION['id'];
$time = time();
$query = "SELECT * FROM `users` WHERE `id`='$id' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$login = $row['login'];
$admin = $row['admin'];
$files = $row['files'];
$filesn = $row['filesn'];
$query = "SELECT * FROM `admin` WHERE `id`='1' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$closed = $row['closed'];
$update = $row['update'];
if ($closed == 1) {
    header('Location: /error/closed.php');
    exit();
}
$temp = microtime();
$temp = explode(" ", $temp);
$timer["ms_query"] = $temp[1] + $temp[0];
?>