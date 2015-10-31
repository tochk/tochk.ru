<?php
session_start();
$title = "Список пользователей";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
if ($main->admin == 0) {
    header('Location: /');
    exit();
}
$content = "<br /><div style='text-align: center;'><h1>Список пользователей</h1>
<br/>
<h3><a href='/admin/'>Панель управления сайтом</a> |||
<a href='/admin/stat.php'>Статистика посещений</a> |||
Список пользователей |||
<a href='/admin/logs.php'>Логи</a></h3><br /></div>";
$result = mysql_query("SELECT * FROM users ORDER BY id DESC");
$myrow = mysql_fetch_array($result, MYSQL_ASSOC);
for ($i = 0; $i < mysql_num_rows($result); $i++) {
    $content .= "<div style='text-align: center;'><h4>ID = {$myrow['id']} LOGIN = {$myrow['login']} EMAIL = {$myrow['email']}</h4></div>";
    $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
}
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);