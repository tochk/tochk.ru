<?php
session_start();
$title = "Панель управления сайтом";
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
$content = "<br /><div style='text-align: center;'><h1>Панель управления сайтом</h1>
<br/>
Панель управления сайтом ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
<a href='/admin/logs.php'>Логи</a><br /></div>";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);