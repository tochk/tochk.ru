<?php
session_start();
$title = "Файлы";
if (isset($_SESSION['id']) == 0) {
    header('Location: /error/denied.php');
    exit();
}

include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$content = "<br />";
mysql_select_db("files") or die (mysql_error());
$result = mysql_query("SELECT * FROM files_$id ORDER BY id DESC");
$files = mysql_fetch_array($result, MYSQL_ASSOC);
for ($top = 0; $top < mysql_num_rows($result); $top++) {
    $content = $content . "<div style='margin: 0; padding: 0; float: left;'>" . date('H:i d.m.Y', $files['time']) . " - </div>
    <form action='/ftp/download.php?file_id={$files['id']}&id=$id&key={$files['fkey']}' method='POST' style='margin: 0; margin-top: -3px; padding: 0; float: left;'>
    <input size=40 type='text' value='http://tochk.ru/ftp/download.php?file_id={$files['id']}&id=$id&key={$files['fkey']}' onclick='this.select()' />";
    if ($files['access'] == 0)
        $content = $content . "<a href='/ftp/access.php?id={$files['id']}'>Открыть доступ</a>";
    else
        $content = $content . "<a href='/ftp/access.php?id={$files['id']}'>Закрыть доступ</a>";
    $content = $content . "<input type='submit' value=' Скачать {$files['name']}' />
    <a href='/ftp/delete.php?id={$files['id']}'><img src='/design/images/delete.png' alt='Удалить файл' style='margin: -3px; padding: 0;'/></a>
    </form><br /><br />
    ";
    if ($top == 0) $content = $content . "<br />";
    $files = mysql_fetch_array($result, MYSQL_ASSOC);
}
if (mysql_num_rows($result) == 0)
    $content = $content . "<h4>Вы пока не загрузили ни одного файла, но вы всегда можете сделать это <a href='/ftp/'>здесь</a>.</h4>";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>