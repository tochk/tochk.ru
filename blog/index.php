<?php
session_start();
$title = "Блог";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}
$content = "<br /><br /><br />";
if ($admin == 1) $content = $content . "<a href=/news/new.php>Создать новость</a><br />";
$result = mysql_query("SELECT * FROM news ORDER BY id DESC");
$news = mysql_fetch_array($result, MYSQL_ASSOC);
$a = mysql_num_rows($result);
if ($a > 20) $a = 20;
for ($i = 0; $i < $a; $i++) {
    $content = $content . "<div id='news'><h3 style='margin:0;'>{$news['name']} [" . date('d.m.Y', $news['time']) . "]";
    if ($admin == 1) $content = $content . " <a href=/news/edit.php?id={$news['id']}>Редактировать</a>";
    $content = $content . "</h3><br />{$news['content']}<br /></div><br />";
    $news = mysql_fetch_array($result, MYSQL_ASSOC);
}
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . './design/html/main.php', $title);