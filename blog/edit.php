<?php
session_start();
$logs = new Logs();
$title = "Редактировать запись";
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
$content = "<div id='create_new_post_form'>
<form action='/blog/edit.php' method='post'>
<input id = 'name_news' type='text' placeholder='Заголовок' name='theme'><br>
<textarea id= 'text_news' name='text2' placeholder='Краткий текст новости'> </textarea><br>
<textarea id= 'text_news' name='text' placeholder='Текст новости'> </textarea><br>
<input id='button_news' type='submit' value='Добавить'></form></div>";
$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);