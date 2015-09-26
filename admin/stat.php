<?php
session_start();
$title = "Статистика посещений";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include('../engine/history.php');
$content = "<br />
<center><h1>Статистика посещений TOCHKRU</h1>
<h3><a href='/admin/'>Панель управления сайтом</a> ||| 
Статистика посещений ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
<a href='/admin/logs.php'>Логи</a><br /></h3>
</center>
<br /><img src='/engine/stat.php' /><br />
<img src='/engine/stat_hosts.php' /><br />
<img src='/engine/stat_hits.php' />";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>