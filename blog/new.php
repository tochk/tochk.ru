<?php
session_start();
$title = "Создать новость";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /error/denied.php');
    exit();
}
$newsid = mysql_real_escape_string($_GET['id']);
$query = "SELECT * FROM `news` WHERE `id`='$newsid' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$content = "<br /><h4><center>
<form action='/blog/process.php?do=new' method='post'>
Название: <input type='text' name='theme' size='25' /><br />
Текст: <textarea name='text' cols='48' rows='8'></textarea><br />
<input type='submit' value=' Сохранить ' />
</form></center></h4>
</div>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>