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
if ($user->isAdmin != 1) {
    header('Location: /');
    exit;
}
$logs->setCreateClasses();
$content = '';
if (isset($_POST['theme']))
{
    $query = "UPDATE `posts` SET `theme` = ? , `short_text` = ?  WHERE `id`=?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("ssd", $_POST['theme'], $_POST['text2'], $_GET['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: /blog/show.php?id={$_GET['id']}");
} else {
    if (isset($_GET['id'])) {
        $query = "SELECT `theme`, `short_text` FROM `posts` WHERE `id`=?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("d", $_GET['id']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows != 1) {
            $content .= 'Запись не найдена';
            $stmt->close();
        } else {
            $row['theme'] = $row['short_text'] = '';
            $stmt->bind_result($row['theme'], $row['short_text']);
            $stmt->fetch();
            $title = $row['theme'];
            $content .= "<div id='create_new_post_form'>" .
                "<form action='/blog/edit.php?id={$_GET['id']}' method='post'>" .
                "<input id = 'name_news' type='text' placeholder='Заголовок' name='theme' value='{$row['theme']}'><br>" .
                "<textarea id= 'text_news' name='text2' placeholder='Текст новости'>{$row['short_text']}</textarea><br>" .
                "<input id='button_news' type='submit' value='Добавить'></form></div>";
            $stmt->close();
        }
    } else {
        $content .= 'Запись не найдена';
    }
}

$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);