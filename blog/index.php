<?php
session_start();
$title = "Новости";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
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
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>