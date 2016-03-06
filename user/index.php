<?php
session_start();
$title = "Пользователь";
require($_SERVER['DOCUMENT_ROOT'] . '/engine/helpers.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}


$page = new Page();
$mysql = new Mysql();
$mysql->connect($page->getMysqlHost(), $page->getMysqlLogin(), $page->getMysqlPassword(), $page->getMysqlDb(), $page->debugLevel);
$user = new User($mysql);
if (!$user->isLoggedIn())
{
    header("Location: /");
    exit;
}
$title .= " " . $user->login;
$logs = new Logs();
$data = new Data();
$content = "Информация о пользователе (В разработке)";
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);