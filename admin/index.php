<?php
session_start();
$title = "Панель управления сайтом";
require($_SERVER['DOCUMENT_ROOT'] . '/engine/helpers.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$page = new Page();
$mysql = new Mysql();
$mysql->connect($page->getMysqlHost(), $page->getMysqlLogin(), $page->getMysqlPassword(), $page->getMysqlDb(), $page->debugLevel);
$user = new User($mysql);
if ($user->isAdmin != 1) {
    header('Location: /');
    exit;
}
$logs = new Logs();
$data = new Data();
$content = "<br /><div style='text-align: center;'><h1>Панель управления сайтом</h1>
<br/><h3>Панель управления сайтом |||
<a href='/admin/stat.php'>Статистика посещений</a> |||
<a href='/admin/users.php'>Список пользователей</a> |||
<a href='/admin/logs.php'>Логи</a></h3><br /></div>";
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);