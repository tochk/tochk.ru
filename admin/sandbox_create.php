<?php
session_start();
$title = "Создание нового проекта в песочнице";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /error/denied.php');
    exit();
}
$content = "<h4><center>
<form action='/admin/sandbox_process.php?do=new' method='post'>
Название: <input type='text' name='name' size='25' /><br />
Комментарий: <textarea name='comment' cols='48' rows='8'></textarea><br />
Путь до проекта: <input type='text' name='url' size='25' /><br />
Путь до логотипа: <input type='text' name='img_url' size='25' /><br />
Приоритет: <input type='text' name='pr' size='25' /><br />
<input type='submit' value=' Создать ' />
</form>
</center></h4>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>