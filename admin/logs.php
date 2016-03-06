<?php
session_start();
$title = "Логи пользователей";
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
$content = "<br /><div style='text-align: center;'><h1>Логи пользователей</h1><br />
<h3><a href='/admin/'>Панель управления сайтом</a> |||
<a href='/admin/stat.php'>Статистика посещений</a> |||
<a href='/admin/users.php'>Список пользователей</a> |||
Логи<br /></h3>
</div>
<form action='/admin/logs.php?do=show' method='post'><br />
Введите ID пользователя : <input type='text' name='id' value='{$_POST['id']}' />
<input type='submit' value=' Показать ' /></form>";
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);