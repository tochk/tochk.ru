<?php
session_start();
$title = "Проекты";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$content = "<br /><br />";
$query = "SELECT * FROM `indexpr` WHERE `type`='PR' ORDER BY pr DESC";
$result = mysql_query($query) or die(mysql_error());
$index = mysql_fetch_array($result, MYSQL_ASSOC);
while ($index) {
    if ($index['img_url'] == '') $index['img_url'] = "/design/images/index/logo.png";
    $content = $content . "<br /><div id='block_content'><a href='{$index['url']}' target='_blank'><img src='{$index['img_url']}' target='_blank' align='left' vspace='5' hspace='5'><h3>{$index['name']}</h3></a>{$index['comment']}</div>\n";
    $index = mysql_fetch_array($result, MYSQL_ASSOC);
}
if ($admin == 1) $content = $content . "<h2><a href='/admin/index_create.php' style='margin: 0;'>Создать</a></h2>";
$content = $content . "<br />";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>