<?php
session_start();
$title = "Обратная связь";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
$content = "<br /><center>";
if ($_GET['ok'] == 1)
    $content = $content . "<br /><h1>Ваше сообщение отправлено администратору.</h1>";
$content = $content . "<form action='/support/query.php' method='post'>
<p><input type='text' name='author' size='25' /> <small> Email для связи (необязательно)</small></p>
<p><input type='text' name='name' size='25' /> <small> Тема (необязательно)</small></p>
<p><textarea name='comment' cols='48' rows='8'></textarea></p>
<p><input name='submit' type='submit' id='submit' value=' Отправить ' /></p>
</form></center>";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);
