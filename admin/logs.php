<?php
session_start();
$title = "Логи пользователей";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include('../engine/history.php');
$content = "<br /><center><h1>Логи пользователей TOCHKRU</h1>
<h3><a href='/admin/'>Панель управления сайтом</a> ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
Логи<br /></h3>
</center><center>
<form action='/admin/logs.php?do=show' method='post'><br />
Введите ID пользователя : <input type='text' name='id' value='{$_POST['id']}' />
<input type='submit' value=' Показать ' /></center></form>";
if ($_GET['do'] == "show") {
    $userid = mysql_real_escape_string($_POST['id']);
    mysql_select_db("logs") or die (mysql_error());
    $result = mysql_query("SELECT * FROM logs_$userid ORDER BY id DESC");
    $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
    for ($i = 0; $i < mysql_num_rows($result); $i++) {
        $content = $content . "<center><h4>ID = {$myrow['id']} ACTION = {$myrow['action']} RESULT = {$myrow['result']} TIME=" . date('H:i d.m.Y', $myrow['time']) . "</h4></center>";
        $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
    }
}
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>