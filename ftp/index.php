<?php
session_start();
$title = "Файлхостинг";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if (empty($_SESSION['id'])) {
    header('Location: /error/denied.php');
    exit();
}
$content = "<br />";
if ($_GET['ok'] == 1)
    $content = $content . "<h4>Файл успешно загружен.</h4>
<input size=40 type='text' value='http://tochk.ru/ftp/download.php?file_id={$_GET['file_id']}&id={$_GET['id']}&key={$_GET['key']}' onclick='this.select()' /><br />";
if ($_GET['error'] == 1)
    $content = $content . "<h4>Недостаточно места или исчерпан лимит количества файлов.</h4>";
if ($_GET['error'] == 2)
    $content = $content . "<h4>Файл пуст.</h4>";
$filesmb = round($files / 1024 / 1024, 2);
$content = $content . "Оставшееся место: $filesmb Мб или $filesn файлов.<br />
<form enctype='multipart/form-data' action='/ftp/upload.php' method='POST'>
<input type='hidden' name='MAX_FILE_SIZE' value='$files' />
Отправить файл: <input name='userfile' type='file' /><br />
Разрешить доступ для всех, у кого есть ссылка: <input type='checkbox' value='1' name='access'/><br />
<input type='submit' value=' Залить ' />
</form>
<h4><a href='/user/files.php'>Список загруженных файлов</a></h4>
</div>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>