<?php
session_start();
$title = "Профиль пользователя";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

if (isset($_SESSION['id']) == 0) {
    header('Location: /error/denied.php');
    exit();
}
$main = new page_init();
$main->std_page_init();
$content = "<br />Информация о пользователе (В разработке)<br /><br />";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
