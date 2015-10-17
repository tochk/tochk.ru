<?php
session_start();
$title = "Главная";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
$content = "<br /><br />";
if ((isset($_SESSION['log_err'])) && ($_SESSION['log_err'] == 1)) {
    $content = $content . "<br /><h2><center>Неправильный логин или пароль</center></h2><br />";
    $_SESSION['log_err'] = 0;
}
$query = "SELECT * FROM `{$config['table_prefix']}index` ORDER BY pr DESC";
$result = mysql_query($query) or die(mysql_error());
$index = mysql_fetch_array($result, MYSQL_ASSOC);
while ($index) {
    if ($main->admin == 1) $content = $content . "<a href='/admin/index_edit.php?id={$index['id']}'>Редактировать</a><a href='/admin/index_process.php?do=delete&id={$index['id']}'>Удалить</a>";
    if ($index['img_url'] == '') $index['img_url'] = "/design/images/index/logo.png";
    $content = $content . "<br /><div id='block_content'><a href='{$index['url']}' target='_blank'><img src='{$index['img_url']}' align='left' vspace='5' hspace='5'><h3>{$index['name']}</h3></a>{$index['comment']}</div>";
    $index = mysql_fetch_array($result, MYSQL_ASSOC);
}
if ($main->admin == 1) $content = $content . "<h2><a href='/admin/index_create.php' style='margin: 0;'>Добавить ссылку на проект</a></h2>";
else $content = $content . "<br />";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . './design/html/main.php', $title);
