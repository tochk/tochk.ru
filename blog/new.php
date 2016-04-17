<?php
session_start();
$logs = new Logs();
$title = "Создать запись";
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
if ($user->isAdmin != 1) {
    header('Location: /');
    exit;
}
$logs->setCreateClasses();
if (isset($_POST['theme'])) {
    $query = "INSERT INTO `posts` (`theme`, `short_text`, `time`, `author`) VALUES (?, ?, ?, ?)";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("sssss", $_POST['theme'], $_POST['text2'], date("d.m.Y"), $user->login);
    $stmt->execute();
    $stmt->close();
    header("Location: /blog/show.php?id={$mysql->connection->insert_id}");
} else {
    $content = "<div id='create_new_post_form'>" .
        "<form action='/blog/new.php' method='post'>" .
        "<input id = 'name_news' type='text' placeholder='Заголовок' name='theme'><br>" .
        "<textarea id= 'text_news' name='text2' placeholder='Краткий текст новости'> </textarea><br>" .
        "<input id = 'name_news' type='text' placeholder='Тэги, через запятую' name='tags'><br>" .
        "<input id='button_news' type='submit' value='Добавить'></form></div>";
    $page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
}
$logs->setEnd();
$logs->writeToDb($mysql);