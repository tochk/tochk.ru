<?php
session_start();
$logs = new Logs();
$title = "Проекты";
require($_SERVER['DOCUMENT_ROOT'] . '/engine/helpers.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$page = new Page();
$mysql = new Mysql();
$mysql->connect($page->getMysqlHost(), $page->getMysqlLogin(), $page->getMysqlPassword(), $page->getMysqlDb(), $page->debugLevel);
$user = new User($mysql);
$data = new Data();
$logs->setCreateClasses();
$content = "";
$query = "SELECT * FROM `projects` ORDER BY `id` DESC";
if ($result = $mysql->connection->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $content .= $data->printProject($row);
    }
}

$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);