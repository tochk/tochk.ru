<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /error/denied.php');
    exit();
}
$theme = mysql_real_escape_string($_POST['theme']);
$text = mysql_real_escape_string($_POST['text']);
if ($_GET['do'] == 'new') {
    $query = "INSERT INTO news(name, time, content) VALUES ('$theme', '$time', '$text')";
    $sql = mysql_query($query) or die(mysql_error());
}
if ($_GET['do'] == 'edit') {
    $newsid = mysql_real_escape_string($_GET['id']);
    $query = "UPDATE `news` SET `name`='$theme', `content`='$text' WHERE id='$newsid'";
    $sql = mysql_query($query) or die(mysql_error());
}
header('Location: /news/');
include('../engine/main_stat.php');
?>