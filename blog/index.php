<?php
session_start();
$title = "Блог";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}
$main = new page_init();
$main->std_page_init();
$content = "";
//if ($main->admin == 1) $content = $content . "<a href=/news/new.php>Создать новость</a><br />"; todo:создание поста
$query = "SELECT * FROM `posts` ORDER BY `id` DESC";
$result = mysql_query($query) or die(mysql_error());
$posts = mysql_fetch_array($result, MYSQL_ASSOC);
$a = mysql_num_rows($result);
if ($a > 20) $a = 20;
for ($i = 0; $i < $a; $i++) {
    $post_tags = '';
    $query = "SELECT * FROM `tags` WHERE `post` = '{$posts['id']}'";
    $tags_result = mysql_query($query) or die(mysql_error());
    while ($tags = mysql_fetch_array($tags_result, MYSQL_ASSOC)) {
        $query = "SELECT * FROM `tags_name` WHERE `id` = '{$tags['id']}'";
        $tag_result = mysql_query($query) or die(mysql_error());
        $tag = mysql_fetch_array($tag_result);
        $post_tags .= "{$tag['name']}<br>";
    }
    $content .= "<div id='block_news'><div id='block_in_block_news'><div id='block_in_block_news_2'><div id='block_news_head' style='font-size:20px;'  >{$posts['theme']}</div>
<div id='block_news_content' style='font-size:16px;'>{$posts['short_text']}</div></div></div><div id='block_news_info'><div id='block_news_info_2'><div id='block_date' style='font-size: 20px;'>{$posts['time']}</div>
<div id='block_data'><div id='data_author'> Author<br><text_green>{$posts['author']}</text_green></div><div id='data_category'> Tags<br><text_green>$post_tags</text_green></div>
<div id='data_com'> Comments<br><text_green>{$posts['comments']}</text_green></div></div><div id='block_info_footer' style='font-size: 20px;'> read more</div></div></div>
<div id='block_save' style='font-size: 20px;'> Save + </div></div>";
    //if ($admin == 1) $content = $content . " <a href=/news/edit.php?id={$news['id']}>Редактировать</a>";
    $posts = mysql_fetch_array($result, MYSQL_ASSOC);
}
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);