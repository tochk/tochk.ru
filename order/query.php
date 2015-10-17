<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();

$email = mysql_real_escape_string($_POST['author']);
$name = mysql_real_escape_string($_POST['name']);
$comment = mysql_real_escape_string($_POST['comment']);
if ($comment == '') {
    $main->timer_save();
    header('Location: /order/');
    exit();
}
$query = "INSERT INTO `support` SET `name`='$name', `email` = '$email', `comment`='$comment', `time`='$main->time', `project`='TOCHKRU', `ip`='$main->ip'";
$sql = mysql_query($query) or die(mysql_error());
$main->timer_save();
header('Location: /order/?ok=1');