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
$prid = mysql_real_escape_string($_GET['id']);
$name = mysql_real_escape_string($_POST['name']);
$comment = mysql_real_escape_string($_POST['comment']);
$url = mysql_real_escape_string($_POST['url']);
$img_url = mysql_real_escape_string($_POST['img_url']);
$type = mysql_real_escape_string($_POST['type']);
$pr = mysql_real_escape_string($_POST['pr']);
if ($_GET['do'] == 'new') {
    $query = "INSERT INTO indexpr (name, time, comment, url, img_url, type, pr) VALUES ('$name', '$time', '$comment', '$url', '$img_url', '$type', '$pr')";
    $sql = mysql_query($query) or die(mysql_error());
}
if ($_GET['do'] == 'edit') {
    $newsid = mysql_real_escape_string($_GET['id']);
    $query = "UPDATE `indexpr` SET `name`='$name', `comment`='$comment', `url`='$url', `img_url`='$img_url', `type`='$type', `pr`='$pr' WHERE id='$prid'";
    $sql = mysql_query($query) or die(mysql_error());
}
if ($_GET['do'] == 'delete') {
    $query = "DELETE FROM `indexpr` WHERE `id`='$prid'";
    $sql = mysql_query($query) or die(mysql_error());
}
include('../engine/main_stat.php');
header('Location: /');
?>