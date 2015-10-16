<?php
session_start();
$title = "Панель управления сайтом";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include('../engine/history.php');
$content = "<br /><center><h1>Панель управления сайтом</h1></center>
<h3><center>
Панель управления сайтом ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
<a href='/admin/logs.php'>Логи</a><br />";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>