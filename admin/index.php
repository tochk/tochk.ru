<?php
session_start();
$title = "Панель управления сайтом";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include('../engine/history.php');
$content = "<br /><center><h1>Панель управления сайтом</h1></center>
<h3><center>
Панель управления сайтом ||| 
<a href='/admin/stat.php'>Статистика посещений</a> ||| 
<a href='/admin/users.php'>Список пользователей</a> ||| 
<a href='/admin/logs.php'>Логи</a><br />
<form action='/admin/query.php?session=1' method='post'><br />
SESSION[<input type='text' name='name' />] = <input type='text' name='value' />
<input type='submit' value=' Записать ' /></center>
</form><br />";
$result = mysql_query("SELECT * FROM invites ORDER BY id DESC");
$a = mysql_num_rows($result);
$myrow = mysql_fetch_array($result, MYSQL_ASSOC);
if ($a > 10) $a = 10;
for ($top = 1; $top < $a; $top++) {
    $content = $content . $myrow['invite'];
    if ($top % 3 == 0) $content = $content . "<br/>"; else $content = $content . " ||| ";
    $myrow = mysql_fetch_array($result, MYSQL_ASSOC);
}
$content = $content . "<a href='/admin/query.php?generate=1'>Сгенерировать код инвайта</a>
<br /><br />
<h5>tochkru by bezumnytochk (version 2.03.XX) 2013 - 2014 //<a href='https://github.com/madot/tochk.ru'>sources</a></h5>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>