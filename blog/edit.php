<?php
session_start();
$logs = new Logs();
$title = "Редактировать запись";
if (!is_numeric($_GET['id']))
    exit;
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
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if (isset($_POST['theme'])) {
        $query = "UPDATE `posts` SET `theme` = ? , `short_text` = ?  WHERE `id`=?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("ssd", $_POST['theme'], $_POST['text2'], $_GET['id']);
        $stmt->execute();
        $stmt->close();
        $tags = explode(",", $_POST['tags']);
        $query = "DELETE FROM `tags` WHERE `post` = ?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("d", $_GET['id']);
        $stmt->execute();
        $stmt->close();
        foreach ($tags as $tag) {
            $tag = trim($tag);
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
            $stmt->bind_param("dd", $tag_id, $_GET['id']);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: /blog/show.php?id={$_GET['id']}");
    } else {
        $query = "SELECT `theme`, `short_text` FROM `posts` WHERE `id`=?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("d", $_GET['id']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows != 1) {
            $content .= 'Запись не найдена';
            $stmt->close();
        } else {
            $post['theme'] = $post['short_text'] = '';
            $stmt->bind_result($post['theme'], $post['short_text']);
            $stmt->fetch();
            $title = $post['theme'];
            $tags = '';
            $query = "SELECT `name` FROM `tags_name` WHERE `id` IN (SELECT `id` FROM `tags` WHERE `post` = '{$_GET['id']}')";
            $result = $mysql->connection->query($query);
            while ($row = $result->fetch_assoc()) {
                $tags .= "{$row['name']}, ";
            }
            $tags = substr($tags, 0, -2);
            $content .= "<div id='create_new_post_form'>" .
                "<form action='/blog/edit.php?id={$_GET['id']}' method='post'>" .
                "<input id = 'name_news' type='text' placeholder='Заголовок' name='theme' value=\"{$post['theme']}\"><br>" .
                "<textarea id= 'text_news' name='text2' placeholder='Текст новости'>{$post['short_text']}</textarea><br>" .
                "<input id = 'tags_news' type='text' placeholder='Тэги, через запятую' name='tags' value='$tags'><br>" .
                "<input id='button_news' type='submit' value='Обновить'></form></div>";
            $stmt->close();
        }

    }
} else {
    $content .= 'Запись не найдена';
}

$page->printPage($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
$logs->setEnd();
$logs->writeToDb($mysql);