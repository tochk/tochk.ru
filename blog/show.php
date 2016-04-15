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
$query = "SELECT * FROM `users` WHERE `login`=?";
$stmt = $mysql->connection->prepare($query);
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows != 0) {
    $_SESSION['reg_err4'] = 1;
    $flag = 1;
}
$stmt->close();
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);