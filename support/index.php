<?php
session_start();
$title = "Обратная связь";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$content = "<br /><center>";
if ($_GET['ok'] == 1)
    $content = $content . "<br /><h1>Ваше сообщение отправлено администратору.</h1>";
$content = $content . "<form action='/support/query.php' method='post'>
<p><input type='text' name='author' size='25' /> <small> Email для связи (необязательно)</small></p>
<p><input type='text' name='name' size='25' /> <small> Тема (необязательно)</small></p>
<p><textarea name='comment' cols='48' rows='8'></textarea></p>
<p><input name='submit' type='submit' id='submit' value=' Отправить ' /></p>
</form>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>