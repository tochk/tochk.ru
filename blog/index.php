<?php
session_start();
$title = "Статьи";
require($_SERVER['DOCUMENT_ROOT'] . '/engine/helpers.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$page = new Page();
$mysql = new Mysql();
$mysql->connect($page->getMysqlHost(), $page->getMysqlLogin(), $page->getMysqlPassword(), $page->getMysqlDb(), $page->debugLevel);
$user = new User();
$logs = new Logs();
$data = new Data();
$content = "";
$query = "SELECT * FROM `posts` ORDER BY `id` DESC LIMIT 10";
if ($result = $mysql->connection->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $content .= $data->printPost($mysql->connection, $row);
    }
}
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);