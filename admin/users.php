<?php
session_start();
$title = "Список пользователей";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include('../engine/history.php');
$content = "<br />
<center><h1>Список пользователей TOCHKRU</h1>
<h3><a href='/admin/'>Панель управления сайтом</a> ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
Список пользователей ||| 
<a href='/admin/logs.php'>Логи</a><br /></h3>
</center>";
$result = mysql_query("SELECT * FROM users ORDER BY id DESC");
$myrow = mysql_fetch_array($result, MYSQL_ASSOC);
for ($i = 0; $i < mysql_num_rows($result); $i++) {
    $content = $content . "<center><h4>ID = {$myrow['id']} LOGIN = {$myrow['login']} EMAIL = {$myrow['email']} FILES={$myrow['files']} FILESN={$myrow['filesn']}</h4></center>";
    $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
}
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>