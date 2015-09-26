<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if (isset($_SESSION['id']) != 0) {
    $file_id = mysql_real_escape_string($_GET['id']);
    mysql_select_db("files") or die (mysql_error());
    $query = "SELECT * FROM `files_$id` WHERE `id`='$file_id' LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());
    $file = mysql_fetch_assoc($sql);
    $dl_file = "C:/Program Files (x86)/Apache Software Foundation/Apache2.2/htdocs" . $file['file'];
    if (file_exists($dl_file)) {
        unlink($dl_file);
        $query = "DELETE FROM `files_$id` WHERE `id`='$file_id'";
        $sql = mysql_query($query) or die(mysql_error());
        $filesn++;
        $files = $files + $file['size'];
        mysql_select_db("main") or die (mysql_error());
        $query = "UPDATE `users` SET `files`='$files' WHERE id='$id'";
        $sql = mysql_query($query) or die(mysql_error());
        $query = "UPDATE `users` SET `filesn`='$filesn' WHERE id='$id'";
        $sql = mysql_query($query) or die(mysql_error());
        include('../engine/main_stat.php');
        header('Location: /user/files.php');
    }
} else {
    include('../engine/main_stat.php');
    header('Location: /error/denied.php');
    exit();
}
?>