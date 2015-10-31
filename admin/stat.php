<?php
session_start();
$title = "Статистика посещений";
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
$content = "<br /><div style='text-align: center;'><h1>Статистика посещений</h1>
<br/>
<h3><a href='/admin/'>Панель управления сайтом</a> |||
Статистика посещений |||
<a href='/admin/users.php'>Список пользователей</a> |||
<a href='/admin/logs.php'>Логи</a></h3><br /></div>";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);