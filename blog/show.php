<?php
session_start();
$logs = new Logs();
$title = "Запись не найдена";
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
$content = '';
if (isset($_GET['id'])) {
    $query = "SELECT `id`, `time`, `theme`, `short_text`, `author`, `comments` FROM `posts` WHERE `id`=?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("d", $_GET['id']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows != 1) {
        $content .= 'Запись не найдена';
        $stmt->close();
    } else {
        $row['id'] = $row['time'] = $row['theme'] = $row['short_text'] = $row['author'] = $row['comments'] = '';
        $stmt->bind_result($row['id'], $row['time'], $row['theme'], $row['short_text'], $row['author'], $row['comments']);
        $stmt->fetch();
        $title = $row['theme'];
        $content .= $data->printPost($mysql->connection, $row);
        $stmt->close();
    }
} else {
    $content .= 'Запись не найдена';
}
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);