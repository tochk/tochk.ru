<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$email = mysql_real_escape_string($_POST['author']);
$name = mysql_real_escape_string($_POST['name']);
$comment = mysql_real_escape_string($_POST['comment']);
if ($comment == '') {
    include('../engine/main_stat.php');
    header('Location: /support/');
    exit();
}
$prj = 'TOCHKRU';
$query = "INSERT INTO `support` SET `name`='$name', `email` = '$email', `comment`='$comment', `time`='$time', `project`='$prj', `ip`='$stat_ip'";
$sql = mysql_query($query) or die(mysql_error());
include('../engine/main_stat.php');
header('Location: /support/?ok=1');
?>