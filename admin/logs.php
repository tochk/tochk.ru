<?php
session_start();
$title = "Логи пользователей";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
if ($main->admin == 0) {
    header('Location: /');
    exit();
}
$content = "<br /><div style='text-align: center;'><h1>Логи пользователей</h1><br />
<h3><a href='/admin/'>Панель управления сайтом</a> ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
Логи<br /></h3>
</div>
<form action='/admin/logs.php?do=show' method='post'><br />
Введите ID пользователя : <input type='text' name='id' value='{$_POST['id']}' />
<input type='submit' value=' Показать ' /></form>";
if ($_GET['do'] == "show") {
    $user_id = mysql_real_escape_string($_POST['id']);
    mysql_select_db("logs") or die (mysql_error());
    $result = mysql_query("SELECT * FROM `logs_$user_id` ORDER BY id DESC");
    $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
    for ($i = 0; $i < mysql_num_rows($result); $i++) {
        $content .= "<div style='text-align: center;'><h4>ID = {$myrow['id']} ACTION = {$myrow['action']} RESULT = {$myrow['result']} TIME=" . date('H:i d.m.Y', $myrow['time']) . "</h4></div>";
        $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
    }
}
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);