<?php
session_start();
$title = "Редактирование проекта";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /error/denied.php');
    exit();
}
$prid = mysql_real_escape_string($_GET['id']);
$query = "SELECT * FROM `indexpr` WHERE `id`='$prid' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$content = "<h4><center>
<form action='/admin/index_process.php?do=edit&id=$prid' method='post'>
Название: <input type='text' name='name' size='25' value='{$row['name']}' /><br />
Комментарий: <textarea name='comment' cols='48' rows='8'>{$row['comment']}</textarea><br />
Путь до проекта: <input type='text' name='url' size='25' value='{$row['url']}' /><br />
Путь до логотипа: <input type='text' name='img_url' size='25' value='{$row['img_url']}' /><br />
Тип: <input type='text' name='type' size='25' value='{$row['type']}' /><br />
Приоритет: <input type='text' name='pr' size='25' value='{$row['pr']}' /><br />
<input type='submit' value=' Создать ' />
</form>
<br /><br />
Типы: PR - проект, SR - сервис, NULL - общее
</center></h4>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>