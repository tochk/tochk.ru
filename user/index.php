<?php
session_start();
$title = "Профиль пользователя";
if (isset($_SESSION['id']) == 0) {
    header('Location: /error/denied.php');
    exit();
}

include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$content = "<br />Информация о пользователе (В разработке)<br /><br />";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>