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
    $stmt->bind_param("ssss", $_POST['theme'], $_POST['text2'], date("d.m.Y"), $user->login);
    $stmt->execute();
    $stmt->close();
    $post_id = $mysql->connection->insert_id;
    $tags = explode(",", $_POST['tags']);
    $query = "DELETE FROM `tags` WHERE `post` = ?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("d", $post_id);
    $stmt->execute();
    $stmt->close();
    foreach ($tags as $tag) {
        $tag = trim($tag);
        if ($tag == '')
            continue;
        $query = "SELECT `id` FROM `tags_name` WHERE `name` LIKE ?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("s", $tag);
        $tag_id = 0;
        $stmt->bind_result($tag_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if ($stmt->num_rows != 1) {
            $stmt->close();
            $query = "INSERT INTO `tags_name` (`name`) VALUES (?)";
            $stmt = $mysql->connection->prepare($query);
            $stmt->bind_param("s", $tag);
            $stmt->execute();
            $stmt->close();
            $tag_id = $mysql->connection->insert_id;
        } else {
            $stmt->close();
        }
        $query = "INSERT INTO `tags` (`id`, `post`) VALUES (?, ?)";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("dd", $tag_id, $post_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: /blog/show.php?id={$post_id}");
} else {
    $content = "<div id='create_new_post_form'>" .
        "<form action='/blog/new.php' method='post'>" .
        "<input id = 'name_news' type='text' placeholder='Заголовок' name='theme'><br>" .
        "<textarea id = 'text_news' name='text2' placeholder='Краткий текст новости'> </textarea><br>" .
        "<input id = 'tags_news' type='text' placeholder='Тэги, через запятую' name='tags'><br>" .
        "<input id = 'button_news' type='submit' value='Добавить'></form></div>";
    $page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
}
$logs->setEnd();
$logs->writeToDb($mysql);